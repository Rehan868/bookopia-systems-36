
<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
    <div class="flex items-center">
        <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 lg:hidden" id="toggle-sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>
        
        <div class="ml-6 relative">
            <form action="{{ request()->is('owner/*') ? route('owner.search') : route('search') }}" method="GET">
                <div class="flex items-center">
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                        </div>
                        <input type="text" name="search" id="search" class="pl-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary block w-full sm:text-sm" placeholder="Search...">
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="flex items-center space-x-4">
        <div class="relative">
            <button type="button" class="p-1 text-gray-500 hover:text-gray-700 focus:outline-none" id="notifications-dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
            </button>
            <!-- Notifications dropdown would go here -->
        </div>
        
        <div class="relative">
            <button type="button" class="flex items-center space-x-2 focus:outline-none" id="user-menu">
                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=ffffff" alt="{{ Auth::user()->name }}">
                <div class="hidden md:flex md:flex-col md:items-start">
                    <span class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"></path></svg>
            </button>
            <!-- User menu dropdown would go here -->
        </div>
    </div>
</header>
