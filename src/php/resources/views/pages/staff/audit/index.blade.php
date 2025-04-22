
@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Audit Logs</h1>
        <p class="text-muted-foreground mt-1">Track all system activity and user actions</p>
    </div>
    
    <!-- Filters -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form action="{{ route('audit.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input 
                    type="text" 
                    name="search" 
                    id="search" 
                    value="{{ request('search') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                    placeholder="Search logs..."
                >
            </div>
            
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Log Type</label>
                <select name="type" id="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                    <option value="">All Types</option>
                    @foreach($logTypes as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                <input 
                    type="date" 
                    name="date_from" 
                    id="date_from" 
                    value="{{ request('date_from') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                >
            </div>
            
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                <input 
                    type="date" 
                    name="date_to" 
                    id="date_to" 
                    value="{{ request('date_to') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                >
            </div>
            
            <div class="md:col-span-4 flex justify-between">
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        Filter Logs
                    </button>
                    
                    @if(request('search') || request('type') || request('date_from') || request('date_to'))
                        <a href="{{ route('audit.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors ml-2">
                            Clear Filters
                        </a>
                    @endif
                </div>
                
                <a href="{{ route('audit.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Export Logs
                </a>
            </div>
        </form>
    </div>
    
    <!-- Logs Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($auditLogs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($log->type)
                                @case('authentication')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Authentication
                                    </span>
                                    @break
                                @case('booking')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Booking
                                    </span>
                                    @break
                                @case('user')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        User
                                    </span>
                                    @break
                                @case('system')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        System
                                    </span>
                                    @break
                                @default
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($log->type) }}
                                    </span>
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">
                            {{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $log->user_email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{ $log->action }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">
                            {{ $log->ip_address }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="max-w-md truncate">
                                {{ $log->details }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <p>No audit logs found</p>
                            @if(request('search') || request('type') || request('date_from') || request('date_to'))
                                <a href="{{ route('audit.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors mt-2">
                                    Clear Filters
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $auditLogs->appends(request()->query())->links() }}
            
            <p class="text-xs text-gray-500 mt-4">
                Audit logs are retained for 90 days in accordance with our data retention policy.
            </p>
        </div>
    </div>
</div>
@endsection
