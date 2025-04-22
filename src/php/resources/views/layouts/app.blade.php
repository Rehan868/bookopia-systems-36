
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Hotel Management System') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    @stack('styles')
</head>
<body class="bg-background">
    <div class="flex min-h-screen w-full">
        @auth
            @if(request()->is('owner*'))
                @include('components.layout.owner-sidebar')
            @else
                @include('components.layout.sidebar')
            @endif
        @endauth
        
        <div class="flex-1 flex flex-col">
            @auth
                @include('components.layout.header')
            @endauth
            
            <main class="flex-1 p-6 bg-background overflow-auto">
                <div class="max-w-[1600px] mx-auto">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
