
@extends('layouts.owner')

@section('title', 'Owner Dashboard')

@section('content')
<div class="animate-fade-in">
    <div>
        <h1 class="text-3xl font-bold">Owner Dashboard</h1>
        <p class="text-muted-foreground">Welcome back to your property management dashboard.</p>
    </div>
    
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mt-6">
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
                <div class="text-2xl font-bold">78%</div>
                <p class="text-xs text-muted-foreground">+5.4% from last month</p>
                <div class="mt-4 h-4 w-full rounded-full bg-secondary">
                    <div class="h-full bg-primary transition-all" style="transform: translateX(-22%)"></div>
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
                <div class="text-2xl font-bold">$12,450</div>
                <p class="text-xs text-muted-foreground">+12.2% from last month</p>
                <div class="mt-4 h-2 w-full bg-gray-100">
                    <div class="h-full w-3/4 bg-green-600"></div>
                </div>
            </div>
        </div>
        
        <!-- Upcoming Bookings -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Upcoming Bookings</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">6</div>
                <p class="text-xs text-muted-foreground">For the next 14 days</p>
                <div class="mt-4 flex gap-1">
                    <div class="h-2 w-2 rounded-full bg-primary"></div>
                    <div class="h-2 w-2 rounded-full bg-primary"></div>
                    <div class="h-2 w-2 rounded-full bg-primary"></div>
                    <div class="h-2 w-2 rounded-full bg-primary"></div>
                    <div class="h-2 w-2 rounded-full bg-primary"></div>
                    <div class="h-2 w-2 rounded-full bg-primary"></div>
                    <div class="h-2 w-2 rounded-full bg-gray-200"></div>
                    <div class="h-2 w-2 rounded-full bg-gray-200"></div>
                    <div class="h-2 w-2 rounded-full bg-gray-200"></div>
                    <div class="h-2 w-2 rounded-full bg-gray-200"></div>
                </div>
            </div>
        </div>
        
        <!-- Cleaning Tasks -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Cleaning Tasks</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
                    <path d="M8.46 8.46a4 4 0 1 1 5.66 5.66"></path>
                    <path d="m2 22 3-3"></path>
                    <path d="M10.5 13.5 7 17"></path>
                    <path d="m7 7 5.5 5.5"></path>
                    <path d="M18 2a2 2 0 1 1 4 0c0 .56-.23 1.08-.61 1.46L10 15"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">2</div>
                <p class="text-xs text-muted-foreground">Scheduled for today</p>
                <div class="mt-4 flex items-center">
                    <div class="w-full flex justify-between text-xs">
                        <span>In Progress</span>
                        <span>1/2</span>
                    </div>
                </div>
                <div class="mt-1 h-2 w-full bg-gray-100 rounded-full">
                    <div class="h-full w-1/2 bg-amber-500 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Property Performance -->
    <div class="mt-6">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between">
                <h2 class="text-xl font-semibold">Property Performance</h2>
                <div>
                    <select class="border rounded-md px-4 py-2 bg-background">
                        <option>Last 30 Days</option>
                        <option>Last 90 Days</option>
                        <option>Last Year</option>
                        <option>All Time</option>
                    </select>
                </div>
            </div>
            <div class="p-6 pt-0">
                <div class="h-[300px] flex items-center justify-center border rounded-md bg-muted/20">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-16 w-16 text-muted-foreground mx-auto mb-2">
                            <path d="M3 3v18h18"></path>
                            <path d="m19 9-5 5-4-4-3 3"></path>
                        </svg>
                        <p class="text-muted-foreground">Performance chart would be displayed here</p>
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
                <a href="{{ route('owner.bookings') }}" class="text-sm text-primary hover:underline">View all</a>
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
                                    Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <td class="p-4 align-middle">Emily Wilson</td>
                                <td class="p-4 align-middle">Marina 101</td>
                                <td class="p-4 align-middle">25 Apr 2025</td>
                                <td class="p-4 align-middle">28 Apr 2025</td>
                                <td class="p-4 align-middle">
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-green-500/10 text-green-700">
                                        Confirmed
                                    </div>
                                </td>
                                <td class="p-4 align-middle">$420.00</td>
                            </tr>
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <td class="p-4 align-middle">Michael Rodriguez</td>
                                <td class="p-4 align-middle">Marina 203</td>
                                <td class="p-4 align-middle">26 Apr 2025</td>
                                <td class="p-4 align-middle">01 May 2025</td>
                                <td class="p-4 align-middle">
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-yellow-500/10 text-yellow-700">
                                        Pending
                                    </div>
                                </td>
                                <td class="p-4 align-middle">$780.00</td>
                            </tr>
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <td class="p-4 align-middle">Sarah Johnson</td>
                                <td class="p-4 align-middle">Marina 105</td>
                                <td class="p-4 align-middle">01 May 2025</td>
                                <td class="p-4 align-middle">07 May 2025</td>
                                <td class="p-4 align-middle">
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-green-500/10 text-green-700">
                                        Confirmed
                                    </div>
                                </td>
                                <td class="p-4 align-middle">$950.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
