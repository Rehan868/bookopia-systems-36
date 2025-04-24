
<div class="h-screen sticky top-0 bg-card border-r border-border flex flex-col transition-all duration-300 ease-in-out w-64">
    <div class="flex items-center justify-between h-16 px-3 border-b border-border">
        <div class="font-semibold text-lg tracking-tight">
            HotelManager
        </div>
        <button class="rounded-full" id="toggle-sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                <path d="m15 18-6-6 6-6"></path>
            </svg>
        </button>
    </div>
    
    <div class="flex-grow overflow-y-auto py-4 px-2">
        <div class="mb-6">
            <div class="text-xs font-semibold text-foreground/50 uppercase tracking-wider px-3 mb-2">
                Overview
            </div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('dashboard') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('bookings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('bookings.*') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                    <span>Bookings</span>
                </a>
                
                <a href="{{ route('availability') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('availability') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Availability</span>
                </a>
            </div>
        </div>
        
        <div class="mb-6">
            <div class="text-xs font-semibold text-foreground/50 uppercase tracking-wider px-3 mb-2">
                Management
            </div>
            <div class="space-y-1">
                <a href="{{ route('rooms.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('rooms.*') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Rooms</span>
                </a>
                
                <a href="{{ url('/expenses') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Request::is('expenses*') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <circle cx="12" cy="12" r="8"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>Expenses</span>
                </a>
                
                <a href="{{ route('cleaning') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('cleaning') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="M8.46 8.46a4 4 0 1 1 5.66 5.66"></path>
                        <path d="m2 22 3-3"></path>
                        <path d="M10.5 13.5 7 17"></path>
                        <path d="m7 7 5.5 5.5"></path>
                        <path d="M18 2a2 2 0 1 1 4 0c0 .56-.23 1.08-.61 1.46L10 15"></path>
                    </svg>
                    <span>Cleaning Status</span>
                </a>
            </div>
        </div>
        
        <div class="mb-6">
            <div class="text-xs font-semibold text-foreground/50 uppercase tracking-wider px-3 mb-2">
                Administration
            </div>
            <div class="space-y-1">
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('users.*') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Users</span>
                </a>
                
                <a href="{{ route('owners.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('owners.*') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Owners</span>
                </a>
                
                <a href="{{ route('reports') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('reports') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="M3 3v18h18"></path>
                        <path d="m19 9-5 5-4-4-3 3"></path>
                    </svg>
                    <span>Reports</span>
                </a>
                
                <a href="{{ url('/audit-logs') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Request::is('audit-logs*') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"></path>
                    </svg>
                    <span>Audit Logs</span>
                </a>
                
                <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group {{ Route::is('settings') ? 'bg-primary/10 text-primary font-medium' : 'text-foreground/70 hover:bg-accent hover:text-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <span>Settings</span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-2 border-t border-border">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all duration-200 group text-foreground/70 hover:bg-accent hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 transition-transform group-hover:scale-110">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>
