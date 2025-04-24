
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login - Hotel Management System</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="mx-auto mb-6 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-primary">
                    <path d="M2 12h20"></path>
                    <path d="M2 20h20"></path>
                    <path d="M2 4h20"></path>
                    <path d="M6 12v8"></path>
                    <path d="M18 12v8"></path>
                    <path d="M12 12v8"></path>
                    <path d="M6 4v4"></path>
                    <path d="M18 4v4"></path>
                    <path d="M12 4v4"></path>
                </svg>
                <h1 class="ml-2 text-2xl font-bold text-gray-900">Owner Portal</h1>
            </div>
            
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                <div class="p-6 sm:p-8">
                    <h2 class="mb-1 text-xl font-semibold">Welcome back</h2>
                    <p class="text-sm text-muted-foreground">Property Owner Access</p>
                    
                    @if (session('success'))
                        <div class="mt-4 rounded-md bg-green-50 p-4 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mt-4 rounded-md bg-red-50 p-4 text-red-700">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('owner.login') }}" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="email" class="text-sm font-medium leading-none">
                                Email
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="mt-2 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                placeholder="name@example.com" 
                                value="{{ old('email') }}"
                                required 
                                autofocus
                            />
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="text-sm font-medium leading-none">
                                    Password
                                </label>
                                <a href="#" class="text-sm text-primary hover:underline">
                                    Forgot password?
                                </a>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="mt-2 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                                required
                            />
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <input 
                                type="checkbox" 
                                id="remember" 
                                name="remember" 
                                class="h-4 w-4 rounded border-gray-300"
                            />
                            <label for="remember" class="text-sm text-muted-foreground">
                                Remember me
                            </label>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="inline-flex h-10 w-full items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
                        >
                            Sign In
                        </button>
                    </form>
                    
                    <div class="mt-6 text-center text-sm">
                        <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">
                            Login as Staff Member
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
