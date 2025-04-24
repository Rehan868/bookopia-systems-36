
@extends('layouts.app')

@section('title', 'Room Availability')

@section('content')
    <div class="animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">Room Availability</h1>
                <p class="text-muted-foreground mt-1">View and manage room availability</p>
            </div>
        </div>

        <div class="bg-card rounded-lg border shadow-sm p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4">Room</th>
                            <th class="text-left py-3 px-4">Type</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-left py-3 px-4">Upcoming Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                            <tr class="border-b">
                                <td class="py-3 px-4">{{ $room['number'] }}</td>
                                <td class="py-3 px-4">{{ $room['type'] }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ $room['status'] === 'available' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($room['status']) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="space-y-1">
                                        @foreach($room['upcoming_bookings'] as $booking)
                                            <div class="text-sm">
                                                {{ $booking['check_in'] }} - {{ $booking['check_out'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
