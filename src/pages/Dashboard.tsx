
import React from 'react';
import { StatCard } from '@/components/dashboard/StatCard';
import { TodayActivity } from '@/components/dashboard/TodayActivity';
import { RecentBookings } from '@/components/dashboard/RecentBookings';
import { OccupancyChart } from '@/components/dashboard/OccupancyChart';
import { QuickButtons } from '@/components/dashboard/QuickButtons';
import { Loader } from 'lucide-react';
import { useDashboardStats } from '@/hooks/useDashboardStats';

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
  
  const weeklyOccupancyTrend = stats?.weeklyOccupancyTrend || [0, 0, 0, 0, 0, 0, 0];
  
  return (
    <div className="animate-fade-in space-y-8">
      <h1 className="text-3xl font-bold">Dashboard</h1>
      
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <StatCard 
          title="Available Rooms" 
          value={stats?.availableRooms || 0} 
          total={stats?.totalRooms || 0} 
          trend={5}
          trendDirection="up"
          icon="rooms"
        />
        <StatCard 
          title="Today's Check-ins" 
          value={stats?.todayCheckins || 0} 
          trend={0}
          trendDirection="neutral"
          icon="check-in"
        />
        <StatCard 
          title="Today's Check-outs" 
          value={stats?.todayCheckouts || 0} 
          trend={2}
          trendDirection="up"
          icon="check-out"
        />
        <StatCard 
          title="Occupancy Rate" 
          value={`${Math.round(stats?.occupancyRate || 0)}%`} 
          trend={3.2}
          trendDirection="up"
          icon="percentage"
        />
      </div>
      
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2 space-y-6">
          <OccupancyChart data={weeklyOccupancyTrend as number[]} />
          <RecentBookings bookings={stats?.recentBookings || []} />
        </div>
        <div className="space-y-6">
          <QuickButtons />
          <TodayActivity />
        </div>
      </div>
    </div>
  );
}
