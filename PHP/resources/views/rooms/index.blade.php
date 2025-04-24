
@extends('layouts.app')

@section('title', 'Rooms')

@section('content')
    <div class="animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">Rooms</h1>
                <p class="text-muted-foreground mt-1">Manage all properties and rooms</p>
            </div>
            <a href="{{ route('rooms.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 mt-4 md:mt-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                Add New Room
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <input type="text" placeholder="Search rooms..." class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
            </div>
            <select class="h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                <option value="">All Status</option>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>

        <!-- Room Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($rooms as $room)
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-semibold">Room {{ $room['number'] }}</h3>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                {{ $room['status'] === 'available' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $room['status'] === 'occupied' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $room['status'] === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ ucfirst($room['status']) }}
                            </span>
                        </div>
                        <p class="text-sm text-muted-foreground mt-2">{{ $room['type'] }}</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Price</span>
                                <span class="font-medium">${{ $room['price'] }}/night</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Max Occupancy</span>
                                <span class="font-medium">{{ $room['occupancy'] }} guests</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Status</span>
                                <span class="font-medium">{{ ucfirst($room['maintenance_status']) }}</span>
                            </div>
                        </div>
                        <div class="mt-6 flex gap-2">
                            <a href="{{ route('rooms.edit', $room['id']) }}" 
                               class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 flex-1">
                                Edit
                            </a>
                            <a href="{{ route('rooms.show', $room['id']) }}"
                               class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 flex-1">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
