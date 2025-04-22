
@extends('layouts.app')

@section('title', 'Room Details')

@section('content')
<div class="animate-fade-in page-transition">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Room {{ $room->number }}</h1>
            <p class="text-muted-foreground mt-1">{{ $room->property->name }} • {{ ucfirst($room->type) }} Room</p>
        </div>
        
        <div class="flex space-x-2">
            <a href="{{ route('rooms.edit', $room) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary btn-transition">
                Edit Room
            </a>
            <a href="{{ route('rooms.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary btn-transition">
                Back to Rooms
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Room Details Card -->
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover-card-effect">
            <div class="p-6 flex items-start justify-between border-b border-gray-200">
                <div>
                    <h2 class="text-xl font-semibold">Room Information</h2>
                    <p class="text-sm text-gray-500 mt-1">Detailed room specifications</p>
                </div>
                
                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $room->getStatusColorClass() }}">
                    {{ ucfirst($room->status) }}
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Room Number</h3>
                        <p class="mt-1 text-lg">{{ $room->number }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Room Type</h3>
                        <p class="mt-1 text-lg">{{ ucfirst($room->type) }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Base Rate</h3>
                        <p class="mt-1 text-lg">${{ number_format($room->base_rate, 2) }} / night</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Max Occupancy</h3>
                        <p class="mt-1 text-lg">{{ $room->max_occupancy }} persons</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Last Cleaned</h3>
                        <p class="mt-1 text-lg">
                            @if($room->last_cleaned)
                                {{ $room->last_cleaned->format('M d, Y, h:i A') }}
                            @else
                                Not recorded
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Next Maintenance</h3>
                        <p class="mt-1 text-lg">
                            @if($room->next_maintenance)
                                {{ $room->next_maintenance->format('M d, Y') }}
                            @else
                                Not scheduled
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="mt-1">{{ $room->description ?: 'No description available.' }}</p>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500">Amenities</h3>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @if($room->amenities)
                            @foreach($room->amenities as $amenity)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-50 text-primary">
                                    {{ $amenity }}
                                </span>
                            @endforeach
                        @else
                            <p>No amenities listed.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Room Actions Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-fit hover-card-effect">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold">Room Actions</h2>
                <p class="text-sm text-gray-500 mt-1">Quick room management</p>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-gray-500">Current Status</h3>
                    <div class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $room->getStatusColorClass() }}">
                        {{ ucfirst($room->status) }}
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Change Status</h3>
                    
                    <div class="grid grid-cols-1 gap-2">
                        @if($room->status != 'available')
                            <form action="{{ route('rooms.update', $room) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="available">
                                <button type="submit" class="w-full px-4 py-2 bg-green-50 text-green-700 border border-green-100 rounded-md hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 btn-transition">
                                    Mark as Available
                                </button>
                            </form>
                        @endif
                        
                        @if($room->status != 'maintenance')
                            <form action="{{ route('rooms.update', $room) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="maintenance">
                                <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 border border-red-100 rounded-md hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 btn-transition">
                                    Mark for Maintenance
                                </button>
                            </form>
                        @endif
                        
                        @if($room->status != 'needs-cleaning')
                            <form action="{{ route('cleaning.mark-dirty', $room) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-50 text-yellow-700 border border-yellow-100 rounded-md hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 btn-transition">
                                    Needs Cleaning
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Quick Actions</h3>
                    
                    <div class="grid grid-cols-1 gap-2">
                        <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}" class="w-full px-4 py-2 bg-primary text-white text-center rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 btn-transition">
                            Create New Booking
                        </a>
                        
                        @if($currentBooking = $room->currentBooking())
                            <a href="{{ route('bookings.show', $currentBooking) }}" class="w-full px-4 py-2 bg-blue-50 text-blue-700 border border-blue-100 text-center rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 btn-transition">
                                View Current Booking
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Booking History Card -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover-card-effect">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold">Booking History</h2>
            <p class="text-sm text-gray-500 mt-1">Recent bookings for this room</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($room->bookings()->orderBy('check_in', 'desc')->take(5)->get() as $booking)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $booking->booking_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $booking->guest_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $booking->check_in->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $booking->check_out->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->getStatusBadgeClass() }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $booking->getFormattedTotalAttribute() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('bookings.show', $booking) }}" class="text-primary hover:text-primary-dark">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No booking history found for this room.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if ($room->bookings()->count() > 5)
            <div class="p-4 flex justify-center">
                <a href="{{ route('bookings.index', ['room_id' => $room->id]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary btn-transition">
                    View All Bookings
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
