
@extends('layouts.app')

@section('title', 'Add New Expense')

@section('content')
<div class="animate-fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Add New Expense</h1>
        <p class="text-muted-foreground mt-1">Track a new expense for your property</p>
    </div>
    
    <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold">Expense Details</h2>
                        <p class="text-sm text-gray-500">Enter the expense information</p>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                            <input 
                                type="text" 
                                name="description" 
                                id="description" 
                                value="{{ old('description') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                placeholder="e.g., Room 101 Plumbing Repair"
                                required
                            >
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount*</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input 
                                        type="number" 
                                        name="amount" 
                                        id="amount" 
                                        value="{{ old('amount') }}"
                                        class="pl-7 w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                        placeholder="0.00"
                                        step="0.01"
                                        min="0"
                                        required
                                    >
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date*</label>
                                <input 
                                    type="date" 
                                    name="date" 
                                    id="date" 
                                    value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                    required
                                >
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
                                <select 
                                    name="category" 
                                    id="category" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                    required
                                >
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="property_id" class="block text-sm font-medium text-gray-700 mb-1">Property*</label>
                                <select 
                                    name="property_id" 
                                    id="property_id" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                    required
                                >
                                    <option value="">Select Property</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('property_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="vendor" class="block text-sm font-medium text-gray-700 mb-1">Vendor/Supplier</label>
                                <input 
                                    type="text" 
                                    name="vendor" 
                                    id="vendor" 
                                    value="{{ old('vendor') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                    placeholder="e.g., ABC Plumbing Services"
                                >
                                @error('vendor')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method*</label>
                                <select 
                                    name="payment_method" 
                                    id="payment_method" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                    required
                                >
                                    <option value="">Select Payment Method</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                placeholder="Additional notes about this expense..."
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div>
                <!-- Receipt Upload -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold">Receipt Upload</h2>
                        <p class="text-sm text-gray-500">Upload receipt or invoice image</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <input 
                                type="file" 
                                name="receipt" 
                                id="receipt"
                                class="hidden"
                                accept="image/*"
                            >
                            <label for="receipt" class="cursor-pointer block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-medium text-primary">Click to upload</span> or drag and drop
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    PNG, JPG, GIF up to 2MB
                                </p>
                            </label>
                            <div id="file-preview" class="mt-4 hidden">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span id="file-name" class="text-sm text-gray-700"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('receipt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Expense Tips -->
                <div class="bg-blue-50 rounded-xl shadow-sm border border-blue-100 overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-blue-100">
                        <h2 class="text-lg font-semibold text-blue-800">Expense Tips</h2>
                    </div>
                    
                    <div class="p-6">
                        <ul class="space-y-3 text-sm text-blue-700">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                Always categorize expenses correctly for better reporting
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                Upload receipts to maintain proper documentation
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                Add detailed notes for easier tracking and reference
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                Regular expense tracking helps with budget planning
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Controls -->
        <div class="flex justify-end mt-6 gap-4">
            <a href="{{ route('expenses.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                Add Expense
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('receipt');
        const filePreview = document.getElementById('file-preview');
        const fileName = document.getElementById('file-name');
        
        input.addEventListener('change', function() {
            if (input.files.length > 0) {
                filePreview.classList.remove('hidden');
                fileName.textContent = input.files[0].name;
            } else {
                filePreview.classList.add('hidden');
                fileName.textContent = '';
            }
        });
    });
</script>
@endpush
@endsection
