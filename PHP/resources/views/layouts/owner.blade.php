
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Portal - @yield('title', 'Dashboard')</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 border-r bg-background hidden md:block">
            <div class="p-6">
                <div class="flex items-center gap-2 text-2xl font-semibold">
                    <span class="text-primary">Owner Portal</span>
                </div>
                
                <nav class="mt-8 space-y-1">
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium {{ Route::is('owner.dashboard') ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:bg-muted' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('owner.bookings') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium {{ Route::is('owner.bookings') ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:bg-muted' }}">
                        Bookings
                    </a>
                    <a href="{{ route('owner.availability') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium {{ Route::is('owner.availability') ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:bg-muted' }}">
                        Availability
                    </a>
                    <a href="{{ route('owner.cleaning') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium {{ Route::is('owner.cleaning') ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:bg-muted' }}">
                        Cleaning Status
                    </a>
                    <a href="{{ route('owner.reports') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium {{ Route::is('owner.reports') ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:bg-muted' }}">
                        Reports
                    </a>
                </nav>
            </div>
            
            <div class="p-6 mt-auto border-t">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('owner-logout-form').submit();" class="flex items-center gap-2 w-full rounded-md border px-4 py-2 text-sm font-medium border-input bg-background hover:bg-accent hover:text-accent-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Log Out
                </a>
                <form id="owner-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b bg-background px-6">
                <div class="hidden md:flex-1 md:block">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input type="search" placeholder="Search..." class="pl-8 bg-background w-full max-w-sm border border-input rounded-md px-3 py-2 text-sm">
                    </div>
                </div>
                
                <div class="flex flex-1 items-center justify-end gap-4">
                    <button class="text-muted-foreground rounded-full hover:bg-accent hover:text-foreground p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                        </svg>
                    </button>
                    
                    <div class="relative" x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen" class="relative h-9 w-9 rounded-full">
                            <div class="h-9 w-9 rounded-full overflow-hidden bg-muted flex items-center justify-center">
                                <img src="{{ asset('avatars/02.png') }}" alt="Avatar" class="h-full w-full object-cover">
                                <span class="font-medium text-sm">OW</span>
                            </div>
                        </button>
                        
                        <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white border" style="display: none;">
                            <div class="py-2 px-4 border-b">
                                <p class="text-sm font-medium">Owner User</p>
                                <p class="text-xs text-gray-500">owner@example.com</p>
                            </div>
                            
                            <div class="py-1">
                                <a href="#" class="flex items-center px-4 py-2 text-sm hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span>Profile</span>
                                </a>
                                
                                <a href="#" class="flex items-center px-4 py-2 text-sm hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <span>Settings</span>
                                </a>
                            </div>
                            
                            <div class="py-1 border-t">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('header-owner-logout-form').submit();" class="flex items-center px-4 py-2 text-sm hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    <span>Log out</span>
                                </a>
                                <form id="header-owner-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main content -->
            <main class="flex-1 p-6 bg-background overflow-auto">
                <div class="max-w-[1600px] mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireScripts
</body>
</html>
