
@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="text-muted-foreground mt-1">Welcome back to your hotel management dashboard</p>
    </div>
    
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Available Rooms -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover-card-effect">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold">Available Rooms</h3>
            <p class="text-3xl font-bold mt-2">{{ $availableRooms }}</p>
            <p class="text-gray-500 text-sm mt-1">Out of {{ $totalRooms }} total rooms</p>
        </div>

        <!-- Today's Check-ins -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover-card-effect">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold">Today's Check-ins</h3>
            <p class="text-3xl font-bold mt-2">{{ $todayCheckIns }}</p>
            <p class="text-gray-500 text-sm mt-1">Expected arrivals today</p>
        </div>

        <!-- Today's Check-outs -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover-card-effect">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold">Today's Check-outs</h3>
            <p class="text-3xl font-bold mt-2">{{ $todayCheckOuts }}</p>
            <p class="text-gray-500 text-sm mt-1">Departures scheduled today</p>
        </div>

        <!-- Occupancy Rate -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover-card-effect">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-semibold">Occupancy Rate</h3>
            <p class="text-3xl font-bold mt-2">{{ $occupancyRate }}%</p>
            <p class="text-gray-500 text-sm mt-1">Current occupancy status</p>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Today's Activities</h2>
        <div class="divide-y">
            @foreach($todayActivities as $activity)
            <div class="py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $activity->guest_name }}</p>
                        <p class="text-sm text-gray-500">
                            Room {{ $activity->room->number }} - {{ $activity->room->property->name }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium">
                            @if($activity->check_in->isToday())
                            Check-in
                            @else
                            Check-out
                            @endif
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $activity->check_in->isToday() 
                                ? $activity->check_in->format('h:i A')
                                : $activity->check_out->format('h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold mb-4">Recent Bookings</h2>
        <div class="divide-y">
            @foreach($recentBookings as $booking)
            <div class="py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $booking->guest_name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $booking->room->property->name }} - Room {{ $booking->room->number }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $booking->check_in->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
