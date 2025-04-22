
@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('expenses.index') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold">Expense Details</h1>
                <p class="text-muted-foreground mt-1">
                    {{ $expense->description }}
                </p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('expenses.edit', $expense) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3Z"></path></svg>
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Expense Information</h2>
                    <p class="text-sm text-gray-500">
                        Created on {{ $expense->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Basic Details</h3>
                            <dl class="divide-y divide-gray-200">
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="text-sm text-gray-900">{{ $expense->description }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                    <dd class="text-sm font-semibold text-gray-900">${{ number_format($expense->amount, 2) }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                                    <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                                    <dd class="text-sm text-gray-900">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @switch($expense->category)
                                                @case('Maintenance')
                                                    bg-blue-100 text-blue-800
                                                    @break
                                                @case('Utilities')
                                                    bg-yellow-100 text-yellow-800
                                                    @break
                                                @case('Cleaning')
                                                    bg-green-100 text-green-800
                                                    @break
                                                @case('Supplies')
                                                    bg-purple-100 text-purple-800
                                                    @break
                                                @case('Taxes')
                                                    bg-red-100 text-red-800
                                                    @break
                                                @default
                                                    bg-gray-100 text-gray-800
                                            @endswitch
                                        ">
                                            {{ $expense->category }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Property</dt>
                                    <dd class="text-sm text-gray-900">{{ $expense->property->name ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Additional Information</h3>
                            <dl class="divide-y divide-gray-200">
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Vendor/Supplier</dt>
                                    <dd class="text-sm text-gray-900">{{ $expense->vendor ?? 'N/A' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                    <dd class="text-sm text-gray-900">{{ $expense->payment_method }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                    <dd class="text-sm text-gray-900">{{ $expense->user->name ?? 'System' }}</dd>
                                </div>
                            </dl>
                            
                            @if($expense->notes)
                            <div class="mt-4">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Notes</h3>
                                <div class="bg-gray-50 rounded-md p-4">
                                    <p class="text-sm text-gray-900">{{ $expense->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            @if($expense->receipt_path)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Receipt</h2>
                </div>
                <div class="p-4">
                    <div class="rounded-md overflow-hidden">
                        <img 
                            src="{{ asset('storage/' . $expense->receipt_path) }}" 
                            alt="Receipt for {{ $expense->description }}"
                            class="w-full h-auto"
                        >
                    </div>
                    <a 
                        href="{{ asset('storage/' . $expense->receipt_path) }}" 
                        target="_blank"
                        class="mt-3 inline-flex items-center px-4 py-2 w-full justify-center border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 7v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h9"/>
                            <polyline points="18 14 23 9 18 4"/>
                            <line x1="23" y1="9" x2="9" y2="9"/>
                        </svg>
                        View Full Receipt
                    </a>
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Receipt</h2>
                </div>
                <div class="p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No receipt uploaded for this expense</p>
                    <a 
                        href="{{ route('expenses.edit', $expense) }}" 
                        class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3Z"></path>
                        </svg>
                        Edit Expense to Add Receipt
                    </a>
                </div>
            </div>
            @endif
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Actions</h2>
                </div>
                <div class="p-6 space-y-3">
                    <a 
                        href="{{ route('expenses.edit', $expense) }}" 
                        class="inline-flex items-center px-4 py-2 w-full justify-center border border-transparent bg-blue-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-blue-700"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3Z"></path>
                        </svg>
                        Edit Expense
                    </a>
                    <a 
                        href="#" 
                        class="inline-flex items-center px-4 py-2 w-full justify-center border border-gray-300 text-gray-700 rounded-md shadow-sm text-sm font-medium hover:bg-gray-50"
                        onclick="window.print(); return false;"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        Print Expense
                    </a>
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="inline-flex items-center px-4 py-2 w-full justify-center border border-red-300 text-red-700 rounded-md shadow-sm text-sm font-medium hover:bg-red-50"
                            onclick="return confirm('Are you sure you want to delete this expense?');"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                            Delete Expense
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
