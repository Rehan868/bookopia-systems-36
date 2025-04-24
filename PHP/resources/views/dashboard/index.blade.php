
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="animate-fade-in">
    <div class="flex flex-col lg:flex-row justify-between items-start mb-8">
        <div>
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <p class="text-muted-foreground">Welcome back to your hotel management dashboard.</p>
        </div>
        
        <div class="mt-4 lg:mt-0 flex flex-wrap gap-2">
            <a href="{{ route('bookings.create') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 shrink-0">
                    <path d="M5 12h14"></path>
                    <path d="M12 5v14"></path>
                </svg>
                New Booking
            </a>
            
            <a href="{{ route('rooms.create') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 shrink-0">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Add Room
            </a>
            
            <a href="{{ route('cleaning') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 shrink-0">
                    <path d="M8.46 8.46a4 4 0 1 1 5.66 5.66"></path>
                    <path d="m2 22 3-3"></path>
                    <path d="M10.5 13.5 7 17"></path>
                    <path d="m7 7 5.5 5.5"></path>
                    <path d="M18 2a2 2 0 1 1 4 0c0 .56-.23 1.08-.61 1.46L10 15"></path>
                </svg>
                Cleaning Status
            </a>
        </div>
    </div>
    
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <!-- Occupancy Rate -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Occupancy Rate</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">{{ $stats['occupancyRate'] }}%</div>
                <p class="text-xs text-muted-foreground">+2.1% from last month</p>
                <div class="mt-4 h-4 w-full rounded-full bg-secondary">
                    <div class="h-full bg-primary transition-all" style="transform: translateX(-{{ 100 - $stats['occupancyRate'] }}%)"></div>
                </div>
            </div>
        </div>
        
        <!-- Total Bookings -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Total Bookings</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">{{ $stats['totalBookings'] }}</div>
                <p class="text-xs text-muted-foreground">+12.3% from last month</p>
                <div class="mt-4 flex items-center">
                    <span class="font-medium text-green-600">↑</span>
                    <div class="ml-1 space-x-1">
                        <span class="inline-block h-2 w-1 bg-green-600"></span>
                        <span class="inline-block h-3 w-1 bg-green-600"></span>
                        <span class="inline-block h-4 w-1 bg-green-600"></span>
                        <span class="inline-block h-2 w-1 bg-green-600"></span>
                        <span class="inline-block h-5 w-1 bg-green-600"></span>
                        <span class="inline-block h-3 w-1 bg-green-600"></span>
                        <span class="inline-block h-6 w-1 bg-green-600"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Revenue -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Revenue</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                    <path d="M12 18V6"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">${{ number_format($stats['revenue']) }}</div>
                <p class="text-xs text-muted-foreground">+18.7% from last month</p>
                <div class="mt-4 h-2 w-full bg-gray-100">
                    <div class="h-full w-3/4 bg-green-600"></div>
                </div>
            </div>
        </div>
        
        <!-- Available Rooms -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Available Rooms</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">{{ $stats['availableRooms'] }}</div>
                <p class="text-xs text-muted-foreground">Out of 50 total rooms</p>
                <div class="mt-4 flex gap-1">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="h-2 w-2 rounded-full {{ $i < ($stats['availableRooms'] / 5) ? 'bg-primary' : 'bg-gray-200' }}"></div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    
    <!-- Today's Activity Section -->
    <div class="mt-6">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <h2 class="text-xl font-semibold">Today's Activity</h2>
            </div>
            <div class="p-0 sm:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Today's Check-ins -->
                    <div>
                        <h3 class="font-medium mb-2 px-2">Today's Check-ins</h3>
                        <div class="border rounded-md">
                            <div class="px-4 py-3 border-b bg-muted/50 flex items-center">
                                <span class="font-medium">3</span>
                                <span class="ml-1 text-muted-foreground">guests arriving</span>
                            </div>
                            <div class="p-2">
                                <div class="rounded-md border transition-all hover:bg-muted/50 mb-2">
                                    <div class="p-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="h-7 w-7 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-medium">JS</span>
                                                <div>
                                                    <p class="font-medium">John Smith</p>
                                                    <p class="text-xs text-muted-foreground">Room 101 · 3 nights</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-muted-foreground">Arriving</p>
                                                <p class="font-medium">2:00 PM</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="rounded-md border transition-all hover:bg-muted/50 mb-2">
                                    <div class="p-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="h-7 w-7 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-medium">MJ</span>
                                                <div>
                                                    <p class="font-medium">Maria Johnson</p>
                                                    <p class="text-xs text-muted-foreground">Room 204 · 1 night</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-muted-foreground">Arriving</p>
                                                <p class="font-medium">3:30 PM</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Today's Check-outs -->
                    <div>
                        <h3 class="font-medium mb-2 px-2">Today's Check-outs</h3>
                        <div class="border rounded-md">
                            <div class="px-4 py-3 border-b bg-muted/50 flex items-center">
                                <span class="font-medium">2</span>
                                <span class="ml-1 text-muted-foreground">guests departing</span>
                            </div>
                            <div class="p-2">
                                <div class="rounded-md border transition-all hover:bg-muted/50 mb-2">
                                    <div class="p-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="h-7 w-7 rounded-full bg-secondary/80 text-secondary-foreground flex items-center justify-center text-xs font-medium">RB</span>
                                                <div>
                                                    <p class="font-medium">Robert Brown</p>
                                                    <p class="text-xs text-muted-foreground">Room 305 · 5 nights</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-muted-foreground">Departing</p>
                                                <p class="font-medium">11:00 AM</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Bookings -->
    <div class="mt-6">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between">
                <h2 class="text-xl font-semibold">Recent Bookings</h2>
                <a href="{{ route('bookings.index') }}" class="text-sm text-primary hover:underline">View all</a>
            </div>
            <div class="p-0">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                    Guest
                                </th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                    Room
                                </th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                    Check-in
                                </th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                    Check-out
                                </th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                    Status
                                </th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @foreach ($recentBookings as $booking)
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <td class="p-4 align-middle">{{ $booking['guest_name'] }}</td>
                                <td class="p-4 align-middle">{{ $booking['room'] }}</td>
                                <td class="p-4 align-middle">{{ $booking['check_in'] }}</td>
                                <td class="p-4 align-middle">{{ $booking['check_out'] }}</td>
                                <td class="p-4 align-middle">
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-{{ $booking['status'] === 'confirmed' ? 'green' : 'yellow' }}-500/10 text-{{ $booking['status'] === 'confirmed' ? 'green' : 'yellow' }}-700">
                                        {{ ucfirst($booking['status']) }}
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex gap-2">
                                        <a href="{{ route('bookings.show', $booking['id']) }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 w-9">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            <span class="sr-only">View</span>
                                        </a>
                                        
                                        <a href="{{ route('bookings.edit', $booking['id']) }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 w-9">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                                <path d="m15 5 4 4"></path>
                                            </svg>
                                            <span class="sr-only">Edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
