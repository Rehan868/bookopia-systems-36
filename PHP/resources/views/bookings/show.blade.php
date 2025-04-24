
@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
    <div class="animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('bookings.index') }}" class="text-muted-foreground hover:text-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m15 18-6-6 6-6"></path></svg>
                    </a>
                    <h1 class="text-3xl font-bold">Booking Details</h1>
                </div>
                <p class="text-muted-foreground mt-1">Reference: {{ $booking['reference'] }}</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('bookings.edit', $booking['id']) }}" 
                   class="inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground">
                    Edit
                </a>
                <form action="{{ route('bookings.destroy', $booking['id']) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex h-10 items-center justify-center rounded-md bg-destructive px-4 py-2 text-sm font-medium text-destructive-foreground"
                            onclick="return confirm('Are you sure you want to delete this booking?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Booking Info -->
            <div class="lg:col-span-2">
                <div class="bg-card rounded-lg border shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Booking Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-muted-foreground mb-1">Guest Details</h4>
                            <p class="text-base font-medium">{{ $booking['guest_name'] }}</p>
                            <p class="text-sm">{{ $booking['guest_email'] }}</p>
                            <p class="text-sm">{{ $booking['guest_phone'] }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-muted-foreground mb-1">Room Details</h4>
                            <p class="text-base font-medium">Room {{ $booking['room'] }}</p>
                            <p class="text-sm">{{ $booking['room_type'] }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-muted-foreground mb-1">Stay Information</h4>
                            <p class="text-sm">Check In: <span class="font-medium">{{ $booking['check_in'] }}</span></p>
                            <p class="text-sm">Check Out: <span class="font-medium">{{ $booking['check_out'] }}</span></p>
                            <p class="text-sm">Guests: <span class="font-medium">{{ $booking['adults'] }} Adults, {{ $booking['children'] }} Children</span></p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-muted-foreground mb-1">Financial Details</h4>
                            <p class="text-sm">Total Amount: <span class="font-medium">${{ $booking['total_amount'] }}</span></p>
                            <p class="text-sm">Payment Status: 
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs {{ $booking['payment_status'] === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($booking['payment_status']) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-muted-foreground mb-1">Notes</h4>
                        <p class="text-sm p-3 bg-muted rounded-md">{{ $booking['notes'] }}</p>
                    </div>
                </div>
                
                <div class="bg-card rounded-lg border shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Booking History</h3>
                    
                    <div class="space-y-4">
                        <div class="flex">
                            <div class="mr-4 flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M16 13H8"></path><path d="M16 17H8"></path><path d="M10 9H8"></path></svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Booking Created</p>
                                <p class="text-xs text-muted-foreground">{{ $booking['created_at'] }}</p>
                                <p class="text-sm">Booking was created with status 'Confirmed'</p>
                            </div>
                        </div>
                        
                        <div class="flex">
                            <div class="mr-4 flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M11 8h10"></path><path d="M11 12h10"></path><path d="M11 16h10"></path><path d="M3 8h4v4H3z"></path><path d="M3 16h4v4H3z"></path></svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Booking Updated</p>
                                <p class="text-xs text-muted-foreground">{{ $booking['updated_at'] }}</p>
                                <p class="text-sm">Payment status changed from 'Pending' to 'Paid'</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div>
                <div class="bg-card rounded-lg border shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Booking Status</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs {{ $booking['status'] === 'confirmed' ? 'bg-green-100 text-green-800' : '' }} {{ $booking['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ ucfirst($booking['status']) }}
                            </span>
                        </div>
                        
                        <form action="#" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Update Status</label>
                                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                                    <option value="confirmed" {{ $booking['status'] === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="pending" {{ $booking['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="cancelled" {{ $booking['status'] === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="checked-in" {{ $booking['status'] === 'checked-in' ? 'selected' : '' }}>Checked In</option>
                                    <option value="checked-out" {{ $booking['status'] === 'checked-out' ? 'selected' : '' }}>Checked Out</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="inline-flex h-10 w-full items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="bg-card rounded-lg border shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <button class="inline-flex h-10 w-full items-center justify-center rounded-md bg-background border border-input px-4 py-2 text-sm font-medium ring-offset-background transition-colors hover:bg-muted focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><rect width="16" height="13" x="4" y="7" rx="2"></rect><circle cx="12" cy="11" r="2"></circle><path d="M12 13v4"></path><path d="m15 6-3-3-3 3"></path></svg>
                            Send Confirmation
                        </button>
                        
                        <button class="inline-flex h-10 w-full items-center justify-center rounded-md bg-background border border-input px-4 py-2 text-sm font-medium ring-offset-background transition-colors hover:bg-muted focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M16 13H8"></path><path d="M16 17H8"></path><path d="M10 9H8"></path></svg>
                            Generate Invoice
                        </button>
                        
                        <button class="inline-flex h-10 w-full items-center justify-center rounded-md bg-background border border-input px-4 py-2 text-sm font-medium ring-offset-background transition-colors hover:bg-muted focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><rect width="20" height="8" x="2" y="2" rx="2"></rect><rect width="20" height="8" x="2" y="14" rx="2"></rect></svg>
                            Process Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
