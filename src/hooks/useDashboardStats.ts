
import { useQuery } from "@tanstack/react-query";
import { supabase } from "@/integrations/supabase/client";

// Define types for dashboard statistics
export interface DashboardStats {
  totalBookings: number;
  totalRevenue: number;
  occupancyRate: number;
  pendingCheckIns: number;
  recentBookings: any[];
  monthlyRevenue: number[];
  // Additional properties needed by Dashboard.tsx
  availableRooms: number;
  totalRooms: number;
  todayCheckIns: number;
  todayCheckOuts: number;
  weeklyOccupancyTrend: string;
}

export const useDashboardStats = () => {
  return useQuery({
    queryKey: ["dashboardStats"],
    queryFn: async (): Promise<DashboardStats> => {
      try {
        // Fetch bookings with total price for revenue calculation
        const { data: bookings, error: bookingsError } = await supabase
          .from('bookings')
          .select('*');

        if (bookingsError) throw bookingsError;

        // Fetch rooms for occupancy calculation
        const { data: rooms, error: roomsError } = await supabase
          .from('rooms')
          .select('*');

        if (roomsError) throw roomsError;

        // Calculate total bookings
        const totalBookings = bookings?.length || 0;

        // Calculate total revenue
        const totalRevenue = bookings?.reduce((sum, booking) => {
          return sum + (booking.total_price || 0);
        }, 0) || 0;

        // Calculate occupancy rate
        const occupiedRooms = rooms?.filter(room => room.status === 'occupied')?.length || 0;
        const totalRooms = rooms?.length || 0;
        const availableRooms = rooms?.filter(room => room.status === 'available')?.length || 0;
        const occupancyRate = totalRooms > 0 ? (occupiedRooms / totalRooms) * 100 : 0;

        // Count pending check-ins
        const today = new Date().toISOString().split('T')[0];
        const todayCheckIns = bookings?.filter(booking => 
          booking.check_in_date === today && 
          booking.status === 'confirmed'
        )?.length || 0;

        const todayCheckOuts = bookings?.filter(booking => 
          booking.check_out_date === today && 
          booking.status === 'checked-in'
        )?.length || 0;

        const pendingCheckIns = todayCheckIns;

        // Generate mock monthly revenue data for the chart
        // In a real application, this would be calculated from actual booking data
        const monthlyRevenue = [
          totalRevenue * 0.7,
          totalRevenue * 0.8,
          totalRevenue * 0.75, 
          totalRevenue * 0.9,
          totalRevenue * 1.1,
          totalRevenue * 1.2,
          totalRevenue * 1.1,
          totalRevenue * 1.15,
          totalRevenue * 1.05,
          totalRevenue * 0.95,
          totalRevenue * 0.85,
          totalRevenue * 1.0
        ];

        // Return formatted dashboard stats
        return {
          totalBookings,
          totalRevenue,
          occupancyRate,
          pendingCheckIns,
          recentBookings: bookings?.slice(0, 5) || [],
          monthlyRevenue,
          availableRooms,
          totalRooms,
          todayCheckIns,
          todayCheckOuts,
          weeklyOccupancyTrend: "+5%" // Mock trend data
        };
      } catch (error) {
        console.error('Error fetching dashboard stats:', error);
        throw error;
      }
    },
    staleTime: 1000 * 60, // 1 minute
  });
};
