
@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Reports</h1>
        <p class="text-muted-foreground mt-1">View and generate property reports</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @include('components.reports.revenue-chart')
        @include('components.reports.occupancy-chart')
        @include('components.reports.booking-sources')
        @include('components.reports.cleaning-status')
    </div>
</div>
@endsection
