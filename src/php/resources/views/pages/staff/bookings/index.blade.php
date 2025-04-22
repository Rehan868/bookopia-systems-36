
@extends('layouts.app')

@section('title', 'Bookings')

@section('content')
<div class="animate-fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold">Bookings</h1>
            <p class="text-muted-foreground mt-1">Manage all property bookings</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add New Booking
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        @include('components.dashboard.stat-card', [
            'title' => 'Total Bookings',
            'value' => $stats['total'],
            'icon' => 'calendar'
        ])
        @include('components.dashboard.stat-card', [
            'title' => 'Confirmed',
            'value' => $stats['confirmed'],
            'icon' => 'check-circle'
        ])
        @include('components.dashboard.stat-card', [
            'title' => 'Pending',
            'value' => $stats['pending'],
            'icon' => 'clock'
        ])
        @include('components.dashboard.stat-card', [
            'title' => 'Today\'s Check-ins',
            'value' => $stats['todayCheckIns'],
            'icon' => 'log-in'
        ])
    </div>

    @include('components.bookings.booking-filters')
    @include('components.bookings.booking-table', ['bookings' => $bookings])
</div>
@endsection
