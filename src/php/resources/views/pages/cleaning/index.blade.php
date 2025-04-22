
@extends('layouts.app')

@section('title', 'Cleaning Status')

@section('content')
<div class="animate-fade-in page-transition">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Cleaning Status</h1>
        <p class="text-muted-foreground mt-1">Monitor and manage room cleaning status.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($rooms as $room)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover-card-effect">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Room {{ $room->number }}</h3>
                        <p class="text-sm text-gray-500">{{ $room->property->name }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $room->getStatusColorClass() }}">
                        {{ ucfirst($room->status) }}
                    </span>
                </div>
                
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Last Cleaned:</p>
                    <p class="font-medium">
                        @if($room->last_cleaned)
                            {{ $room->last_cleaned->format('M d, Y, h:i A') }}
                        @else
                            Not recorded
                        @endif
                    </p>
                </div>
                
                <div class="mt-6 space-y-2">
                    @if($room->status === 'needs-cleaning')
                        <form action="{{ route('cleaning.start-cleaning', $room) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-50 text-blue-700 border border-blue-100 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 btn-transition">
                                Start Cleaning
                            </button>
                        </form>
                    @endif
                    
                    @if($room->status === 'cleaning')
                        <form action="{{ route('cleaning.mark-clean', $room) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-50 text-green-700 border border-green-100 rounded-md hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 btn-transition">
                                Mark as Clean
                            </button>
                        </form>
                    @endif
                    
                    @if($room->status === 'available' || $room->status === 'booked')
                        <form action="{{ route('cleaning.mark-dirty', $room) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-50 text-yellow-700 border border-yellow-100 rounded-md hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 btn-transition">
                                Needs Cleaning
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('rooms.show', $room) }}" class="block w-full px-4 py-2 text-center bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 btn-transition">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
