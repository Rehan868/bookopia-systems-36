
@extends('layouts.app')

@section('title', 'Property Cleaning Status')

@section('content')
<div class="animate-fade-in page-transition">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Property Cleaning Status</h1>
        <p class="text-muted-foreground mt-1">Monitor cleaning status across your properties.</p>
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
                
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Current Status:</p>
                    <p class="font-medium">
                        @if($room->status === 'needs-cleaning')
                            Waiting for cleaning staff
                        @elseif($room->status === 'cleaning')
                            Currently being cleaned
                        @elseif($room->status === 'available')
                            Clean and ready
                        @else
                            {{ ucfirst($room->status) }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
