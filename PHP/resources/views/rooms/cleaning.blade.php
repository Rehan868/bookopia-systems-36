
@extends('layouts.app')

@section('title', 'Cleaning Status')

@section('content')
    <div class="animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">Cleaning Status</h1>
                <p class="text-muted-foreground mt-1">Monitor and manage room cleaning tasks</p>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($rooms as $room)
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-semibold">Room {{ $room['number'] }}</h3>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                {{ $room['status'] === 'clean' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($room['status']) }}
                            </span>
                        </div>
                        <p class="text-sm text-muted-foreground mt-2">{{ $room['type'] }}</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Last Cleaned</span>
                                <span class="font-medium">{{ $room['last_cleaned'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Next Checkout</span>
                                <span class="font-medium">{{ $room['next_checkout'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Assigned To</span>
                                <span class="font-medium">{{ $room['assigned_to'] }}</span>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="button" class="inline-flex w-full items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                Mark as Clean
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
