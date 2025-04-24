
@extends('layouts.app')

@section('title', 'Add New Booking')

@section('content')
    <div class="animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('bookings.index') }}" class="text-muted-foreground hover:text-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m15 18-6-6 6-6"></path></svg>
                    </a>
                    <h1 class="text-3xl font-bold">Add New Booking</h1>
                </div>
                <p class="text-muted-foreground mt-1">Create a new reservation</p>
            </div>
        </div>

        <div class="bg-card rounded-lg border shadow">
            <form action="{{ route('bookings.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Guest Information</h3>
                        
                        <div>
                            <label for="guest_name" class="block text-sm font-medium mb-1">Guest Name</label>
                            <input 
                                type="text" 
                                id="guest_name" 
                                name="guest_name" 
                                class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                value="{{ old('guest_name') }}"
                                required
                            />
                        </div>
                        
                        <div>
                            <label for="guest_email" class="block text-sm font-medium mb-1">Email Address</label>
                            <input 
                                type="email" 
                                id="guest_email" 
                                name="guest_email" 
                                class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                value="{{ old('guest_email') }}"
                                required
                            />
                        </div>
                        
                        <div>
                            <label for="guest_phone" class="block text-sm font-medium mb-1">Phone Number</label>
                            <input 
                                type="text" 
                                id="guest_phone" 
                                name="guest_phone" 
                                class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                value="{{ old('guest_phone') }}"
                                required
                            />
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="adults" class="block text-sm font-medium mb-1">Adults</label>
                                <input 
                                    type="number" 
                                    id="adults" 
                                    name="adults" 
                                    class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                    min="1" 
                                    value="{{ old('adults', 1) }}"
                                    required
                                />
                            </div>
                            
                            <div>
                                <label for="children" class="block text-sm font-medium mb-1">Children</label>
                                <input 
                                    type="number" 
                                    id="children" 
                                    name="children" 
                                    class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                    min="0" 
                                    value="{{ old('children', 0) }}"
                                />
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold">Reservation Details</h3>
                        
                        <div>
                            <label for="room_type" class="block text-sm font-medium mb-1">Room Type</label>
                            <select 
                                id="room_type" 
                                name="room_type" 
                                class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                required
                            >
                                <option value="">Select Room Type</option>
                                <option value="standard" {{ old('room_type') == 'standard' ? 'selected' : '' }}>Standard Room</option>
                                <option value="deluxe" {{ old('room_type') == 'deluxe' ? 'selected' : '' }}>Deluxe Room</option>
                                <option value="suite" {{ old('room_type') == 'suite' ? 'selected' : '' }}>Suite</option>
                                <option value="executive" {{ old('room_type') == 'executive' ? 'selected' : '' }}>Executive Suite</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="room_number" class="block text-sm font-medium mb-1">Room Number</label>
                            <select 
                                id="room_number" 
                                name="room_number" 
                                class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                required
                            >
                                <option value="">Select Room</option>
                                <option value="101" {{ old('room_number') == '101' ? 'selected' : '' }}>101 - Standard</option>
                                <option value="102" {{ old('room_number') == '102' ? 'selected' : '' }}>102 - Standard</option>
                                <option value="201" {{ old('room_number') == '201' ? 'selected' : '' }}>201 - Deluxe</option>
                                <option value="202" {{ old('room_number') == '202' ? 'selected' : '' }}>202 - Deluxe</option>
                                <option value="301" {{ old('room_number') == '301' ? 'selected' : '' }}>301 - Suite</option>
                                <option value="401" {{ old('room_number') == '401' ? 'selected' : '' }}>401 - Executive Suite</option>
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="check_in" class="block text-sm font-medium mb-1">Check In Date</label>
                                <input 
                                    type="date" 
                                    id="check_in" 
                                    name="check_in" 
                                    class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                    value="{{ old('check_in') }}"
                                    required
                                />
                            </div>
                            
                            <div>
                                <label for="check_out" class="block text-sm font-medium mb-1">Check Out Date</label>
                                <input 
                                    type="date" 
                                    id="check_out" 
                                    name="check_out" 
                                    class="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                    value="{{ old('check_out') }}"
                                    required
                                />
                            </div>
                        </div>
                        
                        <div>
                            <label for="total_amount" class="block text-sm font-medium mb-1">Total Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input 
                                    type="text" 
                                    id="total_amount" 
                                    name="total_amount" 
                                    class="pl-7 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                    value="{{ old('total_amount') }}"
                                    required
                                />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label for="notes" class="block text-sm font-medium mb-1">Notes</label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            rows="3" 
                            class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        >{{ old('notes') }}</textarea>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <input 
                            type="checkbox" 
                            id="send_confirmation" 
                            name="send_confirmation" 
                            class="h-4 w-4 rounded border-gray-300" 
                            {{ old('send_confirmation') ? 'checked' : '' }}
                        />
                        <label for="send_confirmation" class="text-sm text-muted-foreground">
                            Send confirmation email to guest
                        </label>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a 
                        href="{{ route('bookings.index') }}" 
                        class="inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground"
                    >
                        Cancel
                    </a>
                    <button 
                        type="submit" 
                        class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
                    >
                        Create Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
