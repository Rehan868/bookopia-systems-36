import { useState, useEffect } from 'react';
import { supabase } from '../integrations/supabase';
import { DashboardStats, Booking } from '../services/supabase-types';
import { fetchBookings } from '../services/api';

export function useDashboardStats() {
  const [data, setData] = useState<DashboardStats | null>(null);
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [error, setError] = useState<Error | null>(null);
  
  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        
        // Get total rooms count
        const { data: roomsData, error: roomsError } = await supabase
          .from('rooms')
          .select('id, status');
        
        if (roomsError) throw roomsError;
        
        // Calculate room statistics
        const totalRooms = roomsData.length;
        const availableRooms = roomsData.filter(room => room.status === 'available').length;
        const occupiedRooms = roomsData.filter(room => room.status === 'occupied').length;
        const occupancyRate = totalRooms > 0 ? (occupiedRooms / totalRooms) * 100 : 0;
        
        // Get today's date
        const today = new Date().toISOString().split('T')[0];
        
        // Get today's check-ins
        const { data: checkinsData, error: checkinsError } = await supabase
          .from('bookings')
          .select('*')
          .eq('check_in', today)
          .eq('status', 'confirmed');
          
        if (checkinsError) throw checkinsError;
        
        // Get today's check-outs
        const { data: checkoutsData, error: checkoutsError } = await supabase
          .from('bookings')
          .select('*')
          .eq('check_out', today)
          .eq('status', 'checked-in');
          
        if (checkoutsError) throw checkoutsError;
        
        // Calculate revenue
        const todayStart = new Date();
        todayStart.setHours(0, 0, 0, 0);
        
        const weekStart = new Date();
        weekStart.setDate(weekStart.getDate() - weekStart.getDay());
        weekStart.setHours(0, 0, 0, 0);
        
        const monthStart = new Date();
        monthStart.setDate(1);
        monthStart.setHours(0, 0, 0, 0);
        
        // Get completed bookings for revenue calculations
        const { data: revenueData, error: revenueError } = await supabase
          .from('bookings')
          .select('amount, check_out')
          .in('status', ['checked-out'])
          .gte('check_out', monthStart.toISOString().split('T')[0]);
          
        if (revenueError) throw revenueError;
        
        // Calculate revenue for different periods
        const todayRevenue = revenueData
          .filter(booking => booking.check_out === today)
          .reduce((sum, booking) => sum + booking.amount, 0);
          
        const weekRevenue = revenueData
          .filter(booking => new Date(booking.check_out) >= weekStart)
          .reduce((sum, booking) => sum + booking.amount, 0);
          
        const monthRevenue = revenueData.reduce((sum, booking) => sum + booking.amount, 0);
        
        // Get recent bookings
        const { data: recentBookings, error: recentBookingsError } = await supabase
          .from('bookings')
          .select('*, rooms(number, property:type)')
          .order('created_at', { ascending: false })
          .limit(5);
          
        if (recentBookingsError) throw recentBookingsError;
        
        // Set the dashboard stats
        setData({
          totalRooms,
          availableRooms,
          occupiedRooms,
          todayCheckins: checkinsData.length,
          todayCheckouts: checkoutsData.length,
          revenue: {
            today: todayRevenue,
            thisWeek: weekRevenue,
            thisMonth: monthRevenue
          },
          occupancyRate,
          recentBookings: recentBookings as Booking[]
        });
        
        setIsLoading(false);
      } catch (err) {
        console.error('Error fetching dashboard stats:', err);
        setError(err as Error);
        setIsLoading(false);
      }
    };
    
    fetchData();
  }, []);
  
  return { data, isLoading, error };
}
