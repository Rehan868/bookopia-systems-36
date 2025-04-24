
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-6 animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <p class="text-muted-foreground mt-1">Overview of your hotel performance and recent activity</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-card rounded-lg border p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-muted-foreground font-medium">Occupancy Rate</h3>
                        <div class="mt-1 flex items-baseline">
                            <p class="text-2xl font-semibold">{{ $stats['occupancyRate'] }}%</p>
                            <p class="ml-2 text-xs flex items-center text-green-600">↑ 3.2%</p>
                        </div>
                    </div>
                    <div class="rounded-full bg-primary/10 p-2 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><rect width="8" height="20" x="2" y="2" rx="2" ry="2"></rect><rect width="8" height="20" x="14" y="2" rx="2" ry="2"></rect></svg>
                    </div>
                </div>
            </div>

            <div class="bg-card rounded-lg border p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-muted-foreground font-medium">Total Bookings</h3>
                        <div class="mt-1 flex items-baseline">
                            <p class="text-2xl font-semibold">{{ $stats['totalBookings'] }}</p>
                            <p class="ml-2 text-xs flex items-center text-green-600">↑ 12%</p>
                        </div>
                    </div>
                    <div class="rounded-full bg-primary/10 p-2 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                    </div>
                </div>
            </div>

            <div class="bg-card rounded-lg border p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-muted-foreground font-medium">Revenue</h3>
                        <div class="mt-1 flex items-baseline">
                            <p class="text-2xl font-semibold">${{ $stats['revenue'] }}</p>
                            <p class="ml-2 text-xs flex items-center text-green-600">↑ 8.5%</p>
                        </div>
                    </div>
                    <div class="rounded-full bg-primary/10 p-2 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M2 17a5 5 0 0 0 10 0c0-2.76-2.5-5-5-3-2.5-2-5 .24-5 3Z"></path><path d="M12 17a5 5 0 0 0 10 0c0-2.76-2.5-5-5-3-2.5-2-5 .24-5 3Z"></path><path d="M2 7a5 5 0 0 1 10 0c0-2.76-2.5-5-5-3-2.5-2-5 .24-5 3Z"></path><path d="M12 7a5 5 0 0 1 10 0c0-2.76-2.5-5-5-3-2.5-2-5 .24-5 3Z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-card rounded-lg border p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-muted-foreground font-medium">Available Rooms</h3>
                        <div class="mt-1 flex items-baseline">
                            <p class="text-2xl font-semibold">{{ $stats['availableRooms'] }}</p>
                            <p class="ml-2 text-xs flex items-center text-red-600">↓ 2</p>
                        </div>
                    </div>
                    <div class="rounded-full bg-primary/10 p-2 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M3 7v9a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7"></path><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Chart Section -->
            <div class="bg-card rounded-lg border p-6 shadow-sm">
                <h3 class="text-lg font-medium mb-4">Occupancy Trend</h3>
                <div class="h-64 bg-muted/20 rounded flex items-center justify-center">
                    <!-- Chart would be rendered here -->
                    <p class="text-muted-foreground">Occupancy chart visualization</p>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-card rounded-lg border shadow-sm">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-medium">Recent Bookings</h3>
                </div>
                <div class="divide-y">
                    @foreach($recentBookings as $booking)
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium">{{ $booking['guest_name'] }}</p>
                                <p class="text-sm text-muted-foreground">Room {{ $booking['room'] }} &bull; {{ $booking['check_in'] }} to {{ $booking['check_out'] }}</p>
                            </div>
                            <div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs {{ $booking['status'] === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($booking['status']) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-4">
                    <a href="{{ route('bookings.index') }}" class="text-sm text-primary hover:underline">View all bookings</a>
                </div>
            </div>
        </div>
    </div>
@endsection
