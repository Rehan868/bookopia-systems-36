
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login - {{ config('app.name', 'Hotel Management System') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen page-transition">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary">Property Owner Portal</h1>
            <p class="text-gray-600 mt-2">Manage your hotel properties with ease</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-8 hover-card-effect">
            @if ($errors->any())
            <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 animate-fade-in">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="is_owner" value="1">
                
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input id="email" name="email" type="email" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded-md input-focus-effect" value="{{ old('email') }}">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md input-focus-effect">
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        
                        <div>
                            <a href="#" class="text-sm text-primary hover:underline">Forgot password?</a>
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary btn-transition">
                            Sign in
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Hotel staff? <a href="{{ route('login') }}" class="text-primary hover:underline">Login to Staff Portal</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
