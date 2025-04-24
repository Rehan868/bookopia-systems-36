
@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <div class="animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">Reports</h1>
                <p class="text-muted-foreground mt-1">Generate and view reports for your properties</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Report -->
            <div class="bg-card rounded-lg border shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Revenue Report</h2>
                <div class="h-64 bg-muted/20 rounded flex items-center justify-center">
                    <!-- Chart would be rendered here -->
                    <p class="text-muted-foreground">Revenue chart visualization</p>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Total Revenue</span>
                        <span class="font-medium">$28,456.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Average Daily Rate</span>
                        <span class="font-medium">$154.25</span>
                    </div>
                </div>
            </div>
            
            <!-- Occupancy Report -->
            <div class="bg-card rounded-lg border shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Occupancy Report</h2>
                <div class="h-64 bg-muted/20 rounded flex items-center justify-center">
                    <!-- Chart would be rendered here -->
                    <p class="text-muted-foreground">Occupancy chart visualization</p>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Average Occupancy</span>
                        <span class="font-medium">76.4%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Peak Occupancy Day</span>
                        <span class="font-medium">Saturday (94%)</span>
                    </div>
                </div>
            </div>
            
            <!-- Booking Sources -->
            <div class="bg-card rounded-lg border shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Booking Sources</h2>
                <div class="h-64 bg-muted/20 rounded flex items-center justify-center">
                    <!-- Chart would be rendered here -->
                    <p class="text-muted-foreground">Booking sources chart visualization</p>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Direct Bookings</span>
                        <span class="font-medium">42%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">OTA Bookings</span>
                        <span class="font-medium">58%</span>
                    </div>
                </div>
            </div>
            
            <!-- Guest Demographics -->
            <div class="bg-card rounded-lg border shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Guest Demographics</h2>
                <div class="h-64 bg-muted/20 rounded flex items-center justify-center">
                    <!-- Chart would be rendered here -->
                    <p class="text-muted-foreground">Guest demographics visualization</p>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Returning Guests</span>
                        <span class="font-medium">23%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">Average Length of Stay</span>
                        <span class="font-medium">2.8 nights</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
