<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - MiniMarket</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600">MiniMarket</a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                    <a href="/admin/profile" class="text-gray-700 hover:text-blue-600">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-5 sm:px-0">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Admin Profile</h3>
                    <div class="mt-5">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <div class="mt-1">
                                    <p class="text-sm text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <div class="mt-1">
                                    <p class="text-sm text-gray-900">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <div class="mt-1">
                                    <p class="text-sm text-gray-900">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                <div class="mt-1">
                                    <p class="text-sm text-gray-900">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 