
@extends('layouts.app')

@section('title', 'Bookings')

@section('content')
    <div class="animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">Bookings</h1>
                <p class="text-muted-foreground mt-1">Manage all your bookings in one place</p>
            </div>
            <a href="{{ route('bookings.create') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground mt-4 md:mt-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>
                Add New Booking
            </a>
        </div>

        <div class="mb-6">
            <form action="{{ route('bookings.index') }}" method="GET" class="flex flex-wrap gap-3">
                <div class="flex-1 min-w-[200px]">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search bookings..." 
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        value="{{ request('search') }}"
                    />
                </div>
                <select 
                    name="status" 
                    class="h-10 rounded-md border border-input bg-background px-3 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                >
                    <option value="">All Statuses</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="checked-in" {{ request('status') == 'checked-in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked-out" {{ request('status') == 'checked-out' ? 'selected' : '' }}>Checked Out</option>
                </select>
                <button 
                    type="submit" 
                    class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground"
                >
                    Filter
                </button>
                <a 
                    href="{{ route('bookings.index') }}" 
                    class="inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground"
                >
                    Reset
                </a>
            </form>
        </div>
        
        <div class="bg-card rounded-lg border shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y">
                    <thead class="bg-muted">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Reference</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Guest</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Room</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Check In/Out</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-muted-foreground uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-background divide-y">
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $booking['reference'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div>{{ $booking['guest_name'] }}</div>
                                    <div class="text-muted-foreground text-xs">{{ $booking['guest_email'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $booking['room'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div>{{ $booking['check_in'] }}</div>
                                    <div>{{ $booking['check_out'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">${{ $booking['total_amount'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs
                                        {{ $booking['status'] === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $booking['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $booking['status'] === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $booking['status'] === 'checked-in' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $booking['status'] === 'checked-out' ? 'bg-gray-100 text-gray-800' : '' }}
                                    ">
                                        {{ ucfirst($booking['status']) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('bookings.show', $booking['id']) }}" class="text-primary hover:underline mr-3">View</a>
                                    <a href="{{ route('bookings.edit', $booking['id']) }}" class="text-primary hover:underline mr-3">Edit</a>
                                    <form action="{{ route('bookings.destroy', $booking['id']) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(count($bookings) === 0)
                <div class="p-6 text-center">
                    <p class="text-muted-foreground">No bookings found</p>
                </div>
            @endif
            
            <div class="px-6 py-4 border-t">
                <!-- Pagination would go here -->
            </div>
        </div>
    </div>
@endsection
