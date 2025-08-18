<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Edufacilita</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js CDN for dropdown functionality -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Additional head content -->
    @stack('head')
</head>
<body class="bg-gray-50 min-h-screen font-sans" x-data="{ mobileMenuOpen: false }">
    <div class="flex h-screen bg-gray-100">
        <!-- Mobile Menu Toggle Button -->
        <button class="fixed top-4 left-4 z-50 md:hidden w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg shadow-sm transition-all duration-200 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-gray-300"
                @click="mobileMenuOpen = true"
                aria-label="Toggle navigation menu">
            <svg class="w-6 h-6 text-gray-600 hover:text-gray-800 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>



        <!-- Enhanced Desktop Sidebar -->
        <div class="hidden md:flex md:flex-col w-80 bg-white shadow-2xl border-r border-gray-200 flex-shrink-0 relative"
             id="adminSidebar">

            <!-- Sidebar Header -->
            <div class="relative px-8 py-10 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center space-x-4">
                    <!-- Logo Icon -->
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <!-- Platform Name -->
                    <div>
                        <h1 class="text-2xl font-black text-gray-800 tracking-tight">Edufacilita</h1>
                        <div class="text-xs text-gray-500 font-medium tracking-wider uppercase mt-1">
                            Admin Dashboard
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="relative px-6 py-8 flex flex-col h-full overflow-y-auto">
                <div class="space-y-3 flex-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                       class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-blue-50 hover:shadow-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-900 shadow-md border border-blue-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">Dashboard</span>
                    </div>
                    <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- User Management -->
                <a href="{{ route('admin.users.index') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-emerald-50 hover:shadow-md {{ request()->routeIs('admin.users.*') ? 'bg-emerald-100 text-emerald-900 shadow-md border border-emerald-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">User Management</span>
                    </div>
                    <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Questions -->
                <a href="{{ route('admin.questions.index') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-amber-50 hover:shadow-md {{ request()->routeIs('admin.questions.*') ? 'bg-amber-100 text-amber-900 shadow-md border border-amber-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">Questions</span>
                    </div>
                    <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Subjects -->
                <a href="{{ route('admin.subjects.index') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-indigo-50 hover:shadow-md {{ request()->routeIs('admin.subjects.*') ? 'bg-indigo-100 text-indigo-900 shadow-md border border-indigo-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">Subjects</span>
                    </div>
                    <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Topics -->
                <a href="{{ route('admin.topics.index') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-green-50 hover:shadow-md {{ request()->routeIs('admin.topics.*') ? 'bg-green-100 text-green-900 shadow-md border border-green-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">Topics</span>
                    </div>
                    <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>


                </div>

                <!-- Logout Section - Fixed at bottom -->
                <div class="mt-auto pt-6 border-t border-gray-200">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="group relative flex items-center w-full px-4 py-4 text-gray-600 hover:text-red-600 rounded-xl transition-all duration-300 hover:bg-red-50 hover:shadow-md">
                            <div class="flex items-center space-x-4 w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-base tracking-wide">Sign Out</span>
                            </div>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Mobile Sidebar -->
        <div class="md:hidden fixed left-0 top-0 z-50 h-screen w-80 bg-white shadow-2xl transform transition-transform duration-300 border-r border-gray-200"
             :class="{'translate-x-0': mobileMenuOpen, '-translate-x-full': !mobileMenuOpen}"
             id="mobileSidebar">

            <!-- Mobile Sidebar Header -->
            <div class="relative px-6 py-8 border-b border-gray-200 bg-gray-50">
                <!-- Close Button -->
                <button class="absolute top-4 right-4 w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all duration-200 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-gray-300"
                        @click="mobileMenuOpen = false"
                        aria-label="Close navigation menu">
                    <svg class="w-5 h-5 text-gray-600 hover:text-gray-800 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="flex items-center space-x-4 pr-16">
                    <!-- Logo Icon -->
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <!-- Platform Name -->
                    <div>
                        <h1 class="text-xl font-black text-gray-800 tracking-tight">Edufacilita</h1>
                        <div class="text-xs text-gray-500 font-medium tracking-wider uppercase mt-1">
                            Admin Dashboard
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <nav class="relative px-6 py-6 flex flex-col h-full overflow-y-auto">
                <div class="space-y-3 flex-1">
                    <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-blue-50 hover:shadow-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-900 shadow-md border border-blue-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">Dashboard</span>
                    </div>
                </a>

                <!-- User Management -->
                <a href="{{ route('admin.users.index') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-emerald-50 hover:shadow-md {{ request()->routeIs('admin.users.*') ? 'bg-emerald-100 text-emerald-900 shadow-md border border-emerald-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">User Management</span>
                    </div>
                </a>

                <!-- Questions -->
                <a href="{{ route('admin.questions.index') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-amber-50 hover:shadow-md {{ request()->routeIs('admin.questions.*') ? 'bg-amber-100 text-amber-900 shadow-md border border-amber-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">Questions</span>
                    </div>
                </a>

                <!-- Subjects -->
                <a href="{{ route('admin.subjects.index') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-indigo-50 hover:shadow-md {{ request()->routeIs('admin.subjects.*') ? 'bg-indigo-100 text-indigo-900 shadow-md border border-indigo-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">Subjects</span>
                    </div>
                </a>

                <!-- Topics -->
                <a href="{{ route('admin.topics.index') }}"
                   class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-green-50 hover:shadow-md {{ request()->routeIs('admin.topics.*') ? 'bg-green-100 text-green-900 shadow-md border border-green-200' : '' }}">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-wide">Topics</span>
                    </div>
                </a>
                </div>

                <!-- Logout Section - Fixed at bottom -->
                <div class="mt-auto pt-6 border-t border-gray-200">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="group relative flex items-center w-full px-4 py-4 text-gray-600 hover:text-red-600 rounded-xl transition-all duration-300 hover:bg-red-50 hover:shadow-md">
                            <div class="flex items-center space-x-4 w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-base tracking-wide">Sign Out</span>
                            </div>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 min-w-0">
            <!-- Header -->
            <div class="sticky top-0 z-10 bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <!-- Mobile Logo and Credits (only visible on mobile) -->
                        <div class="md:hidden flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Edufacilita</h2>
                            </div>
                        </div>

                        <!-- Page Title (visible on desktop) -->
                        <div class="hidden md:block">

                        </div>

                        <!-- Right side - User menu and notifications -->
                        <div class="flex items-center space-x-3">
                            <!-- Notifications -->
                            <div class="relative" x-data="{ notificationsOpen: false }">
                                <button class="p-2 text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors relative focus:outline-none"
                                        @click="notificationsOpen = !notificationsOpen">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <!-- Notification Badge -->
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">3</span>
                                </button>

                                <!-- Notifications Dropdown -->
                                <div x-show="notificationsOpen"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     @click.away="notificationsOpen = false"
                                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1 border border-gray-200 z-50">
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                                3 New
                                            </span>
                                        </div>
                                    </div>

                                    <div class="max-h-96 overflow-y-auto">
                                        <!-- Notification Item -->
                                        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-l-4 border-blue-500 bg-blue-50">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">Credits Added</p>
                                                    <p class="text-sm text-gray-600">50 credits have been added to your account</p>
                                                    <p class="text-xs text-gray-500 mt-1">2 minutes ago</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Notification Item -->
                                        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-l-4 border-green-500 bg-green-50">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">Question Approved</p>
                                                    <p class="text-sm text-gray-600">Your math question has been approved and published</p>
                                                    <p class="text-xs text-gray-500 mt-1">1 hour ago</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Notification Item -->
                                        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-l-4 border-orange-500 bg-orange-50">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">Low Credit Balance</p>
                                                    <p class="text-sm text-gray-600">You have only 5 credits remaining</p>
                                                    <p class="text-xs text-gray-500 mt-1">3 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-200 px-4 py-3">
                                        <div class="flex items-center justify-between">
                                            <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                Mark all as read
                                            </button>
                                            <a href="#" class="text-sm text-gray-500 hover:text-gray-700">
                                                View all notifications
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Profile Dropdown -->
                            <div class="relative" x-data="{ userMenuOpen: false }">
                                <button type="button"
                                        class="flex items-center space-x-3 p-2 text-sm font-medium text-purple-600 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-colors focus:outline-none"
                                        @click="userMenuOpen = !userMenuOpen">
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full flex items-center justify-center shadow-sm">
                                        <span class="text-sm font-semibold text-white">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-500 transform transition-transform duration-200 ml-1"
                                         :class="{ 'rotate-180': userMenuOpen }"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="userMenuOpen"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     @click.away="userMenuOpen = false"
                                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-1 border border-gray-200 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Your Profile
                                    </a>
                                    <a href="{{ route('profile.edit-info') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Profile
                                    </a>
                                    <a href="{{ route('profile.edit-email') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Edit Email
                                    </a>
                                    <a href="{{ route('profile.edit-password') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
                                        </svg>
                                        Change Password
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 overflow-y-auto">

                    <!-- Include Alert Component -->
                    <x-alert
                        :type="session('success') ? 'success' : (session('error') ? 'error' : '')"
                        :message="session('success') ?: session('error')"
                    />

                    <!-- Dashboard Content -->
                    @yield('content')

            </div>
        </div>
    </div>

    <!-- Additional scripts -->
    @stack('scripts')

</body>
</html>
