<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MathQuest - Revolutionary Math Teaching Platform. Transform your classroom with 50,000+ AI-curated math questions, perfect LaTeX rendering, and intelligent curriculum mapping.">
    <meta name="keywords" content="math teaching platform, AI math questions, LaTeX rendering, math education tools, curriculum mapping, math teachers, professional math resources">
    <meta name="author" content="MathQuest">
    <meta property="og:title" content="MathQuest - Revolutionary Math Teaching Platform">
    <meta property="og:description" content="Transform your classroom with 50,000+ AI-curated math questions and intelligent teaching tools.">
    <meta property="og:type" content="website">
    <title>Edufacilita - Revolutionary Math Teaching Platform</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Enhanced Font Loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">


</head>
<body class="font-inter antialiased overflow-x-hidden bg-gray-50">    <!-- Modern Navigation Bar -->
    <nav class="fixed w-full top-0 z-50 bg-white shadow-sm border-b border-gray-200" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Edufacilita</h1>
                        <p class="text-xs text-gray-500">Math Teaching Platform</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Features</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">How It Works</a>
                    <a href="#pricing" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Pricing</a>
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Start Free Trial</a>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button class="text-gray-700 hover:text-blue-600 p-2" id="mobile-menu-button">
                        <!-- Hamburger icon -->
                        <svg class="w-6 h-6 block" id="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <!-- Close icon -->
                        <svg class="w-6 h-6 hidden" id="close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="lg:hidden hidden bg-white border-t border-gray-200" id="mobile-menu">
            <div class="px-4 py-4 space-y-2">
                <a href="#features" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-lg">Features</a>
                <a href="#how-it-works" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-lg">How It Works</a>
                <a href="#pricing" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-lg">Pricing</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-lg">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-center">Start Free Trial</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-20 pb-16 bg-gradient-to-br from-slate-50 via-white to-blue-50 overflow-hidden min-h-screen flex items-center">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-32 h-32 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute top-40 right-20 w-32 h-32 bg-purple-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse delay-200"></div>
            <div class="absolute -bottom-8 left-20 w-32 h-32 bg-pink-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse delay-400"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div class="space-y-10 text-center lg:text-left">
                    <!-- Premium Badge -->
                    <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full text-sm font-semibold shadow-lg transform hover:scale-105 transition-transform duration-200">
                        <div class="w-2 h-2 bg-white rounded-full mr-3 animate-pulse"></div>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Revolutionary AI-Powered Math Platform
                    </div>

                    <!-- Main Headlines -->
                    <div class="space-y-4">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight">
                            <span class="text-gray-900">Transform</span>
                            <br>
                            <span class="text-gray-900">Your</span>
                            <br>
                            <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent">Math Classroom</span>
                        </h1>

                        <p class="text-lg lg:text-xl text-gray-600 max-w-2xl leading-relaxed font-medium">
                            Unlock the power of <span class="font-bold text-blue-600">50,000+ AI-curated</span> math questions with lightning-fast search, crystal-clear LaTeX rendering, and intelligent analytics.
                        </p>

                        <p class="text-base text-gray-500 max-w-xl font-normal">
                            Designed by educators, for educators who refuse to settle for ordinary.
                        </p>
                    </div>

                    <!-- Enhanced CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                        <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-2xl text-base font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-400 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                            <svg class="w-5 h-5 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="relative z-10">Start Free Trial</span>
                            <div class="ml-2 w-2 h-2 bg-white rounded-full animate-pulse relative z-10"></div>
                        </a>

                        <a href="#" class="group inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-gray-700 rounded-2xl text-base font-bold hover:border-blue-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-3 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Watch Demo
                        </a>
                    </div>

                    <!-- Enhanced Social Proof -->
                    <div class="pt-10">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                            <p class="text-sm text-gray-500 mb-4 font-medium">Trusted by educators worldwide</p>

                            <!-- Stats Grid -->
                            <div class="grid grid-cols-3 gap-6 mb-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">15,000+</div>
                                    <div class="text-xs text-gray-500 font-medium">Educators</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600">50+</div>
                                    <div class="text-xs text-gray-500 font-medium">Countries</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">98%</div>
                                    <div class="text-xs text-gray-500 font-medium">Satisfaction</div>
                                </div>
                            </div>

                            <!-- Testimonial Preview -->
                            <div class="flex items-center space-x-3 text-sm">
                                <div class="flex -space-x-2">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full border-2 border-white"></div>
                                    <div class="w-8 h-8 bg-gradient-to-r from-green-400 to-blue-400 rounded-full border-2 border-white"></div>
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full border-2 border-white"></div>
                                    <div class="w-8 h-8 bg-gray-300 rounded-full border-2 border-white flex items-center justify-center">
                                        <span class="text-xs font-bold text-gray-600">+12K</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <div class="flex space-x-1">
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </div>
                                    <span class="text-gray-600 font-medium">4.9/5 rating</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Right Visual -->
                <div class="relative animate-fade-in-up duration-700">
                    <!-- Main Dashboard Card -->
                    <div class="bg-white rounded-3xl shadow-2xl p-6 border border-gray-100 backdrop-blur-sm bg-opacity-95 animate-fade-in-up duration-700 delay-200">
                        <!-- Mock Dashboard Interface -->
                        <div class="space-y-4">
                            <!-- Enhanced Header -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Question Browser</h3>
                                        <p class="text-xs text-gray-500">AI-Powered Platform</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full animate-pulse"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse delay-200"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse delay-400"></div>
                                </div>
                            </div>

                            <!-- Enhanced Search Bar -->
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                                <input type="text"
                                       placeholder="Search 50,000+ math questions..."
                                       class="relative w-full px-4 py-3 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white shadow-lg text-gray-700 font-medium transition-all duration-300 text-sm"
                                       value="Find derivatives of trigonometric">
                                <div class="absolute right-3 top-3">
                                    <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Filters -->
                            <div class="grid grid-cols-2 gap-3">
                                <select class="px-3 py-2 border-2 border-gray-200 rounded-xl text-xs font-medium bg-white shadow-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option>📐 Calculus</option>
                                </select>
                                <select class="px-3 py-2 border-2 border-gray-200 rounded-xl text-xs font-medium bg-white shadow-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option>⚡ Medium</option>
                                </select>
                            </div>

                            <!-- Enhanced Sample Question -->
                            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-4 border-2 border-blue-100 relative overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-200 to-purple-200 rounded-full transform translate-x-12 -translate-y-12 opacity-20"></div>

                                <div class="relative">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-2">
                                            <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-2 py-1 rounded-full text-xs font-bold shadow-md">Calculus</span>
                                            <span class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-2 py-1 rounded-full text-xs font-bold shadow-md">Medium</span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-600 bg-white rounded-full px-2 py-1 shadow-md">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            1,247 views
                                        </div>
                                    </div>

                                    <p class="text-gray-800 mb-4 font-semibold text-sm">Find the derivative of f(x) = x² sin(3x)</p>

                                    <div class="grid grid-cols-1 gap-2 text-xs mb-3">
                                        <div class="bg-white rounded-xl p-3 border-2 border-green-300 shadow-lg transition-transform cursor-pointer relative">
                                            <div class="absolute top-2 right-2 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center">
                                                <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            <strong class="text-green-700">A)</strong> 2x sin(3x) + 3x² cos(3x)
                                        </div>
                                        <div class="bg-white rounded-xl p-3 border border-gray-200 shadow-md transition-shadow cursor-pointer">
                                            <strong class="text-gray-600">B)</strong> x² cos(3x)
                                        </div>
                                    </div>

                                    <!-- Enhanced Analytics -->
                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                        <div class="bg-white rounded-xl p-2 shadow-md">
                                            <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                                                <span class="flex items-center font-medium">
                                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-1"></div>
                                                    Success
                                                </span>
                                                <span class="font-bold text-green-600">78%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                <div class="bg-gradient-to-r from-green-400 to-green-500 h-1.5 rounded-full shadow-sm w-4/5"></div>
                                            </div>
                                        </div>
                                        <div class="bg-white rounded-xl p-2 shadow-md">
                                            <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                                                <span class="flex items-center font-medium">
                                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-1"></div>
                                                    Time
                                                </span>
                                                <span class="font-bold text-blue-600">2.3m</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                <div class="bg-gradient-to-r from-blue-400 to-blue-500 h-1.5 rounded-full shadow-sm w-3/5"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Action Button -->
                            <button class="group w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-3 rounded-2xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-400 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download Question
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Enhanced Floating Elements -->
                    <div class="absolute -top-3 -right-3 bg-white rounded-2xl shadow-xl p-3 border border-gray-100 transition-transform animate-bounce">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-gradient-to-r from-green-400 to-green-500 rounded-full animate-pulse"></div>
                            <span class="text-xs font-bold text-gray-700">LaTeX Ready</span>
                        </div>
                    </div>

                    <div class="absolute -bottom-3 -left-3 bg-white rounded-2xl shadow-xl p-3 border border-gray-100 transition-transform duration-300 animate-pulse">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-gray-700">50K+ Questions</div>
                                <div class="text-xs text-gray-500">AI-Curated</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Features Section -->
    <section id="features" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-40 left-1/4 w-64 h-64 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute bottom-20 right-1/4 w-64 h-64 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Enhanced Section Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full text-sm font-bold mb-8 shadow-lg">
                    <div class="w-2 h-2 bg-white rounded-full mr-3 animate-pulse"></div>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Powerful Features
                </div>

                <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-6 leading-tight">
                    Everything You Need for
                    <br>
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Teaching Excellence</span>
                </h2>

                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Cutting-edge features designed with educators in mind, powered by AI and backed by pedagogical research.
                </p>
            </div>

            <!-- Enhanced Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <!-- AI-Powered Search -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>
                    <div class="relative">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">AI-Powered Search</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Advanced algorithms help you find the perfect questions instantly. Filter by topic, difficulty, and learning objectives with natural language queries.
                        </p>
                        <div class="flex items-center text-blue-600 font-semibold">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- LaTeX Rendering -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100 to-green-200 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>
                    <div class="relative">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Perfect LaTeX Rendering</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Professional mathematical notation with MathJax and LaTeX. Complex equations rendered with pixel-perfect precision for digital and print media.
                        </p>
                        <div class="flex items-center text-green-600 font-semibold">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Security -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>
                    <div class="relative">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Enterprise Security</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Military-grade encryption and DRM protection. Watermarked previews, session-based access controls, and verified content authenticity.
                        </p>
                        <div class="flex items-center text-purple-600 font-semibold">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Flexible Credit System -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>
                    <div class="relative">
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Flexible Credit System</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Pay-as-you-use model with bulk discounts and institutional packages. Smart analytics track usage patterns and suggest optimal credit packages.
                        </p>
                        <div class="flex items-center text-orange-600 font-semibold">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Curriculum Intelligence -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>
                    <div class="relative">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Curriculum Intelligence</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            AI-powered curriculum mapping aligns questions with learning standards (Common Core, IB, Cambridge, etc.). Automatic difficulty calibration and outcome prediction.
                        </p>
                        <div class="flex items-center text-indigo-600 font-semibold">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Expert Curation -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>
                    <div class="relative">
                        <div class="bg-gradient-to-r from-pink-500 to-pink-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Expert Curation</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Every question reviewed by PhD mathematicians and veteran educators. Multi-layer quality assurance with peer review, automated error detection, and continuous updates.
                        </p>
                        <div class="flex items-center text-pink-600 font-semibold">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features CTA -->
            <div class="text-center">
                <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100 inline-block">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Ready to transform your teaching?</h3>
                    <p class="text-gray-600 mb-6">Join thousands of educators worldwide who trust Edufacilita</p>
                    <a href="{{ route('register') }}" class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-2xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Start Your Free Trial
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Enhanced How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 right-1/4 w-48 h-48 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
            <div class="absolute bottom-40 left-1/4 w-48 h-48 bg-gradient-to-br from-green-100 to-blue-100 rounded-full mix-blend-multiply filter blur-2xl opacity-40"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Enhanced Section Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-full text-sm font-bold mb-8 shadow-lg">
                    <div class="w-2 h-2 bg-white rounded-full mr-3 animate-pulse"></div>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    How It Works
                </div>

                <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-6 leading-tight">
                    Get Started in
                    <br>
                    <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Three Simple Steps</span>
                </h2>

                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Start using Edufacilita in minutes with our streamlined onboarding process
                </p>
            </div>

            <!-- Enhanced Steps with Connection Lines -->
            <div class="relative">
                <!-- Connection Lines (Hidden on mobile) -->
                <div class="hidden md:block absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-blue-200 via-green-200 to-purple-200 transform -translate-y-1/2 z-0"></div>

                <!-- Steps Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                    <!-- Step 1 -->
                    <div class="text-center group">
                        <div class="relative mb-8">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:shadow-3xl transition-all duration-300">
                                <span class="text-3xl font-black text-white">1</span>
                            </div>
                            <!-- Floating Icon -->
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 group-hover:shadow-xl transition-all duration-300">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Sign Up & Choose Plan</h3>
                            <p class="text-gray-600 leading-relaxed">Create your account and select the plan that fits your teaching needs. Start with our free trial and explore all features.</p>

                            <!-- Mini Features List -->
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                    <span>30-day free trial</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                    <span>No credit card required</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center group">
                        <div class="relative mb-8">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:shadow-3xl transition-all duration-300">
                                <span class="text-3xl font-black text-white">2</span>
                            </div>
                            <!-- Floating Icon -->
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 group-hover:shadow-xl transition-all duration-300">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Search & Select Questions</h3>
                            <p class="text-gray-600 leading-relaxed">Use our AI-powered search to find the perfect questions for your curriculum and learning objectives with instant results.</p>

                            <!-- Mini Features List -->
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    <span>50,000+ questions</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    <span>AI-powered filters</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center group">
                        <div class="relative mb-8">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 w-20 h-20 rounded-3xl flex items-center justify-center mx-auto shadow-2xl group-hover:shadow-3xl transition-all duration-300">
                                <span class="text-3xl font-black text-white">3</span>
                            </div>
                            <!-- Floating Icon -->
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 group-hover:shadow-xl transition-all duration-300">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Download & Teach</h3>
                            <p class="text-gray-600 leading-relaxed">Download your selected questions in multiple formats and start teaching with confidence using professional materials.</p>

                            <!-- Mini Features List -->
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                                    <span>Multiple formats</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                                    <span>Print-ready quality</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced CTA Section -->
            <div class="text-center mt-16">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-3xl p-8 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Ready to get started?</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Join thousands of educators who are already transforming their teaching with Edufacilita</p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-2xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Start Your Free Trial Today
                        </a>

                        <a href="#" class="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-gray-700 rounded-2xl font-bold hover:border-blue-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Watch Demo
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="flex items-center justify-center space-x-6 mt-6 text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Free Trial</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>No Credit Card</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Cancel Anytime</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Pricing Section -->
    <section id="pricing" class="py-20 bg-gradient-to-br from-blue-50 to-purple-50 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-1/3 w-64 h-64 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute bottom-40 right-1/3 w-64 h-64 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Enhanced Section Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-full text-sm font-bold mb-8 shadow-lg">
                    <div class="w-2 h-2 bg-white rounded-full mr-3 animate-pulse"></div>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    Simple & Transparent Pricing
                </div>

                <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-6 leading-tight">
                    Choose Your
                    <br>
                    <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Perfect Plan</span>
                </h2>

                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Flexible pricing designed for educators and institutions. Start free, upgrade anytime.
                </p>
            </div>

            <!-- Enhanced Pricing Cards -->
            <div class="grid lg:grid-cols-3 gap-8 mb-16">
                <!-- Starter Plan -->
                <div class="group bg-white rounded-3xl p-8 border-2 border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>

                    <div class="relative">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                            <p class="text-gray-600 mb-6">Perfect for individual educators</p>
                            <div class="text-4xl font-black text-gray-900 mb-2">$29<span class="text-xl text-gray-600 font-medium">/month</span></div>
                            <p class="text-sm text-blue-600 font-semibold bg-blue-50 rounded-full px-3 py-1 inline-block">100 credits included</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">100 question downloads/month</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Basic search and filters</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">LaTeX rendering</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Email support</span>
                            </li>
                        </ul>

                        <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 text-white py-4 rounded-2xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl block text-center">
                            Start Free Trial
                        </a>
                    </div>
                </div>

                <!-- Professional Plan (Popular) -->
                <div class="group bg-white rounded-3xl p-8 border-2 border-blue-300 shadow-2xl hover:shadow-3xl transition-all duration-300 relative overflow-hidden transform scale-105">
                    <!-- Popular Badge -->


                    <!-- Background Pattern -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>

                    <div class="relative pt-4">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional</h3>
                            <p class="text-gray-600 mb-6">For dedicated math teachers</p>
                            <div class="text-4xl font-black text-gray-900 mb-2">$79<span class="text-xl text-gray-600 font-medium">/month</span></div>
                            <p class="text-sm text-blue-600 font-semibold bg-blue-50 rounded-full px-3 py-1 inline-block">300 credits + advanced features</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">300 question downloads/month</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">AI-powered search</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Advanced analytics</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Priority support</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Custom question collections</span>
                            </li>
                        </ul>

                        <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-4 rounded-2xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl relative overflow-hidden block text-center">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-400 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                            <span class="relative">Start Free Trial</span>
                        </a>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="group bg-white rounded-3xl p-8 border-2 border-gray-200 shadow-lg hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full transform translate-x-16 -translate-y-16 opacity-50 group-hover:opacity-70 transition-opacity"></div>

                    <div class="relative">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                            <p class="text-gray-600 mb-6">For large organizations</p>
                            <div class="text-4xl font-black text-gray-900 mb-2">Contact Us<span class="text-xl text-gray-600 font-medium"></span></div>
                            <p class="text-sm text-purple-600 font-semibold bg-purple-50 rounded-full px-3 py-1 inline-block">Custom pricing and solutions</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Unlimited downloads</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Multi-user accounts</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">White-label solutions</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Dedicated support</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium">API access</span>
                            </li>
                        </ul>

                        <button class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white py-4 rounded-2xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                            Contact Sales
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pricing Footer -->
            <div class="text-center">
                <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100 max-w-4xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">All plans include a 30-day free trial</h3>
                    <p class="text-gray-600 mb-6">No credit card required. Cancel anytime. Upgrade or downgrade as needed.</p>

                    <!-- FAQ Quick Links -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Questions?</h4>
                            <p class="text-sm text-gray-600">Check our FAQ or contact support</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Risk-Free</h4>
                            <p class="text-sm text-gray-600">30-day money-back guarantee</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Flexible</h4>
                            <p class="text-sm text-gray-600">Change plans anytime</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand Column -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-blue-600 text-white rounded-lg p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold">Edufacilita</h3>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed mb-4">
                        Enabling educators to deliver powerful, effective math instruction with beautifully crafted resources.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Product Links -->
                <div>
                    <h4 class="text-sm font-semibold mb-4">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-300 hover:text-white transition-colors text-sm">Features</a></li>
                        <li><a href="#pricing" class="text-gray-300 hover:text-white transition-colors text-sm">Pricing</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">API</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Free Trial</a></li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div>
                    <h4 class="text-sm font-semibold mb-4">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">About</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Blog</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Careers</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Contact</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div>
                    <h4 class="text-sm font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Status</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © 2025 Edufacilita. All rights reserved.
                </p>
                <div class="flex items-center space-x-4 mt-2 md:mt-0">
                    <span class="text-gray-400 text-sm">Made with ❤️ for educators</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Include Alert Component -->
    <x-alert
        :type="session('success') ? 'success' : (session('error') ? 'error' : '')"
        :message="session('success') ?: session('error')"
    />

    <!-- Mobile Menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            if (mobileMenuButton && mobileMenu && menuIcon && closeIcon) {
                mobileMenuButton.addEventListener('click', function() {
                    const isMenuHidden = mobileMenu.classList.contains('hidden');
                    
                    // Toggle menu visibility
                    mobileMenu.classList.toggle('hidden');
                    
                    // Toggle icons
                    if (isMenuHidden) {
                        menuIcon.classList.add('hidden');
                        menuIcon.classList.remove('block');
                        closeIcon.classList.remove('hidden');
                        closeIcon.classList.add('block');
                    } else {
                        menuIcon.classList.remove('hidden');
                        menuIcon.classList.add('block');
                        closeIcon.classList.add('hidden');
                        closeIcon.classList.remove('block');
                    }
                });

                // Close mobile menu when clicking on a link
                const mobileMenuLinks = mobileMenu.querySelectorAll('a');
                mobileMenuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                        // Reset icons
                        menuIcon.classList.remove('hidden');
                        menuIcon.classList.add('block');
                        closeIcon.classList.add('hidden');
                        closeIcon.classList.remove('block');
                    });
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                        // Reset icons
                        menuIcon.classList.remove('hidden');
                        menuIcon.classList.add('block');
                        closeIcon.classList.add('hidden');
                        closeIcon.classList.remove('block');
                    }
                });
            }
        });
    </script>

</body>
</html>
