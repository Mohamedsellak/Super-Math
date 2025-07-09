<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MathQuest - Next-Generation Math Teaching Platform. Transform your classroom with 50,000+ curated math questions, LaTeX rendering, and curriculum mapping.">
    <meta name="keywords" content="math teaching platform, curated math questions, LaTeX rendering, math education tools, curriculum mapping, math teachers, professional math resources">
    <title>MathQuest - Next-Generation Math Teaching Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">    <script src="https://cdn.tailwindcss.com"></script>

  </head>
<body class="font-inter antialiased overflow-x-hidden bg-gradient-to-b from-indigo-50 to-white">    <!-- Enhanced animated background with gradient -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-100/40 via-white/20 to-blue-50/30"></div>
        <!-- Floating geometric shapes -->
        <div class="absolute top-20 left-20 w-32 h-32 bg-gradient-to-r from-indigo-200/30 to-blue-200/30 rounded-full blur-xl animate-float"></div>
        <div class="absolute bottom-32 right-20 w-24 h-24 bg-gradient-to-r from-blue-200/30 to-indigo-300/30 rounded-xl blur-lg animate-float-reverse"></div>
        <div class="absolute top-1/2 right-1/3 w-16 h-16 bg-gradient-to-r from-indigo-300/25 to-blue-200/25 rounded-full blur-lg animate-pulse-slow"></div>
        <!-- Additional subtle decorative elements -->
        <div class="absolute top-1/4 left-1/4 w-8 h-8 bg-indigo-200/20 rounded-full blur-sm animate-float"></div>
        <div class="absolute bottom-1/4 left-3/4 w-12 h-12 bg-blue-200/20 rounded-full blur-md animate-float-reverse"></div>
    </div>    <!-- Sticky Navigation Bar -->
    <nav class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-indigo-200/50 shadow-sm transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3 group">                    <div class="relative">
                        <img src="{{ asset('images/logo.png') }}" alt="MathQuest Logo" class="h-12 lg:h-16 w-auto transition-all duration-300 group-hover:scale-105 drop-shadow-sm">
                    </div>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold bg-gradient-to-r from-mathquest-primary to-mathquest-accent bg-clip-text text-transparent">
                            MathQuest
                        </h1>
                        <p class="text-xs text-mathquest-text/60 font-medium hidden lg:block">Math Teaching Platform</p>
                    </div>
                </div>
                  <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#features" class="relative text-mathquest-text hover:text-mathquest-primary px-4 py-2 text-sm font-medium transition-all duration-300 group">
                        Features
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-mathquest-primary to-mathquest-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#how-it-works" class="relative text-mathquest-text hover:text-mathquest-primary px-4 py-2 text-sm font-medium transition-all duration-300 group">
                        How It Works
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-mathquest-primary to-mathquest-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#pricing" class="relative text-mathquest-text hover:text-mathquest-primary px-4 py-2 text-sm font-medium transition-all duration-300 group">
                        Pricing
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-mathquest-primary to-mathquest-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('login') }}" class="relative text-mathquest-text hover:text-mathquest-primary px-4 py-2 text-sm font-medium transition-all duration-300 group">
                        Login
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-mathquest-primary to-mathquest-accent transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#" class="relative bg-gradient-to-r from-mathquest-primary to-mathquest-accent text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-mathquest-primary/25 transition-all duration-300 transform hover:scale-105 overflow-hidden group">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Start Free Trial
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-mathquest-accent to-mathquest-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button class="text-mathquest-text hover:text-mathquest-primary p-2 rounded-lg hover:bg-mathquest-secondary-bg transition-colors" id="mobile-menu-button">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
          <!-- Mobile menu -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="px-4 pt-2 pb-3 space-y-1 bg-white/98 backdrop-blur-xl border-t border-indigo-200/50">
                <a href="#features" class="block px-3 py-2 text-base font-medium text-mathquest-text hover:text-mathquest-primary hover:bg-mathquest-secondary-bg rounded-lg transition-colors">Features</a>
                <a href="#how-it-works" class="block px-3 py-2 text-base font-medium text-mathquest-text hover:text-mathquest-primary hover:bg-mathquest-secondary-bg rounded-lg transition-colors">How It Works</a>
                <a href="#pricing" class="block px-3 py-2 text-base font-medium text-mathquest-text hover:text-mathquest-primary hover:bg-mathquest-secondary-bg rounded-lg transition-colors">Pricing</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-mathquest-text hover:text-mathquest-primary hover:bg-mathquest-secondary-bg rounded-lg transition-colors">Login</a>
                <a href="#" class="block px-3 py-2 text-base font-semibold text-white bg-gradient-to-r from-mathquest-primary to-mathquest-accent rounded-lg mt-2">Start Free Trial</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-20 lg:pt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Content -->
                <div class="space-y-8 text-center lg:text-left">                    <!-- Badge -->
                    <div class="inline-flex items-center px-4 py-2 bg-mathquest-secondary-bg text-mathquest-primary rounded-full text-sm font-medium border border-mathquest-primary/30 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Next-Generation Math Teaching Platform
                    </div>

                    <!-- Main Headlines -->
                    <div class="space-y-4">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                            <span class="bg-gradient-to-r from-mathquest-text via-mathquest-primary to-mathquest-text bg-clip-text text-transparent">
                                Transform Your
                            </span>
                            <br>
                            <span class="bg-gradient-to-r from-mathquest-primary to-mathquest-accent bg-clip-text text-transparent">
                                Math Classroom
                            </span>
                        </h1>

                        <p class="text-xl lg:text-2xl text-mathquest-text/80 font-medium max-w-2xl">
                            Access 50,000+ expertly curated math questions, lightning-fast search tools, crystal-clear LaTeX rendering, and comprehensive analytics to support your curriculum.
                        </p>

                        <p class="text-lg text-mathquest-text/60 max-w-xl">
                            Built for educators who demand excellence.
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#" class="group relative bg-gradient-to-r from-mathquest-primary to-mathquest-accent text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-lg hover:shadow-xl hover:shadow-mathquest-primary/25 transition-all duration-300 transform hover:scale-105 overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Start Free Trial
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-mathquest-accent to-mathquest-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>

                        <a href="#" class="group flex items-center justify-center px-8 py-4 border-2 border-mathquest-text/30 text-mathquest-text rounded-xl text-lg font-semibold hover:border-mathquest-primary hover:text-mathquest-primary hover:bg-mathquest-secondary-bg transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Watch Demo
                        </a>
                    </div>

                    <!-- Social Proof -->
                    <div class="pt-8 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-4">Trusted by educators worldwide</p>
                        <div class="flex items-center justify-center lg:justify-start space-x-2 text-sm font-medium text-gray-700">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Trusted by 15,000+ educators across 50+ countries</span>
                        </div>
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="relative">
                    <div class="relative bg-white rounded-3xl shadow-2xl p-8 border border-gray-200">
                        <!-- Mock Dashboard Interface -->
                        <div class="space-y-6">
                            <!-- Header -->
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Question Browser</h3>
                                <div class="flex space-x-1">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Search Bar -->
                            <div class="relative">
                                <input type="text" placeholder="Search 50,000+ math questions..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <div class="absolute right-3 top-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Filters -->
                            <div class="grid grid-cols-2 gap-3">
                                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <option>Mathematics</option>
                                </select>
                                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <option>Medium</option>
                                </select>
                            </div>
                              <!-- Sample Question -->
                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 border border-blue-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Calculus</span>
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-medium">Medium</span>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        1,247 views
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">Find the derivative of f(x) = x² sin(3x)</p>
                                <div class="grid grid-cols-2 gap-2 text-sm mb-4">
                                    <div class="bg-white/70 rounded-lg p-2 border-l-2 border-green-400">A) 2x sin(3x) + 3x² cos(3x)</div>
                                    <div class="bg-white/70 rounded-lg p-2">B) x² cos(3x)</div>
                                    <div class="bg-white/70 rounded-lg p-2">C) 2x sin(3x)</div>
                                    <div class="bg-white/70 rounded-lg p-2">D) 3x² sin(3x)</div>
                                </div>
                                <!-- Mini Analytics -->
                                <div class="flex items-center justify-between text-xs text-gray-600 mb-3">
                                    <span class="flex items-center">
                                        <div class="w-2 h-2 bg-green-400 rounded-full mr-1"></div>
                                        78% success rate
                                    </span>
                                    <span class="flex items-center">
                                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-1"></div>
                                        2.3 min avg time
                                    </span>
                                </div>
                                <!-- Mini Progress Bar -->
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-3">
                                    <div class="bg-gradient-to-r from-green-400 to-blue-500 h-1.5 rounded-full" style="width: 78%"></div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                                Download Question
                            </button>
                        </div>
                    </div>
                      <!-- Floating Elements -->
                    <div class="absolute -top-6 -right-6 bg-white rounded-2xl shadow-lg p-4 animate-float border border-gray-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-gray-700">LaTeX Ready</span>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-lg p-4 animate-float-reverse border border-gray-200">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">50K+ Questions</span>
                        </div>
                    </div>

                    <!-- Analytics Floating Card -->
                    <div class="absolute top-1/2 -right-12 transform -translate-y-1/2 bg-white rounded-2xl shadow-xl p-4 animate-float border border-gray-200 hidden lg:block">
                        <div class="text-center">
                            <div class="text-xs text-gray-500 mb-1">Success Rate</div>
                            <div class="text-2xl font-bold text-green-600">92%</div>
                            <div class="w-12 h-1 bg-green-100 rounded-full mx-auto mt-2">
                                <div class="w-11 h-1 bg-green-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Chart Floating -->
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-lg p-3 animate-float-reverse border border-gray-200 hidden lg:block">
                        <div class="flex items-center space-x-2">
                            <div class="flex space-x-1">
                                <div class="w-1 h-6 bg-blue-400 rounded-full"></div>
                                <div class="w-1 h-8 bg-blue-500 rounded-full"></div>
                                <div class="w-1 h-4 bg-blue-300 rounded-full"></div>
                                <div class="w-1 h-7 bg-blue-600 rounded-full"></div>
                            </div>
                            <span class="text-xs font-medium text-gray-700">Analytics</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- Revolutionary Features Section -->
    <section id="features" class="py-24 bg-gradient-to-b from-white to-purple-50 relative overflow-hidden">
        <!-- Background decorations -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-gradient-to-r from-purple-200/30 to-blue-200/30 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-gradient-to-r from-blue-200/30 to-indigo-200/30 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-purple-100 to-blue-100 border border-purple-200/50 mb-6">
                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-purple-600">Revolutionary Features</span>
                </div>

                <h2 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 leading-tight">
                    Everything You Need for
                    <span class="block bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Teaching Excellence
                    </span>
                </h2>

                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Cutting-edge features designed with educators in mind, powered by AI and backed by pedagogical research.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- AI-Powered Search -->
                <div class="group relative">
                    <div class="glass bg-white/70 rounded-3xl p-8 border border-white/20 backdrop-blur-xl hover:bg-white/80 transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/10">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                            <div class="relative bg-gradient-to-r from-purple-600 to-blue-600 w-20 h-20 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-purple-600 transition-colors duration-300">
                            🔍 AI-Powered Search
                        </h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Advanced machine learning algorithms help you find the perfect questions instantly. Filter by topic, difficulty, and learning objectives with natural language queries.
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-600 to-blue-600 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000 ease-out"></div>
                        </div>
                    </div>
                </div>

                <!-- LaTeX Rendering -->
                <div class="group relative">
                    <div class="glass bg-white/70 rounded-3xl p-8 border border-white/20 backdrop-blur-xl hover:bg-white/80 transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/10">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                            <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 w-20 h-20 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">
                            📐 Perfect LaTeX Rendering
                        </h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Professional mathematical notation with MathJax and LaTeX. Complex equations and symbols rendered with pixel-perfect precision for both digital and print media.
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000 ease-out"></div>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Security -->
                <div class="group relative">
                    <div class="glass bg-white/70 rounded-3xl p-8 border border-white/20 backdrop-blur-xl hover:bg-white/80 transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 hover:shadow-2xl hover:shadow-green-500/10">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                            <div class="relative bg-gradient-to-r from-green-500 to-emerald-500 w-20 h-20 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-green-600 transition-colors duration-300">
                            🛡️ Enterprise Security
                        </h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Military-grade encryption and DRM protection. Watermarked previews, session-based access controls, and blockchain-verified content authenticity.
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000 ease-out"></div>
                        </div>
                    </div>
                </div>

                <!-- Flexible Credit System -->
                <div class="group relative">
                    <div class="glass bg-white/70 rounded-3xl p-8 border border-white/20 backdrop-blur-xl hover:bg-white/80 transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 hover:shadow-2xl hover:shadow-yellow-500/10">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                            <div class="relative bg-gradient-to-r from-yellow-500 to-orange-500 w-20 h-20 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">
                            💰 Flexible Credit System
                        </h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Pay-as-you-use model with bulk discounts and institutional packages. Smart analytics track usage patterns and suggest optimal credit packages.
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000 ease-out"></div>
                        </div>
                    </div>
                </div>

                <!-- Curriculum Intelligence -->
                <div class="group relative">
                    <div class="glass bg-white/70 rounded-3xl p-8 border border-white/20 backdrop-blur-xl hover:bg-white/80 transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 hover:shadow-2xl hover:shadow-indigo-500/10">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                            <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 w-20 h-20 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-indigo-600 transition-colors duration-300">
                            📚 Curriculum Intelligence
                        </h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            AI-powered curriculum mapping aligns questions with learning standards (Common Core, IB, Cambridge, etc.). Automatic difficulty calibration and outcome prediction.
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000 ease-out"></div>
                        </div>
                    </div>
                </div>

                <!-- Expert Curation -->
                <div class="group relative">
                    <div class="glass bg-white/70 rounded-3xl p-8 border border-white/20 backdrop-blur-xl hover:bg-white/80 transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 hover:shadow-2xl hover:shadow-pink-500/10">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 bg-gradient-to-r from-pink-500 to-rose-500 rounded-2xl blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                            <div class="relative bg-gradient-to-r from-pink-500 to-rose-500 w-20 h-20 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-pink-600 transition-colors duration-300">
                            ✨ Expert Curation
                        </h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Every question reviewed by PhD mathematicians and veteran educators. Multi-layer quality assurance with peer review, automated error detection, and continuous updates.
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-pink-500 to-rose-500 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000 ease-out"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    </section>

    <!-- Math Teaching Excellence - Dark Features Section -->
    <section class="relative py-20 lg:py-32 bg-gradient-to-br from-gray-900 via-gray-800 to-indigo-900 overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-radial from-indigo-500/30 via-purple-500/20 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-24">                <div class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500/20 to-blue-500/20 text-indigo-300 rounded-full text-sm font-semibold mb-8 animate-bounce border border-indigo-500/30 backdrop-blur-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Revolutionary Features
                </div><h2 class="text-5xl md:text-6xl font-black text-gray-100 mb-8 animate-pulse flex flex-col items-center">
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-16 h-16 text-indigo-400 mr-4 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span class="mr-4 text-gray-100">Everything You Need for</span>
                        <svg class="w-16 h-16 text-blue-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-14 h-14 text-indigo-400 mr-3 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="bg-gradient-to-r from-indigo-400 via-blue-400 to-indigo-400 bg-clip-text text-transparent">Math Teaching Excellence</span>
                        <svg class="w-14 h-14 text-blue-400 ml-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                </h2>                <div class="flex items-center justify-center mb-6">
                    <div class="flex items-center bg-gradient-to-r from-indigo-500/20 to-blue-500/20 backdrop-blur-sm rounded-full px-6 py-3 border border-indigo-500/30">
                        <svg class="w-6 h-6 text-indigo-400 mr-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="text-indigo-300 font-semibold">AI-Powered</span>
                        <svg class="w-6 h-6 text-blue-400 mx-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <span class="text-blue-300 font-semibold">Research-Backed</span>
                        <svg class="w-6 h-6 text-indigo-400 ml-3 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>                <p class="text-xl text-gray-300 max-w-4xl mx-auto animate-bounce flex items-center justify-center flex-wrap">
                    <svg class="w-8 h-8 text-indigo-400 mr-3 mb-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <span class="mr-3 mb-2">Cutting-edge features designed with educators in mind,</span>
                    <svg class="w-8 h-8 text-blue-400 mr-3 mb-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="mr-3 mb-2">powered by AI and backed by</span>
                    <svg class="w-8 h-8 text-indigo-400 mr-3 mb-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="mb-2">pedagogical research.</span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Smart Search & Filters -->
                <div class="group bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-8 hover:from-white/10 hover:to-white/20 transition-all duration-500 transform hover:-translate-y-4 hover:scale-105 border border-white/10 hover:border-purple-500/30 animate-pulse relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">                        <div class="bg-gradient-to-br from-mathquest-primary to-mathquest-accent w-20 h-20 rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>                        <h3 class="text-2xl font-bold text-gray-100 mb-6 group-hover:text-indigo-300 transition-colors duration-300 flex items-center">
                            <svg class="w-8 h-8 text-indigo-400 mr-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            AI-Powered Search
                            <svg class="w-6 h-6 text-blue-300 ml-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </h3>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Advanced machine learning algorithms help you find the perfect questions instantly. Filter by topic, difficulty, learning objectives, and cognitive complexity with natural language queries.
                        </p>
                        <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-mathquest-primary to-mathquest-accent h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000"></div>
                        </div>
                    </div>
                </div>                <!-- LaTeX-Rendered Equations -->
                <div class="group bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-8 hover:from-white/10 hover:to-white/20 transition-all duration-500 transform hover:-translate-y-4 hover:scale-105 border border-white/10 hover:border-cyan-500/30 animate-pulse relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-cyan-500 to-teal-500 w-20 h-20 rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-100 mb-6 group-hover:text-cyan-300 transition-colors duration-300 flex items-center">
                            <svg class="w-8 h-8 text-cyan-400 mr-3 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Perfect LaTeX Rendering
                            <svg class="w-6 h-6 text-teal-300 ml-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </h3>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Professional mathematical notation with MathJax and LaTeX. Complex equations, matrices, graphs, and symbols rendered with pixel-perfect precision for both digital and print media.
                        </p>
                        <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-cyan-500 to-teal-500 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000"></div>
                        </div>
                    </div>
                </div>

                <!-- Secure Preview System -->
                <div class="group bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-8 hover:from-white/10 hover:to-white/20 transition-all duration-500 transform hover:-translate-y-4 hover:scale-105 border border-white/10 hover:border-blue-500/30 animate-pulse relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-500 w-20 h-20 rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-100 mb-6 group-hover:text-blue-300 transition-colors duration-300 flex items-center">
                            <svg class="w-8 h-8 text-blue-400 mr-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Enterprise Security
                            <svg class="w-6 h-6 text-indigo-300 ml-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </h3>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Military-grade encryption and DRM protection. Watermarked previews, session-based access controls, and blockchain-verified content authenticity ensure complete intellectual property protection.
                        </p>
                        <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000"></div>
                        </div>
                    </div>
                </div>

                <!-- Smart Credit System -->
                <div class="group bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-8 hover:from-white/10 hover:to-white/20 transition-all duration-500 transform hover:-translate-y-4 hover:scale-105 border border-white/10 hover:border-purple-500/30 animate-pulse relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-purple-500 to-violet-500 w-20 h-20 rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-100 mb-6 group-hover:text-purple-300 transition-colors duration-300 flex items-center">
                            <svg class="w-8 h-8 text-purple-400 mr-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Flexible Credit System
                            <svg class="w-6 h-6 text-violet-300 ml-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </h3>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Pay-as-you-use model with bulk discounts and institutional packages. Smart analytics track usage patterns and suggest optimal credit packages for maximum value.
                        </p>
                        <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-violet-500 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000"></div>
                        </div>
                    </div>
                </div>

                <!-- Curriculum Alignment -->
                <div class="group bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-8 hover:from-white/10 hover:to-white/20 transition-all duration-500 transform hover:-translate-y-4 hover:scale-105 border border-white/10 hover:border-slate-500/30 animate-pulse relative overflow-hidden">                    <div class="absolute inset-0 bg-gradient-to-br from-slate-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-slate-500 to-gray-600 w-20 h-20 rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-100 mb-6 group-hover:text-slate-300 transition-colors duration-300 flex items-center">
                            <svg class="w-8 h-8 text-slate-400 mr-3 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Curriculum Intelligence
                            <svg class="w-6 h-6 text-gray-300 ml-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </h3>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            AI-powered curriculum mapping aligns questions with learning standards (Common Core, IB, Cambridge, etc.). Automatic difficulty calibration and learning outcome prediction.
                        </p>
                        <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-slate-500 to-gray-600 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000"></div>
                        </div>
                    </div>
                </div>

                <!-- Quality Assurance -->
                <div class="group bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-8 hover:from-white/10 hover:to-white/20 transition-all duration-500 transform hover:-translate-y-4 hover:scale-105 border border-white/10 hover:border-sky-500/30 animate-pulse relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-sky-500 to-blue-400 w-20 h-20 rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-100 mb-6 group-hover:text-sky-300 transition-colors duration-300 flex items-center">
                            <svg class="w-8 h-8 text-sky-400 mr-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            Expert Curation
                            <svg class="w-6 h-6 text-blue-300 ml-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </h3>
                        <p class="text-gray-300 leading-relaxed mb-6">
                            Every question reviewed by PhD mathematicians and veteran educators. Multi-layer quality assurance with peer review, automated error detection, and continuous content updates.
                        </p>
                        <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-sky-500 to-blue-400 h-2 rounded-full w-0 group-hover:w-full transition-all duration-1000"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section with Analytics Insights -->
    <section id="pricing" class="relative py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16 lg:mb-20">
                <div class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full text-sm font-medium border border-emerald-200 shadow-sm mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    Smart Pricing Plans
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Choose Your Teaching <span class="bg-gradient-to-r from-emerald-600 to-blue-600 bg-clip-text text-transparent">Analytics</span> Plan
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Flexible pricing with detailed analytics to track your ROI and teaching effectiveness
                </p>
            </div>

            <!-- Pricing Cards -->
            <div class="grid lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Starter Plan -->
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 relative">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                        <p class="text-gray-600 mb-6">Perfect for individual educators</p>
                        <div class="text-4xl font-bold text-gray-900 mb-2">$29<span class="text-lg text-gray-600">/month</span></div>
                        <p class="text-sm text-gray-500">100 credits included</p>
                    </div>

                    <!-- Analytics Preview -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <div class="text-sm font-medium text-gray-700 mb-2">Usage Analytics</div>
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span>Questions Used</span>
                            <span>67/100</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 67%"></div>
                        </div>
                    </div>

                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            100 question downloads/month
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Basic analytics dashboard
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            LaTeX rendering
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Email support
                        </li>
                    </ul>

                    <button class="w-full bg-gray-900 text-white py-3 rounded-xl font-semibold hover:bg-gray-800 transition-colors">
                        Start Free Trial
                    </button>
                </div>

                <!-- Professional Plan (Popular) -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 border-2 border-blue-200 shadow-lg hover:shadow-xl transition-all duration-300 relative scale-105">
                    <!-- Popular Badge -->
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-semibold">
                            Most Popular
                        </div>
                    </div>

                    <div class="text-center mb-8 mt-4">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional</h3>
                        <p class="text-gray-600 mb-6">For dedicated math teachers</p>
                        <div class="text-4xl font-bold text-gray-900 mb-2">$79<span class="text-lg text-gray-600">/month</span></div>
                        <p class="text-sm text-gray-500">300 credits + advanced analytics</p>
                    </div>

                    <!-- Enhanced Analytics Preview -->
                    <div class="bg-white rounded-xl p-4 mb-6 border border-blue-200">
                        <div class="text-sm font-medium text-gray-700 mb-3">Advanced Analytics</div>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="text-center">
                                <div class="text-lg font-bold text-blue-600">94%</div>
                                <div class="text-gray-600">Success Rate</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-green-600">2.1m</div>
                                <div class="text-gray-600">Avg Time</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span>Performance Trend</span>
                                <span class="text-green-600">↗ +12%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-400 to-blue-500 h-2 rounded-full" style="width: 94%"></div>
                            </div>
                        </div>
                    </div>

                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            300 question downloads/month
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Advanced analytics & insights
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Performance tracking
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Curriculum coverage reports
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Priority support
                        </li>
                    </ul>

                    <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        Start Free Trial
                    </button>
                </div>

                <!-- Institution Plan -->
                <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 relative">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Institution</h3>
                        <p class="text-gray-600 mb-6">For schools and departments</p>
                        <div class="text-4xl font-bold text-gray-900 mb-2">$199<span class="text-lg text-gray-600">/month</span></div>
                        <p class="text-sm text-gray-500">Unlimited + team analytics</p>
                    </div>

                    <!-- Team Analytics Preview -->
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4 mb-6 border border-purple-200">
                        <div class="text-sm font-medium text-gray-700 mb-3">Team Analytics</div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs">
                                <span>Math Dept.</span>
                                <span class="font-medium">89% avg</span>
                            </div>
                            <div class="w-full bg-purple-200 rounded-full h-1.5">
                                <div class="bg-purple-500 h-1.5 rounded-full" style="width: 89%"></div>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span>Science Dept.</span>
                                <span class="font-medium">76% avg</span>
                            </div>
                            <div class="w-full bg-blue-200 rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 76%"></div>
                            </div>
                        </div>
                    </div>

                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Unlimited downloads
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Institution-wide analytics
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Team collaboration tools
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Custom reporting
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Dedicated support
                        </li>
                    </ul>

                    <button class="w-full bg-gray-900 text-white py-3 rounded-xl font-semibold hover:bg-gray-800 transition-colors">
                        Contact Sales
                    </button>
                </div>
            </div>

            <!-- ROI Calculator -->
            <div class="mt-16 lg:mt-20 bg-gradient-to-r from-gray-50 to-blue-50 rounded-3xl p-8 lg:p-12 border border-gray-200">
                <div class="text-center mb-8">
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">Calculate Your Teaching ROI</h3>
                    <p class="text-gray-600 max-w-2xl mx-auto">See how MathQuest analytics can improve your teaching efficiency and student outcomes</p>
                </div>

                <div class="grid lg:grid-cols-3 gap-8 text-center">
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <div class="text-3xl font-bold text-blue-600 mb-2">65%</div>
                        <div class="text-sm text-gray-600">Time Saved on Lesson Planning</div>
                        <div class="text-xs text-gray-500 mt-2">Based on user analytics</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <div class="text-3xl font-bold text-green-600 mb-2">23%</div>
                        <div class="text-sm text-gray-600">Improvement in Student Scores</div>
                        <div class="text-xs text-gray-500 mt-2">Measured over 6 months</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <div class="text-3xl font-bold text-purple-600 mb-2">$3,200</div>
                        <div class="text-sm text-gray-600">Annual Value per Teacher</div>
                        <div class="text-xs text-gray-500 mt-2">Time & resource savings</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                <!-- Brand Column -->
                <div class="md:col-span-2 lg:col-span-1">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl p-2.5 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                            MathQuest
                        </h3>
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6">
                        Enabling educators to deliver powerful, effective math instruction with beautifully crafted, standards-aligned resources.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.02 12.1c1.28-4.29 7.52-5 12-5s10.72.71 12 5c-1.28 4.29-7.52 5-12 5s-10.72-.71-12-5z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                <circle cx="12" cy="12" r="3" fill="currentColor"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Product Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Product</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-300 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#pricing" class="text-gray-300 hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Start Free Trial</a></li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Status</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © 2025 MathQuest. All rights reserved.
                </p>
                <div class="flex items-center space-x-6 mt-4 md:mt-0">
                    <span class="text-gray-400 text-sm">Made with ❤️ for educators</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
