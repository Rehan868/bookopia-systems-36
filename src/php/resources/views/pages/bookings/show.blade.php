
@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('bookings.index') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-3xl font-bold">Booking {{ $booking->booking_number }}</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->getStatusBadgeClass() }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <p class="text-gray-500 mt-1">
                    {{ $booking->check_in->format('M d, Y') }} - {{ $booking->check_out->format('M d, Y') }} • {{ $booking->nights }} {{ $booking->nights > 1 ? 'nights' : 'night' }}
                </p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 2v2"></path><path d="M17 14v2"></path><path d="M17 8v2"></path><path d="M3 6h4"></path><path d="M3 12h4"></path><path d="M3 18h4"></path><path d="M17 20v2"></path><rect width="4" height="16" x="7" y="4" rx="1"></rect><rect width="4" height="16" x="15" y="4" rx="1"></rect></svg>
                Print
            </a>
            <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                Email Guest
            </a>
            <a href="{{ route('bookings.edit', $booking) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3Z"></path></svg>
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Booking Details</h2>
                    <p class="text-sm text-gray-500">
                        Created on {{ $booking->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Guest Information</h3>
                                <div class="bg-gray-50 rounded-md p-4 space-y-3">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="font-medium">{{ $booking->guest_name }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                                        <a href="mailto:{{ $booking->guest_email }}" class="text-blue-600 hover:underline">
                                            {{ $booking->guest_email }}
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <span>{{ $booking->guest_phone }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                        <span>{{ $booking->adults }} Adults, {{ $booking->children }} Children</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Payment Information</h3>
                                <div class="bg-gray-50 rounded-md p-4 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium">Payment Status</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $booking->payment_status === 'paid' ? 'green' : ($booking->payment_status === 'partial' ? 'yellow' : 'blue') }}-100 text-{{ $booking->payment_status === 'paid' ? 'green' : ($booking->payment_status === 'partial' ? 'yellow' : 'blue') }}-800">
                                            {{ ucfirst($booking->payment_status) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Base Rate</span>
                                        <span>${{ number_format($booking->base_rate, 2) }} / night</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Nights</span>
                                        <span>{{ $booking->nights }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 my-2 pt-2"></div>
                                    <div class="flex items-center justify-between font-bold">
                                        <span>Total Amount</span>
                                        <span>${{ number_format($booking->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Reservation Details</h3>
                                <div class="bg-gray-50 rounded-md p-4 space-y-3">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20V8a4 4 0 0 1 4-4h12a4 4 0 0 1 4 4v12a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4Z"></path><path d="M2 9h20"></path><path d="M3 14h3"></path><path d="M8 14h3"></path><path d="M13 14h3"></path><path d="M18 14h3"></path><path d="M3 18h3"></path><path d="M8 18h3"></path><path d="M13 18h3"></path><path d="M18 18h3"></path></svg>
                                        <div>
                                            <span class="font-medium">Room {{ $booking->room->number }}</span>
                                            <p class="text-sm text-gray-500">{{ $booking->room->property->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                                        <div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <p class="text-xs text-gray-500">Check-in</p>
                                                    <p class="font-medium">{{ $booking->check_in->format('M d, Y') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Check-out</p>
                                                    <p class="font-medium">{{ $booking->check_out->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('rooms.show', $booking->room) }}" class="inline-flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        View Room Details
                                    </a>
                                </div>
                            </div>

                            @if($booking->notes)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Special Requests / Notes</h3>
                                <div class="bg-gray-50 rounded-md p-4">
                                    <p class="text-sm">{{ $booking->notes }}</p>
                                </div>
                            </div>
                            @endif

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Actions</h3>
                                <div class="bg-gray-50 rounded-md p-4 space-y-2">
                                    @if($booking->status === 'confirmed')
                                    <form action="{{ route('bookings.check-in', $booking) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                            Check In Guest
                                        </button>
                                    </form>
                                    @endif
                                    
                                    @if($booking->status === 'checked-in')
                                    <form action="{{ route('bookings.check-out', $booking) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                            Check Out Guest
                                        </button>
                                    </form>
                                    @endif
                                    
                                    @if(in_array($booking->status, ['confirmed', 'pending']))
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                                            Cancel Booking
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Quick Actions</h2>
                    <p class="text-sm text-gray-500">Common tasks for this booking</p>
                </div>
                <div class="p-6 space-y-4">
                    <a href="#" class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                        Process Payment
                    </a>
                    <a href="#" class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M16 13H8"></path><path d="M16 17H8"></path><path d="M10 9H8"></path></svg>
                        Generate Invoice
                    </a>
                    <a href="{{ route('bookings.edit', $booking) }}" class="inline-flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3Z"></path></svg>
                        Modify Booking
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a href="#" class="inline-block py-2 px-4 text-sm font-medium text-center text-blue-600 border-b-2 border-blue-600">
                        Payment History
                    </a>
                </li>
                <li class="mr-2">
                    <a href="#" class="inline-block py-2 px-4 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300">
                        Activity Log
                    </a>
                </li>
            </ul>
        </div>
        <div class="p-0">
            <div>
                <div class="rounded-lg overflow-hidden border border-gray-200">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left font-medium px-6 py-3">Date</th>
                                <th class="text-left font-medium px-6 py-3">Amount</th>
                                <th class="text-left font-medium px-6 py-3">Method</th>
                                <th class="text-left font-medium px-6 py-3">Status</th>
                                <th class="text-left font-medium px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $booking->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 font-medium">${{ number_format($booking->total_amount, 2) }}</td>
                                <td class="px-6 py-4">Credit Card</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Success
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                        Receipt
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
