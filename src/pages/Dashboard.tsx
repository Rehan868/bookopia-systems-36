
import React from 'react';
import { StatCard } from '@/components/dashboard/StatCard';
import { TodayActivity } from '@/components/dashboard/TodayActivity';
import { RecentBookings } from '@/components/dashboard/RecentBookings';
import { OccupancyChart } from '@/components/dashboard/OccupancyChart';
import { QuickButtons } from '@/components/dashboard/QuickButtons';
import { Loader, BedDouble, ArrowDownToLine, ArrowUpFromLine, Percent } from 'lucide-react';
import { useDashboardStats } from '@/hooks/useDashboardStats';
import { DashboardStats } from '@/services/supabase-types';

export default function Dashboard() {
  const { data: stats, isLoading, error } = useDashboardStats();
  
  if (isLoading) {
    return (
      <div className="flex items-center justify-center h-96">
        <Loader className="h-8 w-8 animate-spin text-primary" />
        <span className="ml-2">Loading dashboard data...</span>
      </div>
    );
  }
  
  if (error) {
    return (
      <div className="p-6 text-center">
        <div className="text-red-500 mb-2">Failed to load dashboard data</div>
        <button
          className="px-4 py-2 bg-primary text-white rounded hover:bg-primary/90"
          onClick={() => window.location.reload()}
        >
          Retry
        </button>
      </div>
    );
  }
  
  const safeStats: DashboardStats = stats || {
    totalRooms: 0,
    availableRooms: 0,
    occupiedRooms: 0,
    todayCheckins: 0,
    todayCheckouts: 0,
    revenue: { today: 0, thisWeek: 0, thisMonth: 0 },
    occupancyRate: 0,
    recentBookings: [],
    weeklyOccupancyTrend: [0, 0, 0, 0, 0, 0, 0]
  };
  
  const weeklyOccupancyTrend = stats?.weeklyOccupancyTrend || [0, 0, 0, 0, 0, 0, 0];
  
  return (
    <div className="animate-fade-in space-y-8">
      <h1 className="text-3xl font-bold">Dashboard</h1>
      
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <StatCard 
          title="Available Rooms" 
          value={safeStats.availableRooms} 
          total={safeStats.totalRooms} 
          trend="up"
          trendDirection="up"
          trendValue="+2 from yesterday"
          icon={BedDouble}
        />
        <StatCard 
          title="Today's Check-ins" 
          value={safeStats.todayCheckins} 
          trend="neutral"
          trendDirection="neutral"
          trendValue="Same as yesterday"
          icon={ArrowDownToLine}
        />
        <StatCard 
          title="Today's Check-outs" 
          value={safeStats.todayCheckouts} 
          trend="up"
          trendDirection="up"
          trendValue="+2 from yesterday"
          icon={ArrowUpFromLine}
        />
        <StatCard 
          title="Occupancy Rate" 
          value={`${Math.round(safeStats.occupancyRate)}%`} 
          trend="up"
          trendDirection="up"
          trendValue="+3.2% from last week"
          icon={Percent}
        />
      </div>
      
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2 space-y-6">
          <OccupancyChart />
          <RecentBookings />
        </div>
        <div className="space-y-6">
          <QuickButtons />
          <TodayActivity />
        </div>
      </div>
    </div>
  );
}
