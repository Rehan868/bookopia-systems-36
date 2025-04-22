
@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="animate-fade-in page-transition">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">My Profile</h1>
        <p class="text-muted-foreground mt-1">View and manage your account details</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Info Card -->
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 p-6">
                <h2 class="text-xl font-semibold">Profile Information</h2>
                <p class="text-sm text-gray-500 mt-1">Update your personal details</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <div class="md:w-1/3 flex flex-col items-center">
                            <div class="relative">
                                <img 
                                    src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3B82F6&color=ffffff&size=200' }}" 
                                    alt="{{ $user->name }}" 
                                    class="w-40 h-40 rounded-full object-cover border-4 border-white shadow"
                                >
                                <label for="profile_image" class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full cursor-pointer shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </label>
                                <input type="file" id="profile_image" name="profile_image" class="hidden" accept="image/*">
                            </div>
                            <p class="text-sm text-gray-500 mt-3">Click on the pencil to change your photo</p>
                        </div>
                        
                        <div class="md:w-2/3 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ $user->phone }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">{{ $user->address }}</textarea>
                        </div>
                        
                        <div class="pt-3 border-t border-gray-200 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary btn-transition">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Account Settings Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-fit">
            <div class="border-b border-gray-200 p-6">
                <h2 class="text-xl font-semibold">Account Settings</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your account security</p>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Change Password Form -->
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <h3 class="text-md font-medium">Change Password</h3>
                    
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary btn-transition">
                            Update Password
                        </button>
                    </div>
                </form>
                
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-md font-medium">Session Information</h3>
                    
                    <div class="mt-3 text-sm text-gray-500">
                        <p>Last login: <span class="font-semibold text-gray-700">{{ $user->last_login ? $user->last_login->format('M d, Y H:i') : 'Never' }}</span></p>
                        <p class="mt-1">IP Address: <span class="font-semibold text-gray-700">{{ request()->ip() }}</span></p>
                    </div>
                    
                    <div class="mt-4">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 border border-red-100 rounded-md hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 btn-transition">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
