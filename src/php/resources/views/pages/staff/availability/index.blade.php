
@extends('layouts.app')

@section('title', 'Room Availability')

@section('content')
<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Room Availability</h1>
        <p class="text-muted-foreground mt-1">Check room availability across all properties</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            @include('components.availability.calendar')
        </div>
        <div>
            @include('components.availability.room-status-list', ['rooms' => $rooms])
        </div>
    </div>
</div>
@endsection
