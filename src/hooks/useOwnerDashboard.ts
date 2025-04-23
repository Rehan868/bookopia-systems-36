
import { useState, useEffect } from 'react';
import { supabase } from '../integrations/supabase';
import { Room, Booking, CleaningTask } from '../services/supabase-types';
import { useAuth } from './use-auth';

interface OwnerDashboardStats {
  totalRooms: number;
  availableRooms: number;
  occupiedRooms: number;
  upcomingCheckIns: number;
  upcomingCheckOuts: number;
  monthlyEarnings: number;
  yearlyEarnings: number;
  occupancyRate: number;
}

export function useOwnerDashboard() {
  const { user } = useAuth();
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<Error | null>(null);
  const [stats, setStats] = useState<OwnerDashboardStats | null>(null);
  const [rooms, setRooms] = useState<Room[]>([]);
  const [bookings, setBookings] = useState<Booking[]>([]);
  const [cleaningTasks, setCleaningTasks] = useState<CleaningTask[]>([]);

  useEffect(() => {
    const fetchOwnerData = async () => {
      try {
        setIsLoading(true);
        
        if (!user?.email) {
          throw new Error('User not authenticated or email not available');
        }
        
        // Step 1: Get the owner's ID based on email
        const { data: ownerData, error: ownerError } = await supabase
          .from('owners')
          .select('id')
          .eq('email', user.email)
          .single();
          
        if (ownerError) throw ownerError;
        if (!ownerData) throw new Error('Owner not found');
        
        const ownerId = ownerData.id;
        
        // Step 2: Get all rooms owned by this owner
        const { data: ownershipData, error: ownershipError } = await supabase
          .from('property_ownership')
          .select('room_id')
          .eq('owner_id', ownerId);
          
        if (ownershipError) throw ownershipError;
        
        if (!ownershipData || ownershipData.length === 0) {
          // No rooms owned by this owner
          setRooms([]);
          setBookings([]);
          setCleaningTasks([]);
          setStats({
            totalRooms: 0,
            availableRooms: 0,
            occupiedRooms: 0,
            upcomingCheckIns: 0,
            upcomingCheckOuts: 0,
            monthlyEarnings: 0,
            yearlyEarnings: 0,
            occupancyRate: 0
          });
          setIsLoading(false);
          return;
        }
        
        // Get all room IDs owned by this owner
        const roomIds = ownershipData.map(item => item.room_id);
        
        // Step 3: Get room details
        const { data: roomsData, error: roomsError } = await supabase
          .from('rooms')
          .select('*, room_types(name, base_rate), properties(name, address, city)')
          .in('id', roomIds);
          
        if (roomsError) throw roomsError;
        
        // Transform to match the Room interface
        const transformedRooms = roomsData?.map(room => {
          return {
            ...room,
            property: room.properties?.name,
            name: room.number, // Using number as name for backward compatibility
            room_types: {
              id: '',
              name: room.room_types?.name || '',
              base_rate: room.room_types?.base_rate || 0,
              max_occupancy: 0
            }
          } as unknown as Room;
        }) || [];
        
        setRooms(transformedRooms);
        
        // Step 4: Get bookings for these rooms
        const { data: bookingsData, error: bookingsError } = await supabase
          .from('bookings')
          .select('*')
          .in('room_id', roomIds)
          .order('check_in', { ascending: true });
          
        if (bookingsError) throw bookingsError;
        
        // Transform to match the Booking interface
        const transformedBookings = bookingsData?.map(booking => {
          return {
            ...booking,
            adults: booking.adults || 2,
            children: booking.children || 0,
            netToOwner: booking.net_to_owner || 0, // For backward compatibility
            notes: booking.special_requests
          } as unknown as Booking;
        }) || [];
        
        setBookings(transformedBookings);
        
        // Step 5: Get cleaning tasks for these rooms
        const { data: tasksData, error: tasksError } = await supabase
          .from('cleaning_tasks')
          .select('*, rooms(number, floor, type)')
          .in('room_id', roomIds)
          .order('date', { ascending: false });
          
        if (tasksError) throw tasksError;
        
        // Transform to match the CleaningTask interface
        const transformedTasks = tasksData?.map(task => {
          return {
            ...task,
            rooms: {
              id: task.room_id,
              number: task.rooms?.number || '',
              floor: task.rooms?.floor || '',
              type: task.rooms?.type || '',
              capacity: 0,
              rate: 0,
              status: ''
            } as Room
          } as unknown as CleaningTask;
        }) || [];
        
        setCleaningTasks(transformedTasks);
        
        // Step 6: Calculate dashboard statistics
        const availableRooms = roomsData?.filter(room => room.status === 'available').length || 0;
        const occupiedRooms = roomsData?.filter(room => room.status === 'occupied').length || 0;
        const totalRooms = roomsData?.length || 0;
        
        // Calculate upcoming check-ins (next 7 days)
        const today = new Date();
        const nextWeek = new Date();
        nextWeek.setDate(today.getDate() + 7);
        
        const upcomingCheckIns = bookingsData?.filter(booking => {
          const checkInDate = new Date(booking.check_in);
          return checkInDate >= today && checkInDate <= nextWeek && booking.status === 'confirmed';
        }).length || 0;
        
        // Calculate upcoming check-outs (next 7 days)
        const upcomingCheckOuts = bookingsData?.filter(booking => {
          const checkOutDate = new Date(booking.check_out);
          return checkOutDate >= today && checkOutDate <= nextWeek && booking.status === 'checked-in';
        }).length || 0;
        
        // Calculate earnings
        const currentMonth = today.getMonth();
        const currentYear = today.getFullYear();
        
        const monthlyEarnings = bookingsData?.reduce((sum, booking) => {
          const checkOutDate = new Date(booking.check_out);
          if (
            checkOutDate.getMonth() === currentMonth && 
            checkOutDate.getFullYear() === currentYear && 
            booking.status === 'checked-out'
          ) {
            return sum + (booking.net_to_owner || 0);
          }
          return sum;
        }, 0) || 0;
        
        const yearlyEarnings = bookingsData?.reduce((sum, booking) => {
          const checkOutDate = new Date(booking.check_out);
          if (
            checkOutDate.getFullYear() === currentYear && 
            booking.status === 'checked-out'
          ) {
            return sum + (booking.net_to_owner || 0);
          }
          return sum;
        }, 0) || 0;
        
        // Calculate occupancy rate
        const occupancyRate = totalRooms > 0 ? (occupiedRooms / totalRooms * 100) : 0;
        
        setStats({
          totalRooms,
          availableRooms,
          occupiedRooms,
          upcomingCheckIns,
          upcomingCheckOuts,
          monthlyEarnings,
          yearlyEarnings,
          occupancyRate
        });
        
        setIsLoading(false);
      } catch (err) {
        console.error('Error fetching owner dashboard data:', err);
        setError(err as Error);
        setIsLoading(false);
      }
    };
    
    if (user) {
      fetchOwnerData();
    }
  }, [user]);
  
  return {
    isLoading,
    error,
    stats,
    rooms,
    bookings,
    cleaningTasks
  };
}
