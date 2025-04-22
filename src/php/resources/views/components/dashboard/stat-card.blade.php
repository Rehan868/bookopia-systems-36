
<div class="bg-white p-6 rounded-lg shadow-sm border hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="mt-2 text-3xl font-semibold">{{ $value }}</p>
            @if(isset($trend))
            <p class="mt-2 text-sm {{ $trend > 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $trend > 0 ? '+' : '' }}{{ $trend }}% from last period
            </p>
            @endif
        </div>
        <div class="p-3 bg-primary-50 rounded-full">
            <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                @switch($icon)
                    @case('calendar')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        @break
                    @case('check-circle')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @break
                    @default
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                @endswitch
            </svg>
        </div>
    </div>
</div>
