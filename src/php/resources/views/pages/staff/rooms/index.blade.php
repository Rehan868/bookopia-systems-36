
@extends('layouts.app')

@section('title', 'Rooms')

@section('content')
<div class="animate-fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold">Rooms</h1>
            <p class="text-muted-foreground mt-1">Manage all property rooms</p>
        </div>
        <a href="{{ route('rooms.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add New Room
        </a>
    </div>

    @include('components.rooms.room-filters')
    @include('components.rooms.room-grid', ['rooms' => $rooms])
</div>
@endsection
