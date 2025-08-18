@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('title', 'Profile - Edufacilita')

@section('content')


<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    <!-- Professional Profile Header -->
    <div class="relative overflow-hidden bg-white rounded-2xl shadow-xl border border-slate-200">
        <!-- Subtle background pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/30 via-indigo-50/20 to-purple-50/30"></div>
        <div class="absolute top-0 right-0 w-64 h-64 opacity-5">
            <svg viewBox="0 0 200 200" class="w-full h-full text-blue-600">
                <defs>
                    <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="currentColor" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="relative p-8">
            <div class="flex flex-col lg:flex-row items-center justify-between space-y-6 lg:space-y-0">
                <!-- Profile Information -->
                <div class="flex flex-col sm:flex-row items-center space-y-6 sm:space-y-0 sm:space-x-8">
                    <!-- Professional Avatar -->
                    <div class="relative group">
                        <div class="w-28 h-28 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                            <span class="text-3xl font-bold text-white tracking-wide">
                                {{ strtoupper(substr($user->first_name ?: $user->name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?: '', 0, 1)) }}
                            </span>
                        </div>
                        <!-- Status indicator -->
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-gradient-to-r from-emerald-500 to-green-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                            <div class="w-3 h-3 bg-white rounded-full"></div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="text-center sm:text-left">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">
                            {{ ($user->first_name && $user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->name }}
                        </h1>

                        <div class="flex items-center justify-center sm:justify-start flex-wrap gap-3 mb-4">
                            <div class="flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ ucfirst($user->role) }}</span>
                            </div>

                            <div class="flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm">{{ $user->email }}</span>
                            </div>
                        </div>

                        @if($user->institution)
                        <div class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 rounded-full shadow-sm">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ $user->institution }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Credit Balance (for non-admin users) -->
                @if($user->role !== 'admin')
                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-amber-800">{{ auth()->user()->credit ?? 0 }} Credits</div>
                            <div class="text-sm text-amber-600">Available Balance</div>
                        </div>
                    </div>
                    <button class="w-full mt-3 bg-gradient-to-r from-amber-600 to-yellow-600 hover:from-amber-700 hover:to-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        Purchase Credits
                    </button>
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
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center space-x-4 flex-1 min-w-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-200 flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-slate-800">Email Address</p>
                                    <p class="text-sm text-slate-600 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit-email') }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex-shrink-0">
                                Update
                            </a>
                        </div>
                    </div>

                    <!-- Password Management -->
                    <div class="group bg-slate-50 border border-slate-200 rounded-xl p-5 hover:bg-slate-100 transition-all duration-200">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center space-x-4 flex-1 min-w-0">
                                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition-colors duration-200 flex-shrink-0">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.586l4.707-4.707C10.923 2.663 11.596 2 12.414 2h.172a2 2 0 012 2v4.586l3.707 3.707c.195.195.293.45.293.707z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-slate-800">Password</p>
                                    <p class="text-sm text-slate-600">••••••••••••••</p>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit-password') }}"
                               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 text-sm font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex-shrink-0">
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
