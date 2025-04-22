
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="text-muted-foreground mt-1">Welcome back to your hotel management dashboard.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Available Rooms Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 animate-slide-up">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Available Rooms</p>
                    <h3 class="text-2xl font-bold mt-2 tracking-tight">{{ $availableRooms }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Out of {{ $totalRooms }} total rooms</p>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 19V7c0-2 2-3 5-3s5 1 5 3v12"></path><path d="M2 19h10"></path><path d="M12 19V7c0-2 2-3 5-3s5 1 5 3v12"></path><path d="M12 19h10"></path></svg>
                </div>
            </div>
        </div>
        
        <!-- Today's Check-ins Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 animate-slide-up" style="animation-delay: 100ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Check-ins</p>
                    <h3 class="text-2xl font-bold mt-2 tracking-tight">{{ $todayCheckIns }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $todayCheckIns > 0 ? 'Expected arrivals today' : 'No check-ins scheduled' }}</p>
                </div>
                <div class="p-2 bg-green-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"></path><path d="m19 12-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>
        
        <!-- Today's Check-outs Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 animate-slide-up" style="animation-delay: 200ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Check-outs</p>
                    <h3 class="text-2xl font-bold mt-2 tracking-tight">{{ $todayCheckOuts }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $todayCheckOuts > 0 ? 'Guests departing today' : 'No check-outs scheduled' }}</p>
                </div>
                <div class="p-2 bg-amber-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"></path><path d="m5 12 7-7 7 7"></path></svg>
                </div>
            </div>
        </div>
        
        <!-- Occupancy Rate Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 animate-slide-up" style="animation-delay: 300ms">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Occupancy Rate</p>
                    <h3 class="text-2xl font-bold mt-2 tracking-tight">{{ $occupancyRate }}%</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $occupancyRate > 70 ? 'Good occupancy today' : 'Room for improvement' }}</p>
                </div>
                <div class="p-2 bg-purple-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m16.24 7.76-4.24 4.24-4.24-4.24"></path><path d="m12 12-4.24 4.24"></path><path d="m12 12 4.24 4.24"></path></svg>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
        <!-- Occupancy Chart -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 lg:col-span-2">
            <h3 class="text-lg font-semibold mb-4">Occupancy & Revenue</h3>
            <p class="text-sm text-gray-500 mb-6">Yearly overview of occupancy rates and revenue</p>
            <div id="occupancy-chart" class="h-80"></div>
        </div>
        
        <!-- Quick Actions Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('bookings.create') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line><path d="M8 14h.01"></path><path d="M12 14h.01"></path><path d="M16 14h.01"></path><path d="M8 18h.01"></path><path d="M12 18h.01"></path><path d="M16 18h.01"></path></svg>
                    <span class="text-sm">New Booking</span>
                </a>
                
                <a href="{{ route('rooms.index') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 19V7c0-2 2-3 5-3s5 1 5 3v12"></path><path d="M2 19h10"></path><path d="M12 19V7c0-2 2-3 5-3s5 1 5 3v12"></path><path d="M12 19h10"></path></svg>
                    <span class="text-sm">Rooms</span>
                </a>
                
                <a href="{{ route('cleaning.index') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="11" height="11" x="3" y="3" rx="2" ry="2"></rect><path d="M10 3v18"></path><path d="M3 10h18"></path></svg>
                    <span class="text-sm">Cleaning</span>
                </a>
                
                <a href="{{ route('expenses.index') }}" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                    <span class="text-sm">Expenses</span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
        <!-- Recent Bookings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 lg:col-span-2">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Recent Bookings</h3>
                <p class="text-sm text-gray-500 mt-1">Latest booking activity across all properties</p>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentBookings as $booking)
                <div class="flex items-center justify-between p-6">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">{{ $booking->guest_name }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->getStatusBadgeClass() }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>{{ $booking->room->number }}, {{ $booking->room->property->name }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                                <span>{{ $booking->check_in->format('M d, Y') }} - {{ $booking->check_out->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Details
                        </a>
                        @if($booking->status === 'confirmed')
                        <form action="{{ route('bookings.check-in', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Check In
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-500">
                    No recent bookings found
                </div>
                @endforelse
                
                <div class="p-4 flex justify-center">
                    <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        View All Bookings
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Today's Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Today's Activity</h3>
                <p class="text-sm text-gray-500 mt-1">Check-ins and check-outs for today</p>
            </div>
            
            <div class="p-6">
                <h4 class="font-medium text-gray-700 mb-3">Check-ins</h4>
                @if($todayCheckIns > 0)
                    <div class="space-y-3">
                        @foreach(App\Models\Booking::getTodayCheckIns() as $checkin)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"></path><path d="m19 12-7 7-7-7"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium">{{ $checkin->guest_name }}</div>
                                <div class="text-sm text-gray-500">Room {{ $checkin->room->number }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500 text-sm mb-6">No check-ins scheduled for today</div>
                @endif
                
                <h4 class="font-medium text-gray-700 mb-3 mt-6">Check-outs</h4>
                @if($todayCheckOuts > 0)
                    <div class="space-y-3">
                        @foreach(App\Models\Booking::getTodayCheckOuts() as $checkout)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="p-2 bg-amber-100 text-amber-600 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"></path><path d="m5 12 7-7 7 7"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium">{{ $checkout->guest_name }}</div>
                                <div class="text-sm text-gray-500">Room {{ $checkout->room->number }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500 text-sm">No check-outs scheduled for today</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            chart: {
                height: 320,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            series: [
                {
                    name: 'Occupancy Rate (%)',
                    data: {!! json_encode(array_column($occupancyData, 'occupancy')) !!}
                },
                {
                    name: 'Revenue ($)',
                    data: {!! json_encode(array_column($occupancyData, 'revenue')) !!}
                }
            ],
            xaxis: {
                categories: {!! json_encode(array_column($occupancyData, 'name')) !!},
            },
            tooltip: {
                y: {
                    formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                        if (seriesIndex === 0) {
                            return value + '%';
                        }
                        return '$' + value;
                    }
                }
            },
            colors: ['#3b82f6', '#10b981'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            }
        };
        
        var chart = new ApexCharts(document.querySelector("#occupancy-chart"), options);
        chart.render();
    });
</script>
@endpush
