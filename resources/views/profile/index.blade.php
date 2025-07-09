@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('title', 'Profile - SuperMath')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 py-8">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    <!-- Creative Professional Header -->
    <div class="relative overflow-hidden bg-white rounded-3xl shadow-2xl border border-blue-100">
        <!-- Enhanced background patterns -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 opacity-60"></div>
        <div class="absolute top-0 right-0 w-96 h-96 opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full text-blue-600">
                <defs>
                    <pattern id="hexagons" width="40" height="35" patternUnits="userSpaceOnUse">
                        <polygon points="20,5 35,15 35,30 20,40 5,30 5,15" fill="none" stroke="currentColor" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hexagons)" />
            </svg>
        </div>
        
        <div class="relative p-10">
            <div class="flex flex-col lg:flex-row items-center justify-between space-y-8 lg:space-y-0">
                <!-- Enhanced Profile Information -->
                <div class="flex flex-col sm:flex-row items-center space-y-6 sm:space-y-0 sm:space-x-10">
                    <!-- Creative Avatar Section -->
                    <div class="relative group">
                        <div class="w-36 h-36 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 rounded-3xl flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-500 hover:scale-105">
                            <span class="text-5xl font-bold text-white tracking-wider">
                                {{ strtoupper(substr($user->first_name ?: $user->name, 0, 1)) }}
                            </span>
                        </div>
                        <!-- Enhanced status indicator -->
                        <div class="absolute -bottom-3 -right-3 w-12 h-12 bg-gradient-to-r from-emerald-400 to-green-500 rounded-2xl border-4 border-white shadow-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <div class="w-4 h-4 bg-emerald-200 rounded-full animate-pulse"></div>
                        </div>
                        <!-- Floating decoration -->
                        <div class="absolute -top-2 -left-2 w-6 h-6 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full shadow-lg opacity-75 animate-bounce"></div>
                    </div>

                    <!-- Enhanced User Details -->
                    <div class="text-center sm:text-left">
                        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-gray-900 via-blue-800 to-purple-700 bg-clip-text text-transparent mb-4">
                            {{ ($user->first_name && $user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->name }}
                        </h1>
                        
                        <div class="flex items-center justify-center sm:justify-start flex-wrap gap-4 mb-6">
                            <div class="flex items-center px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl border border-blue-300 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-bold text-lg">{{ ucfirst($user->role) }}</span>
                            </div>
                            
                            <div class="flex items-center px-5 py-3 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 rounded-2xl border border-purple-200 shadow-md">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-semibold">Since {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>

                        @if($user->institution)
                        <div class="bg-white/70 backdrop-blur-sm border border-slate-200 rounded-xl p-4 max-w-md">
                            <p class="text-slate-600 font-medium">{{ $user->institution }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Credit Balance -->
                @if($user->role !== 'admin')
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 shadow-xl text-white min-w-56">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">Available Credits</p>
                            <p class="text-3xl font-bold">{{ number_format($user->credit) }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sophisticated Information Layout -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <!-- Main Information Panel -->
        <div class="xl:col-span-2 space-y-8">
            <!-- Personal Details Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-blue-50 border-b border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">Personal Information</h2>
                        </div>
                        <a href="{{ route('profile.edit-info') }}"
                           class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Details
                        </a>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- First Name -->
                        <div class="group">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <label class="text-sm font-semibold text-slate-600 uppercase tracking-wider">First Name</label>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 group-hover:bg-slate-100 transition-colors duration-200">
                                <p class="text-lg font-semibold text-slate-800">{{ $user->first_name ?: 'Not provided' }}</p>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="group">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <label class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Last Name</label>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 group-hover:bg-slate-100 transition-colors duration-200">
                                <p class="text-lg font-semibold text-slate-800">{{ $user->last_name ?: 'Not provided' }}</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="group">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <label class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Phone Number</label>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 group-hover:bg-slate-100 transition-colors duration-200">
                                <p class="text-lg font-semibold text-slate-800">{{ $user->phone ?: 'Not provided' }}</p>
                            </div>
                        </div>

                        <!-- Institution -->
                        <div class="group">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <label class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Institution</label>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 group-hover:bg-slate-100 transition-colors duration-200">
                                <p class="text-lg font-semibold text-slate-800">{{ $user->institution ?: 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Email Section -->
                    <div class="mt-8 pt-6 border-t border-slate-200">
                        <div class="group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center group-hover:bg-rose-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <label class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Email Address</label>
                                </div>
                                @if($user->email_verified_at)
                                    <span class="flex items-center px-3 py-1 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full border border-emerald-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Verified
                                    </span>
                                @else
                                    <span class="flex items-center px-3 py-1 text-xs font-semibold text-amber-700 bg-amber-100 rounded-full border border-amber-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 group-hover:bg-slate-100 transition-colors duration-200">
                                <p class="text-lg font-semibold text-slate-800">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-8">
            <!-- Security Management -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-rose-50 border-b border-slate-200 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-rose-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800">Security Settings</h2>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Email Management -->
                    <div class="group bg-slate-50 border border-slate-200 rounded-xl p-5 hover:bg-slate-100 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-200">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">Email Address</p>
                                    <p class="text-sm text-slate-600 truncate max-w-36">{{ $user->email }}</p>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit-email') }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Update
                            </a>
                        </div>
                    </div>

                    <!-- Password Management -->
                    <div class="group bg-slate-50 border border-slate-200 rounded-xl p-5 hover:bg-slate-100 transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition-colors duration-200">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.586l4.707-4.707C10.923 2.663 11.596 2 12.414 2h.172a2 2 0 012 2v4.586l3.707 3.707c.195.195.293.45.293.707z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">Password</p>
                                    <p class="text-sm text-slate-600">••••••••••••••</p>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit-password') }}"
                               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 text-sm font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Change
                            </a>
                        </div>
                    </div>

                    <!-- Security Status -->
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-emerald-800">Account Secured</p>
                                <p class="text-sm text-emerald-700">All security measures active</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Professional Action Center -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-slate-50 to-emerald-50 border-b border-slate-200 p-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800">Quick Actions</h2>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Edit Profile -->
                <a href="{{ route('profile.edit-info') }}"
                   class="group relative bg-gradient-to-br from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 border border-blue-200 rounded-2xl p-6 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-blue-700 transition-colors duration-300">Edit Profile</h3>
                            <p class="text-sm text-slate-600">Update personal information</p>
                        </div>
                    </div>
                    <div class="flex items-center text-blue-600 group-hover:text-blue-700 transition-colors duration-300">
                        <span class="text-sm font-medium">Manage details</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Change Email -->
                <a href="{{ route('profile.edit-email') }}"
                   class="group relative bg-gradient-to-br from-emerald-50 to-teal-50 hover:from-emerald-100 hover:to-teal-100 border border-emerald-200 rounded-2xl p-6 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-14 h-14 bg-emerald-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-emerald-700 transition-colors duration-300">Update Email</h3>
                            <p class="text-sm text-slate-600">Change email address</p>
                        </div>
                    </div>
                    <div class="flex items-center text-emerald-600 group-hover:text-emerald-700 transition-colors duration-300">
                        <span class="text-sm font-medium">Secure update</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Change Password -->
                <a href="{{ route('profile.edit-password') }}"
                   class="group relative bg-gradient-to-br from-rose-50 to-pink-50 hover:from-rose-100 hover:to-pink-100 border border-rose-200 rounded-2xl p-6 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-14 h-14 bg-rose-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-rose-700 transition-colors duration-300">Change Password</h3>
                            <p class="text-sm text-slate-600">Update security credentials</p>
                        </div>
                    </div>
                    <div class="flex items-center text-rose-600 group-hover:text-rose-700 transition-colors duration-300">
                        <span class="text-sm font-medium">Enhance security</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
