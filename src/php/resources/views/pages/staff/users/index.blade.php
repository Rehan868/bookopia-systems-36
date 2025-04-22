
@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="animate-fade-in">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold">Users Management</h1>
            <p class="text-muted-foreground mt-1">Manage staff and user accounts</p>
        </div>
        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add New User
        </a>
    </div>

    @include('components.users.user-filters')
    @include('components.users.user-table', ['users' => $users])
</div>
@endsection
