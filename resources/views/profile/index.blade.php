@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('title', 'Profile - SuperMath')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Profile Header with Modern Design -->
    <div class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50"></div>

        <div class="relative bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-8 shadow-xl">
            <div class="flex flex-col lg:flex-row items-center justify-between space-y-6 lg:space-y-0">
                <!-- Profile Info -->
                <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <!-- Avatar with Gradient Border -->
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full"></div>
                        <div class="relative w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-2xl">
                            <span class="text-3xl font-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        <!-- Online Status -->
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 rounded-full border-4 border-white shadow-lg">
                            <div class="w-full h-full bg-green-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="text-center sm:text-left">
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $user->name }}</h1>
                        <div class="flex items-center justify-center sm:justify-start space-x-2 mb-3">
                            <span class="px-3 py-1 text-sm font-medium text-{{ $user->role === 'admin' ? 'purple' : 'blue' }}-700 bg-{{ $user->role === 'admin' ? 'purple' : 'blue' }}-100 rounded-full">
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="text-sm text-gray-500">•</span>
                            <span class="text-sm text-gray-600">Member since {{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <p class="text-gray-600 max-w-md">{{ $user->institution ?: 'Building the future of mathematics education' }}</p>
                    </div>
                </div>

                <!-- Credit Balance Card -->
                @if($user->credit !== null)
                <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl p-6 shadow-lg min-w-48">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-white text-sm font-medium opacity-90">Credit Balance</div>
                            <div class="text-2xl font-bold text-white">{{ $user->credit }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modern Dashboard Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Personal Information Card -->
        <div class="lg:col-span-2">
            <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white">Personal Information</h2>
                        <a href="{{ route('profile.edit-info') }}"
                           class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 flex items-center space-x-2 hover:-translate-y-1 hover:shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit</span>
                        </a>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Display Name</label>
                                <p class="text-lg font-medium text-gray-900">{{ $user->name ?: 'Not provided' }}</p>
                            </div>

                            <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                                <p class="text-lg font-medium text-gray-900">{{ $user->phone ?: 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-gradient-to-r from-green-50 to-teal-50 rounded-xl">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                                <p class="text-lg font-medium text-gray-900">
                                    {{ ($user->first_name && $user->last_name) ? $user->first_name . ' ' . $user->last_name : 'Not provided' }}
                                </p>
                            </div>

                            <div class="p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Institution</label>
                                <p class="text-lg font-medium text-gray-900">{{ $user->institution ?: 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Security & Stats -->
        <div class="space-y-6">
            <!-- Security Card -->
            <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-red-500 to-pink-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Account Security</h2>
                </div>

                <div class="p-6 space-y-4">
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-semibold text-gray-700">Email Address</div>
                                <div class="text-sm text-gray-600 truncate">{{ $user->email }}</div>
                            </div>
                            <a href="{{ route('profile.edit-email') }}"
                               class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1 rounded-lg text-xs font-medium hover:from-red-600 hover:to-pink-600 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                                Change
                            </a>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-semibold text-gray-700">Password</div>
                                <div class="text-sm text-gray-600">••••••••••</div>
                            </div>
                            <a href="{{ route('profile.edit-password') }}"
                               class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-3 py-1 rounded-lg text-xs font-medium hover:from-orange-600 hover:to-red-600 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                                Change
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Account Statistics</h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-indigo-600">{{ ucfirst($user->role) }}</div>
                            <div class="text-sm text-gray-600">Account Type</div>
                        </div>

                        <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $user->credit ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Available Credits</div>
                        </div>

                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 text-center">
                            <div class="text-lg font-bold text-blue-600">{{ $user->created_at->diffForHumans() }}</div>
                            <div class="text-sm text-gray-600">Member Since</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
        <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Quick Actions</h2>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Edit Profile Action -->
                <a href="{{ route('profile.edit-info') }}"
                   class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 hover:from-blue-100 hover:to-indigo-200 rounded-2xl p-6 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500 bg-opacity-10 rounded-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Edit Profile</h3>
                        <p class="text-gray-600 text-sm">Update your personal information and preferences</p>
                    </div>
                </a>

                <!-- Change Email Action -->
                <a href="{{ route('profile.edit-email') }}"
                   class="group relative overflow-hidden bg-gradient-to-br from-emerald-50 to-teal-100 hover:from-emerald-100 hover:to-teal-200 rounded-2xl p-6 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-500 bg-opacity-10 rounded-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Change Email</h3>
                        <p class="text-gray-600 text-sm">Update your email address securely</p>
                    </div>
                </a>

                <!-- Change Password Action -->
                <a href="{{ route('profile.edit-password') }}"
                   class="group relative overflow-hidden bg-gradient-to-br from-rose-50 to-pink-100 hover:from-rose-100 hover:to-pink-200 rounded-2xl p-6 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-rose-500 bg-opacity-10 rounded-full -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Change Password</h3>
                        <p class="text-gray-600 text-sm">Update your account password for better security</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
