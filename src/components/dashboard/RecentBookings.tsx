
import React from 'react';
import { cn } from '@/lib/utils';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { CalendarClock, Clock, User } from 'lucide-react';
import { Booking } from '@/services/supabase-types';

interface RecentBookingsProps {
  bookings?: Booking[];
}

// Default mock data - would come from API in real app
const defaultBookings = [
  {
    id: 'B1001',
    guest_name: 'John Smith',
    room_id: '101',
    rooms: { number: '101', property: 'Deluxe Suite' },
    check_in: '2023-06-15',
    check_out: '2023-06-18',
    status: 'confirmed',
    created_at: '2023-06-01T10:30:00'
  },
  {
    id: 'B1002',
    guest_name: 'Emma Johnson',
    room_id: '205',
    rooms: { number: '205', property: 'Executive Room' },
    check_in: '2023-06-14',
    check_out: '2023-06-16',
    status: 'checked-in',
    created_at: '2023-06-10T14:45:00'
  },
  {
    id: 'B1003',
    guest_name: 'Michael Chen',
    room_id: '304',
    rooms: { number: '304', property: 'Standard Room' },
    check_in: '2023-06-12',
    check_out: '2023-06-13',
    status: 'checked-out',
    created_at: '2023-06-08T09:15:00'
  },
  {
    id: 'B1004',
    guest_name: 'Sarah Davis',
    room_id: '102',
    rooms: { number: '102', property: 'Deluxe Suite' },
    check_in: '2023-06-18',
    check_out: '2023-06-20',
    status: 'confirmed',
    created_at: '2023-06-11T16:20:00'
  }
] as unknown as Booking[];

function formatDate(dateString: string) {
  return new Date(dateString).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  });
}

function getStatusColor(status: string) {
  switch (status) {
    case 'confirmed':
      return 'bg-blue-100 text-blue-800';
    case 'checked-in':
      return 'bg-green-100 text-green-800';
    case 'checked-out':
      return 'bg-gray-100 text-gray-800';
    case 'cancelled':
      return 'bg-red-100 text-red-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
}

export function RecentBookings({ bookings = defaultBookings }: RecentBookingsProps) {
  return (
    <Card className="overflow-hidden transition-all duration-200 hover:shadow-md">
      <CardHeader className="pb-4">
        <CardTitle>Recent Bookings</CardTitle>
        <CardDescription>Latest booking activity across all properties</CardDescription>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          {bookings.map((booking) => (
            <div key={booking.id} className="flex items-center justify-between py-3 border-b border-border last:border-0">
              <div className="flex flex-col">
                <div className="flex items-center gap-2">
                  <span className="font-medium">{booking.guest_name}</span>
                  <Badge className={cn("text-xs font-normal", getStatusColor(booking.status))}>
                    {booking.status.replace('-', ' ')}
                  </Badge>
                </div>
                <div className="flex items-center gap-4 mt-2 text-sm text-muted-foreground">
                  <div className="flex items-center gap-1">
                    <User className="h-3.5 w-3.5" />
                    <span>{booking.rooms?.number} - {booking.rooms?.property}</span>
                  </div>
                  <div className="flex items-center gap-1">
                    <CalendarClock className="h-3.5 w-3.5" />
                    <span>{formatDate(booking.check_in)} - {formatDate(booking.check_out)}</span>
                  </div>
                </div>
              </div>
              <div className="flex items-center gap-2">
                <Button variant="outline" size="sm">Details</Button>
                {booking.status === 'confirmed' && (
                  <Button size="sm">Check In</Button>
                )}
              </div>
            </div>
          ))}
          
          <div className="flex justify-center mt-2">
            <Button variant="outline" className="w-full">View All Bookings</Button>
          </div>
        </div>
      </CardContent>
    </Card>
  );
}
