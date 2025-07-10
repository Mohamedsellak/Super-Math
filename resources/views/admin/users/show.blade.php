@extends('layouts.admin')

@section('content')
<!-- Clean Background with Gradient -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <div class="p-6">
        <!-- Enhanced Header with Glass Morphism -->
        <div class="mb-8 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/30 p-6">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                <div class="space-y-3">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-900 bg-clip-text text-transparent">User Details</h1>
                            <p class="text-gray-600 font-medium mt-1">Complete profile overview</p>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-16 text-lg">Viewing comprehensive information for {{ $user->first_name }} {{ $user->last_name }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-600 hover:from-blue-600 hover:via-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg flex items-center space-x-3">
                        <div class="p-1 bg-white/20 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <span>Edit User</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg flex items-center space-x-3">
                        <div class="p-1 bg-white/20 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </div>
                        <span>Back to Users</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Enhanced User Profile Card with Glass Morphism -->
            <div class="lg:col-span-1">
                <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="px-6 py-8 text-center bg-gradient-to-br from-blue-50/80 via-indigo-50/80 to-purple-50/80 backdrop-blur-sm relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-600/10 opacity-50"></div>
                        <div class="relative z-10">
                            <div class="mx-auto h-28 w-28 rounded-full bg-gradient-to-br from-blue-400 via-purple-500 to-indigo-600 flex items-center justify-center mb-4 shadow-xl">
                                <span class="text-4xl font-bold text-white">
                                    {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                </span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h2>
                            <p class="text-gray-600 mt-1 font-medium">{{ $user->email }}</p>
                            <span class="inline-flex mt-3 px-4 py-2 text-sm font-semibold rounded-full border-2 {{ $user->role === 'admin' ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 border-purple-300' : 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border-green-300' }}">
                                @if($user->role === 'admin')
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <div class="px-6 py-6">
                        <div class="space-y-4">
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">User ID</label>
                                <p class="text-gray-900 font-mono text-lg group-hover:text-blue-600 transition-colors duration-200">#{{ $user->id }}</p>
                            </div>
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">Phone Number</label>
                                <p class="text-gray-900 text-lg group-hover:text-blue-600 transition-colors duration-200">{{ $user->phone ?? 'Not provided' }}</p>
                            </div>
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">Institution</label>
                                <p class="text-gray-900 text-lg group-hover:text-blue-600 transition-colors duration-200">{{ $user->institution ?? 'Not specified' }}</p>
                            </div>
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">Current Credit</label>
                                <div class="flex items-center mt-2">
                                    <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center shadow-md mr-3">
                                    </div>
                                    <p class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">${{ number_format($user->credit, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200/50 bg-gradient-to-r from-gray-50/80 to-gray-100/80 backdrop-blur-sm">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span class="font-medium">Member since</span>
                            <span class="font-semibold text-blue-600">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Quick Actions -->
                <div class="mt-6 bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-red-50/50 to-red-100/50">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-red-500 to-red-600 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Delete User</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-3 rounded-xl font-semibold shadow-lg transition-all duration-300 flex items-center justify-center space-x-2">
                                <div class="p-1 bg-white/20 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </div>
                                <span>Delete User</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Details Section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Enhanced Account Information -->
                <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-blue-50/50 to-indigo-50/50">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Account Information</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">First Name</label>
                                <p class="text-lg text-gray-900 mt-1 group-hover:text-blue-600 transition-colors duration-200 font-semibold">{{ $user->first_name }}</p>
                            </div>
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">Last Name</label>
                                <p class="text-lg text-gray-900 mt-1 group-hover:text-blue-600 transition-colors duration-200 font-semibold">{{ $user->last_name }}</p>
                            </div>
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">Email Address</label>
                                <p class="text-lg text-gray-900 mt-1 group-hover:text-blue-600 transition-colors duration-200 font-semibold break-all">{{ $user->email }}</p>
                            </div>
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">Phone Number</label>
                                <p class="text-lg text-gray-900 mt-1 group-hover:text-blue-600 transition-colors duration-200 font-semibold">{{ $user->phone ?? 'Not provided' }}</p>
                            </div>
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">Institution</label>
                                <p class="text-lg text-gray-900 mt-1 group-hover:text-blue-600 transition-colors duration-200 font-semibold">{{ $user->institution ?? 'Not specified' }}</p>
                            </div>
                            <div class="group">
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wider">Role</label>
                                <p class="text-lg text-gray-900 mt-1 group-hover:text-blue-600 transition-colors duration-200 font-semibold">{{ ucfirst($user->role) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Account Statistics -->
                <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-blue-50/50 to-indigo-50/50">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Account Statistics</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group relative bg-gradient-to-br from-blue-50/80 to-blue-100/80 backdrop-blur-sm rounded-xl p-4 border border-blue-200/50 hover:shadow-lg transition-all duration-300">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                                <div class="relative z-10 flex items-center">
                                    <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg">
                                        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-bold text-white">$</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-blue-700 uppercase tracking-wider">Current Credit</p>
                                        <div class="flex items-center mt-1">
                                            <div class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center shadow-sm mr-2">
                                                <span class="text-sm font-bold text-yellow-900">$</span>
                                            </div>
                                            <p class="text-2xl font-bold text-blue-900">{{ number_format($user->credit, 0) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="group relative bg-gradient-to-br from-green-50/80 to-green-100/80 backdrop-blur-sm rounded-xl p-4 border border-green-200/50 hover:shadow-lg transition-all duration-300">
                                <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                                <div class="relative z-10 flex items-center">
                                    <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-700 rounded-xl shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-green-700 uppercase tracking-wider">Account Status</p>
                                        <p class="text-2xl font-bold text-green-900 mt-1">Active</p>
                                    </div>
                                </div>
                            </div>

                            <div class="group relative bg-gradient-to-br from-purple-50/80 to-purple-100/80 backdrop-blur-sm rounded-xl p-4 border border-purple-200/50 hover:shadow-lg transition-all duration-300">
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                                <div class="relative z-10 flex items-center">
                                    <div class="p-3 bg-gradient-to-br from-purple-500 to-indigo-700 rounded-xl shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m0 0V7h4v6m-4 0H4m8 0h4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-purple-700 uppercase tracking-wider">Days Active</p>
                                        <p class="text-2xl font-bold text-purple-900 mt-1">{{ $user->created_at->diffInDays(now()) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="group relative bg-gradient-to-br from-yellow-50/80 to-yellow-100/80 backdrop-blur-sm rounded-xl p-4 border border-yellow-200/50 hover:shadow-lg transition-all duration-300">
                                <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-orange-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                                <div class="relative z-10 flex items-center">
                                    <div class="p-3 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold text-yellow-700 uppercase tracking-wider">Last Updated</p>
                                        <p class="text-lg font-bold text-yellow-900 mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Account Timeline -->
                <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-blue-50/50 to-indigo-50/50">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Account Timeline</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul class="-mb-8">
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center ring-8 ring-white shadow-lg">
                                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">Account created</p>
                                                    <p class="text-xs text-gray-500 mt-1">User joined the platform</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap">
                                                    <span class="text-gray-900 font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                                                    <p class="text-xs text-gray-500">{{ $user->created_at->format('H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center ring-8 ring-white shadow-lg">
                                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">Last profile update</p>
                                                    <p class="text-xs text-gray-500 mt-1">Most recent changes made</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap">
                                                    <span class="text-gray-900 font-medium">{{ $user->updated_at->format('M d, Y') }}</span>
                                                    <p class="text-xs text-gray-500">{{ $user->updated_at->format('H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection