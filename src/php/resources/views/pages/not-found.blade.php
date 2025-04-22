
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - {{ config('app.name', 'Hotel Management System') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full text-center p-8">
        <div class="mb-8">
            <div class="text-primary text-9xl font-bold">404</div>
            <h1 class="text-3xl font-bold mt-4">Page Not Found</h1>
            <p class="text-gray-600 mt-2">The page you are looking for does not exist or has been moved.</p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ route('dashboard') }}" class="inline-block px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary btn-transition">
                Return to Dashboard
            </a>
            
            <div>
                <a href="{{ route('login') }}" class="text-primary hover:underline">Back to Login Page</a>
            </div>
        </div>
    </div>
</body>
</html>
