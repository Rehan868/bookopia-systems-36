import React, { useState, useMemo, useEffect } from 'react';
import { Card } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { ArrowRight, CalendarClock, DoorOpen, Edit, MoreHorizontal, User, Loader, CheckCircle, XCircle } from 'lucide-react';
import { ViewToggle } from '@/components/ui/ViewToggle';
import { 
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
  DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import { Link, useNavigate } from 'react-router-dom';
import { useBookings } from '@/hooks/useBookings';
import { useToast } from '@/hooks/use-toast';
import { format } from 'date-fns';
import { DateRange } from 'react-day-picker';
import { supabase } from '@/integrations/supabase';
import { Booking } from '@/services/supabase-types';
import { createBookingNotification } from '@/services/notification.service';
import { updateBookingStatus, updateRoomStatus } from '@/services/api';

function formatDate(dateString: string) {
  try {
    return format(new Date(dateString), 'MMM d, yyyy');
  } catch (e) {
    return dateString;
  }
}

function getStatusBadge(status: string) {
  switch (status) {
    case 'confirmed':
      return <Badge className="bg-green-100 text-green-800">Confirmed</Badge>;
    case 'checked-in':
      return <Badge className="bg-blue-100 text-blue-800">Checked In</Badge>;
    case 'checked-out':
      return <Badge className="bg-purple-100 text-purple-800">Checked Out</Badge>;
    case 'cancelled':
      return <Badge className="bg-red-100 text-red-800">Cancelled</Badge>;
    case 'pending':
      return <Badge className="bg-yellow-100 text-yellow-800">Pending</Badge>;
    case 'no-show':
      return <Badge className="bg-gray-100 text-gray-800">No Show</Badge>;
    default:
      return <Badge className="bg-gray-100 text-gray-800">{status}</Badge>;
  }
}

interface BookingListProps {
  view: 'grid' | 'list';
  onViewChange: (view: 'grid' | 'list') => void;
  searchQuery?: string;
  filterValue?: string;
  dateRange?: DateRange;
}

export function BookingList({ 
  view, 
  onViewChange,
  searchQuery = '',
  filterValue = 'all',
  dateRange
}: BookingListProps) {
  const { data: bookings, isLoading, error, updateBooking } = useBookings();
  const { toast } = useToast();
  const navigate = useNavigate();
  const [processingId, setProcessingId] = useState<string | null>(null);

  // Set up real-time subscription for booking updates
  useEffect(() => {
    const subscription = supabase
      .channel('bookings-channel')
      .on('postgres_changes', 
        { 
          event: '*', 
          schema: 'public', 
          table: 'bookings' 
        }, 
        (payload) => {
          // Force refresh data
          window.location.reload();
        }
      )
      .subscribe();

    return () => {
      subscription.unsubscribe();
    };
  }, []);

  // Apply filters to bookings
  const filteredBookings = useMemo(() => {
    if (!bookings) return [];
    
    return bookings.filter(booking => {
      // Apply search filter
      const searchLower = searchQuery.toLowerCase();
      const matchesSearch = 
        !searchQuery || 
        booking.guest_name.toLowerCase().includes(searchLower) ||
        booking.booking_number.toLowerCase().includes(searchLower) ||
        (booking.rooms?.number?.toLowerCase().includes(searchLower) ?? false) ||
        (booking.rooms?.property?.toLowerCase().includes(searchLower) ?? false);
      
      // Apply status filter
      const matchesStatus = filterValue === 'all' || booking.status === filterValue;
      
      // Apply date filter
      let matchesDate = true;
      if (dateRange?.from) {
        const bookingCheckIn = new Date(booking.check_in);
        const bookingCheckOut = new Date(booking.check_out);
        const filterFrom = dateRange.from;
        const filterTo = dateRange.to || dateRange.from;

        // Check if the booking dates overlap with the filter dates
        matchesDate = 
          (bookingCheckIn <= filterTo && 
          (dateRange.to ? bookingCheckOut >= filterFrom : true));
      }
      
      return matchesSearch && matchesStatus && matchesDate;
    });
  }, [bookings, searchQuery, filterValue, dateRange]);

  // Handle check-in/check-out
  const handleStatusChange = async (booking: Booking, newStatus: string) => {
    try {
      setProcessingId(booking.id);
      
      // Update booking status
      await updateBookingStatus(booking.id, newStatus);
      
      // Update room status if needed
      if (booking.room_id) {
        if (newStatus === 'checked-in') {
          await updateRoomStatus(booking.room_id, 'occupied');
        } else if (newStatus === 'checked-out') {
          // When checking out, set room to cleaning status
          await updateRoomStatus(booking.room_id, 'cleaning');
          
          // Create cleaning task for this room
          const today = new Date().toISOString().split('T')[0];
          
          await supabase.from('cleaning_tasks').insert({
            room_id: booking.room_id,
            property_id: booking.property_id,
            date: today,
            status: 'pending',
            notes: `Cleaning required after checkout (booking #${booking.booking_number})`,
            created_at: new Date().toISOString()
          });
        }
      }
      
      // Create notification for the event
      const eventType = newStatus === 'checked-in' ? 'checked-in' : 
                       (newStatus === 'checked-out' ? 'checked-out' : 'updated');
      await createBookingNotification(booking, eventType);
      
      // Show success toast
      toast({
        title: newStatus === 'checked-in' ? 'Guest Checked In' : 'Guest Checked Out',
        description: `${booking.guest_name} has been ${
          newStatus === 'checked-in' ? 'checked in' : 'checked out'
        } successfully.`,
      });
      
      // Update local state
      if (updateBooking) {
        await updateBooking(booking.id, { status: newStatus });
      }
      
    } catch (error) {
      console.error('Error updating booking status:', error);
      toast({
        variant: 'destructive',
        title: 'Operation Failed',
        description: `Failed to update booking status. Please try again.`,
      });
    } finally {
      setProcessingId(null);
    }
  };

  const handleCancelBooking = async (booking: Booking) => {
    try {
      setProcessingId(booking.id);
      
      // Update booking status
      await updateBookingStatus(booking.id, 'cancelled');
      
      // Free up the room
      if (booking.room_id) {
        await updateRoomStatus(booking.room_id, 'available');
      }
      
      // Create notification
      await createBookingNotification(booking, 'cancelled');
      
      // Show success toast
      toast({
        title: 'Booking Cancelled',
        description: `Booking #${booking.booking_number} has been cancelled.`,
      });
      
      // Update local state
      if (updateBooking) {
        await updateBooking(booking.id, { status: 'cancelled' });
      }
      
    } catch (error) {
      console.error('Error cancelling booking:', error);
      toast({
        variant: 'destructive',
        title: 'Operation Failed',
        description: `Failed to cancel booking. Please try again.`,
      });
    } finally {
      setProcessingId(null);
    }
  };

  if (isLoading) {
    return (
      <div className="flex items-center justify-center h-64">
        <Loader className="h-8 w-8 animate-spin text-primary" />
        <span className="ml-2">Loading bookings...</span>
      </div>
    );
  }

  if (error) {
    return (
      <div className="flex flex-col items-center justify-center h-64">
        <p className="text-red-500">Failed to load bookings data</p>
        <Button 
          variant="outline" 
          className="mt-4"
          onClick={() => window.location.reload()}
        >
          Retry
        </Button>
      </div>
    );
  }

  return (
    <div>
      <div className="flex justify-between items-center mb-6">
        <h2 className="text-2xl font-bold">All Bookings</h2>
        <div className="flex gap-4">
          <ViewToggle view={view} setView={onViewChange} />
        </div>
      </div>
      
      {view === 'list' ? (
        <div className="rounded-lg overflow-hidden border border-border">
          <table className="w-full">
            <thead className="bg-muted">
              <tr>
                <th className="text-left font-medium px-6 py-3">Guest</th>
                <th className="text-left font-medium px-6 py-3">Room</th>
                <th className="text-left font-medium px-6 py-3">Check In</th>
                <th className="text-left font-medium px-6 py-3">Check Out</th>
                <th className="text-left font-medium px-6 py-3">Status</th>
                <th className="text-left font-medium px-6 py-3">Amount</th>
                <th className="text-left font-medium px-6 py-3">Paid</th>
                <th className="text-left font-medium px-6 py-3">Remaining</th>
                <th className="text-left font-medium px-6 py-3">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-border">
              {filteredBookings.map((booking) => {
                const room = booking.rooms;
                return (
                  <tr key={booking.id} className="hover:bg-muted/50 transition-colors">
                    <td className="px-6 py-4">
                      <div className="font-medium">{booking.guest_name}</div>
                      <div className="text-sm text-muted-foreground">{booking.booking_number}</div>
                    </td>
                    <td className="px-6 py-4">
                      {room?.number || 'Unknown'}, {room?.property || 'Unknown'}
                    </td>
                    <td className="px-6 py-4">{formatDate(booking.check_in)}</td>
                    <td className="px-6 py-4">{formatDate(booking.check_out)}</td>
                    <td className="px-6 py-4">{getStatusBadge(booking.status)}</td>
                    <td className="px-6 py-4">${booking.amount?.toFixed(2) || '0.00'}</td>
                    <td className="px-6 py-4">${booking.amount_paid?.toFixed(2) || '0.00'}</td>
                    <td className="px-6 py-4">${booking.remaining_amount?.toFixed(2) || '0.00'}</td>
                    <td className="px-6 py-4">
                      <div className="flex items-center space-x-2">
                        <Button size="sm" variant="ghost" asChild>
                          <Link to={`/bookings/${booking.id}`}>
                            <ArrowRight className="h-4 w-4" />
                          </Link>
                        </Button>
                        <DropdownMenu>
                          <DropdownMenuTrigger asChild>
                            <Button size="sm" variant="ghost" disabled={!!processingId}>
                              <MoreHorizontal className="h-4 w-4" />
                            </Button>
                          </DropdownMenuTrigger>
                          <DropdownMenuContent align="end">
                            <DropdownMenuItem asChild>
                              <Link to={`/bookings/${booking.id}`}>View Details</Link>
                            </DropdownMenuItem>
                            
                            {booking.status === 'confirmed' && (
                              <DropdownMenuItem 
                                onClick={() => handleStatusChange(booking, 'checked-in')}
                                disabled={processingId === booking.id}
                              >
                                <CheckCircle className="h-4 w-4 mr-2" />
                                Check In
                              </DropdownMenuItem>
                            )}
                            
                            {booking.status === 'checked-in' && (
                              <DropdownMenuItem 
                                onClick={() => handleStatusChange(booking, 'checked-out')}
                                disabled={processingId === booking.id}
                              >
                                <CheckCircle className="h-4 w-4 mr-2" />
                                Check Out
                              </DropdownMenuItem>
                            )}
                            
                            <DropdownMenuItem asChild>
                              <Link to={`/bookings/${booking.id}/edit`}>
                                <Edit className="h-4 w-4 mr-2" />
                                Edit
                              </Link>
                            </DropdownMenuItem>
                            
                            <DropdownMenuSeparator />
                            
                            {(booking.status === 'confirmed' || booking.status === 'pending') && (
                              <DropdownMenuItem 
                                className="text-red-600"
                                onClick={() => handleCancelBooking(booking)}
                                disabled={processingId === booking.id}
                              >
                                <XCircle className="h-4 w-4 mr-2" />
                                Cancel Booking
                              </DropdownMenuItem>
                            )}
                          </DropdownMenuContent>
                        </DropdownMenu>
                      </div>
                    </td>
                  </tr>
                );
              })}
              {(!filteredBookings || filteredBookings.length === 0) && (
                <tr>
                  <td colSpan={9} className="px-6 py-8 text-center text-muted-foreground">
                    No bookings found
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      ) : (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredBookings.map((booking) => {
            const room = booking.rooms;
            return (
              <Card key={booking.id} className="overflow-hidden hover:shadow-md transition-shadow">
                <div className="p-6">
                  <div className="flex flex-col gap-4">
                    <div className="flex justify-between">
                      <div className="flex items-center gap-3">
                        <div className="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                          <User className="h-5 w-5" />
                        </div>
                        <div>
                          <p className="font-medium">{booking.guest_name}</p>
                          <p className="text-sm text-muted-foreground">{booking.booking_number}</p>
                        </div>
                      </div>
                      {getStatusBadge(booking.status)}
                    </div>
                      
                    <div className="border-t pt-4 mt-1 space-y-3">
                      <div className="flex items-center gap-3">
                        <div className="p-1.5 bg-muted rounded-md">
                          <DoorOpen className="h-4 w-4 text-muted-foreground" />
                        </div>
                        <div>
                          <p className="text-xs font-medium text-muted-foreground">ROOM</p>
                          <p className="text-sm">{room?.number || 'Unknown'}, {room?.property || 'Unknown'}</p>
                        </div>
                      </div>
                      
                      <div className="flex items-center gap-3">
                        <div className="p-1.5 bg-muted rounded-md">
                          <CalendarClock className="h-4 w-4 text-muted-foreground" />
                        </div>
                        <div>
                          <p className="text-xs font-medium text-muted-foreground">DATES</p>
                          <p className="text-sm">{formatDate(booking.check_in)} - {formatDate(booking.check_out)}</p>
                        </div>
                      </div>
                      
                      <div className="flex items-center gap-3">
                        <div className="p-1.5 bg-muted rounded-md">
                          <div className="font-semibold text-xs text-muted-foreground">$</div>
                        </div>
                        <div>
                          <p className="text-xs font-medium text-muted-foreground">AMOUNT</p>
                          <p className="text-sm">${booking.amount}</p>
                        </div>
                      </div>
                    </div>
                    
                    <div className="flex gap-2 border-t pt-4">
                      {booking.status === 'confirmed' && (
                        <Button 
                          size="sm" 
                          className="mr-auto"
                          onClick={() => handleStatusChange(booking, 'checked-in')}
                          disabled={processingId === booking.id}
                        >
                          <CheckCircle className="h-3.5 w-3.5 mr-1" />
                          Check In
                        </Button>
                      )}
                      
                      {booking.status === 'checked-in' && (
                        <Button 
                          size="sm"
                          className="mr-auto"
                          onClick={() => handleStatusChange(booking, 'checked-out')}
                          disabled={processingId === booking.id}
                        >
                          <CheckCircle className="h-3.5 w-3.5 mr-1" />
                          Check Out
                        </Button>
                      )}
                      
                      <Button size="sm" variant="outline" asChild>
                        <Link to={`/bookings/${booking.id}/edit`}>
                          <Edit className="h-3.5 w-3.5 mr-1" />
                          Edit
                        </Link>
                      </Button>
                      <Button size="sm" asChild>
                        <Link to={`/bookings/${booking.id}`}>
                          View
                        </Link>
                      </Button>
                    </div>
                  </div>
                </div>
              </Card>
            );
          })}
          {(!filteredBookings || filteredBookings.length === 0) && (
            <div className="col-span-full text-center py-10 border rounded-md bg-muted/10">
              <p className="text-muted-foreground">No bookings found</p>
            </div>
          )}
        </div>
      )}
    </div>
  );
}
