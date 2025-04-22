
@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Settings</h1>
        <p class="text-muted-foreground mt-1">Manage system settings and preferences</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            @include('components.settings.general-settings')
            @include('components.settings.notification-settings')
            @include('components.settings.payment-settings')
        </div>
        <div>
            @include('components.settings.system-info')
            @include('components.settings.backup-settings')
        </div>
    </div>
</div>
@endsection
