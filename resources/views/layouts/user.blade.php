<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - SuperMath</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans" x-data="{ mobileMenuOpen: false }">
    <div class="flex h-screen bg-gray-100">
        <!-- Mobile Menu Toggle Button -->
        <button
            class="fixed top-5 left-5 z-50 md:hidden w-12 h-12 bg-gradient-to-br from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 rounded-2xl shadow-xl transition-all duration-300 flex items-center justify-center group"
            @click="mobileMenuOpen = !mobileMenuOpen"
            aria-label="Toggle navigation menu">
            <div class="relative">
                <span class="block w-5 h-0.5 bg-white mb-1.5 transition-all duration-300 rounded-full transform group-hover:scale-110" :class="{'rotate-45 translate-y-2': mobileMenuOpen}"></span>
                <span class="block w-5 h-0.5 bg-white mb-1.5 transition-all duration-300 rounded-full transform group-hover:scale-110" :class="{'opacity-0': mobileMenuOpen}"></span>
                <span class="block w-5 h-0.5 bg-white transition-all duration-300 rounded-full transform group-hover:scale-110" :class="{'-rotate-45 -translate-y-2': mobileMenuOpen}"></span>
            </div>
        </button>

        <!-- Mobile Overlay -->
        <div
            class="fixed inset-0 bg-black bg-opacity-75 z-40 transition-opacity duration-300 md:hidden backdrop-blur-sm"
            :class="{'opacity-0 pointer-events-none': !mobileMenuOpen, 'opacity-100': mobileMenuOpen}"
            @click="mobileMenuOpen = false"></div>

        <!-- Enhanced Desktop Sidebar -->
        <div class="hidden md:flex md:w-80 md:flex-col md:fixed md:inset-y-0">
            <div class="flex flex-col flex-grow bg-white shadow-2xl border-r border-gray-200 overflow-y-auto">
                <!-- Logo & Header -->
                <div class="relative px-8 py-10 text-center border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col items-center space-y-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="relative px-6 py-8 flex flex-col h-full overflow-y-auto">
                    <div class="space-y-3 flex-1">
                        <!-- Dashboard -->
                        <a href="{{route('user.dashboard') }}"
                           class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-blue-50 hover:shadow-md {{ request()->routeIs('user.dashboard') ? 'bg-blue-100 text-blue-900 shadow-md border border-blue-200' : '' }}">
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

                        <!-- Question Management -->
                        <a href="#"
                           class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-amber-50 hover:shadow-md {{ request()->routeIs('questions.*') ? 'bg-amber-100 text-amber-900 shadow-md border border-amber-200' : '' }}">
                            <div class="flex items-center space-x-4 w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-base tracking-wide">Question Management</span>
                            </div>
                            <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Payment History -->
                        <a href="#"
                           class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-indigo-50 hover:shadow-md {{ request()->routeIs('payments.*') ? 'bg-indigo-100 text-indigo-900 shadow-md border border-indigo-200' : '' }}">
                            <div class="flex items-center space-x-4 w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-base tracking-wide">Payment History</span>
                            </div>
                            <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Downloads History -->
                        <a href="#"
                           class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-cyan-50 hover:shadow-sm {{ request()->routeIs('downloads.*') ? 'bg-cyan-100 text-cyan-900 shadow-md border border-cyan-200' : '' }}">
                            <div class="flex items-center space-x-4 w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-base tracking-wide">Downloads</span>
                            </div>
                            <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <!-- Settings -->
                        <a href="#"
                           class="group relative flex items-center px-4 py-4 text-gray-600 hover:text-gray-900 rounded-xl transition-all duration-300 hover:bg-gray-50 hover:shadow-md {{ request()->routeIs('settings.*') ? 'bg-gray-200 text-gray-900 shadow-md border border-gray-300' : '' }}">
                            <div class="flex items-center space-x-4 w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-slate-500 to-gray-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-base tracking-wide">Settings</span>
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
        </div>

        <!-- Main Content -->
        <div class="md:pl-80 flex flex-col flex-1">
            <!-- Header -->
            <div class="sticky top-0 z-10 bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <!-- Mobile menu button -->
                        <div class="md:hidden">
                            <button type="button"
                                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    @click="mobileMenuOpen = !mobileMenuOpen">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Mobile Logo and Credits (only visible on mobile) -->
                        <div class="md:hidden flex items-center space-x-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">SuperMath</h2>
                                    <div class="text-xs text-amber-600 font-medium">{{ auth()->user()->credits ?? 0 }} Credits</div>
                                </div>
                            </div>
                        </div>

                        <!-- Page Title (visible on desktop) -->
                        <div class="hidden md:block">
                            <h1 class="text-2xl font-semibold text-gray-900">
                                @if(request()->routeIs('user.dashboard'))
                                    Dashboard
                                @elseif(request()->routeIs('questions.*'))
                                    Question Management
                                @elseif(request()->routeIs('payments.*'))
                                    Payment History
                                @elseif(request()->routeIs('downloads.*'))
                                    Downloads History
                                @elseif(request()->routeIs('settings.*'))
                                    Settings
                                @else
                                    SuperMath
                                @endif
                            </h1>
                        </div>

                        <!-- Right side - User menu and notifications -->
                        <div class="flex items-center space-x-3">
                            <!-- Credits Display -->
                            <div class="hidden md:flex items-center space-x-3 bg-gradient-to-r from-blue-50 to-purple-50 px-4 py-2 rounded-lg border border-blue-100 hover:shadow-sm transition-shadow">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-800">{{ auth()->user()->credits ?? 0 }} Credits</div>
                                        <div class="text-xs text-gray-500">Available</div>
                                    </div>
                                </div>
                                <button class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm">
                                    Buy Credits
                                </button>
                            </div>

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
                                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1 border border-gray-200 z-50"
                                     style="display: none;">
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
                                        <div class="text-xs text-gray-500">User</div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-500 transform transition-transform duration-200"
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
                                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-1 border border-gray-200 z-50"
                                     style="display: none;">
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
                                    <a href="{{ route('profile.edit-password') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
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

            <!-- Mobile Sidebar with Alpine.js -->
            <div
                class="md:hidden fixed inset-0 flex z-40 transform transition-transform duration-300"
                :class="{'translate-x-0': mobileMenuOpen, '-translate-x-full': !mobileMenuOpen}">
                <!-- Mobile Menu Overlay -->
                <div
                    class="fixed inset-0 bg-gray-600 bg-opacity-75 backdrop-blur-sm transition-opacity duration-300"
                    :class="{'opacity-100': mobileMenuOpen, 'opacity-0': !mobileMenuOpen}"
                    @click="mobileMenuOpen = false">
                </div>

                <!-- Mobile Sidebar Content -->
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white shadow-xl transform transition-all duration-300">
                    <!-- Close button -->
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button
                            @click="mobileMenuOpen = false"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full bg-gradient-to-br from-red-500 to-pink-600 text-white focus:outline-none transition-transform duration-200 hover:scale-105 hover:rotate-90">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Sidebar Header -->
                    <div class="px-6 pt-8 pb-4 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">SuperMath</h2>
                                <p class="text-sm font-medium text-purple-600">User Portal</p>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Navigation -->
                    <div class="flex-1 pt-2 pb-4 overflow-y-auto">
                        <nav class="px-4 py-2 space-y-2">
                            <!-- Dashboard -->
                            <a href="{{ route('user.dashboard') }}"
                               class="group flex items-center px-4 py-3 text-base font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-blue-100 text-blue-800 shadow-sm' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                                <div class="flex items-center">
                                    <div class="mr-4 w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                    </div>
                                    Dashboard
                                </div>
                            </a>

                            <!-- Question Management -->
                            <a href="#"
                               class="group flex items-center px-4 py-3 text-base font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('questions.*') ? 'bg-amber-100 text-amber-800 shadow-sm' : 'text-gray-700 hover:bg-amber-50 hover:text-amber-700' }}">
                                <div class="flex items-center">
                                    <div class="mr-4 w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    Question Management
                                </div>
                            </a>

                            <!-- Payment History -->
                            <a href="#" class="group flex items-center px-4 py-3 text-base font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('payments.*') ? 'bg-indigo-100 text-indigo-800 shadow-sm' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                                <div class="flex items-center">
                                    <div class="mr-4 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    Payment History
                                </div>
                            </a>

                            <!-- Downloads -->
                            <a href="#" class="group flex items-center px-4 py-3 text-base font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('downloads.*') ? 'bg-cyan-100 text-cyan-800 shadow-sm' : 'text-gray-700 hover:bg-cyan-50 hover:text-cyan-700' }}">
                                <div class="flex items-center">
                                    <div class="mr-4 w-8 h-8 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    Downloads
                                </div>
                            </a>

                            <!-- Settings -->
                            <a href="#" class="group flex items-center px-4 py-3 text-base font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('settings.*') ? 'bg-gray-200 text-gray-800 shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-800' }}">
                                <div class="flex items-center">
                                    <div class="mr-4 w-8 h-8 bg-gradient-to-br from-gray-500 to-gray-700 rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    Settings
                                </div>
                            </a>
                        </nav>
                    </div>

                    <!-- Credits Card -->
                    <div class="px-4 pt-6 pb-2">
                        <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-2xl p-5 border border-blue-100 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full opacity-10 transform translate-x-8 -translate-y-8"></div>
                            <div class="absolute bottom-0 left-0 w-20 h-20 bg-gradient-to-br from-indigo-400 to-blue-400 rounded-full opacity-10 transform -translate-x-4 translate-y-4"></div>

                            <div class="flex items-center justify-between relative z-10">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-gray-800">{{ auth()->user()->credits ?? 0 }}</div>
                                        <div class="text-sm font-medium text-gray-500">Available Credits</div>
                                    </div>
                                </div>
                            </div>
                            <button class="w-full mt-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-5 py-3 rounded-xl text-sm font-medium transition-all duration-300 shadow-md hover:shadow-lg transform hover:translate-y-px">
                                Purchase More Credits
                            </button>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="flex-shrink-0 border-t border-gray-200 mt-4 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <span class="text-lg font-bold text-white">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-base font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                                    <div class="text-sm text-gray-500">User</div>
                                </div>
                            </div>
                            <!-- Mobile Profile Menu Button with Alpine.js -->
                            <div x-data="{ open: false }">
                                <button
                                    @click="open = !open"
                                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>

                                <!-- User Actions Dropdown with Alpine.js -->
                                <div
                                    x-show="open"
                                    @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="mt-3 space-y-1 bg-white rounded-xl border border-gray-100 shadow-lg overflow-hidden"
                                    style="display: none;">

                                    <!-- Profile Links -->
                                    <div class="p-2 space-y-1">
                                        <a href="{{ route('profile.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Your Profile
                                        </a>
                                        <a href="{{ route('profile.edit-info') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit Profile
                                        </a>
                                        <a href="{{ route('profile.edit-password') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                            </svg>
                                            Change Password
                                        </a>
                                    </div>

                                    <!-- Logout -->
                                    <div class="border-t border-gray-100">
                                        <form method="POST" action="{{ route('logout') }}" class="p-2">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-all duration-200">
                                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Sign Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <a href="#" class="bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 px-3 py-2 rounded-lg border border-blue-100 transition-all duration-300 flex flex-col items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">New Question</span>
                            </a>
                            <a href="#" class="bg-gradient-to-r from-purple-50 to-pink-50 hover:from-purple-100 hover:to-pink-100 px-3 py-2 rounded-lg border border-purple-100 transition-all duration-300 flex flex-col items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">History</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-6">
                    <!-- Success Message -->
                    @if (session('status'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    <!-- Dashboard Content -->
                    @yield('content')

                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js initialization script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('userData', () => ({
                init() {
                    const theme = localStorage.getItem('theme') || 'light';
                    this.setTheme(theme);
                },
                setTheme(theme) {
                    localStorage.setItem('theme', theme);

                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }));
        });
    </script>
</body>
</html>
