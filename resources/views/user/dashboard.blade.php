@extends('layouts.user')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <div class="p-6">
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full opacity-80"></div>
        </div>

        <!-- Welcome Header -->
        <div class="mb-8 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/30 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-3">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 bg-clip-text text-transparent">
                                Welcome back, {{ auth()->user()->first_name }}!
                            </h1>
                            <p class="text-gray-600 text-lg font-medium mt-1">Ready to challenge your mathematical skills today?</p>
                        </div>
                    </div>
                    <p class="text-gray-600 ml-16 text-base">Continue your learning journey and track your progress</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden lg:flex items-center space-x-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-600">Active Session</span>
                    </div>
                    <a href="{{ route('user.credits.index') }}" class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 rounded-full shadow-sm text-white transition-all duration-300">
                        <i class="fas fa-coins text-sm"></i>
                        <span class="text-sm font-medium">{{ number_format(auth()->user()->credit ?? 0) }} Credits</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
            <!-- Available Credits -->
            <div class="group bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <i class="fas fa-coins text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Available Credits</p>
                            <p class="text-2xl font-black text-gray-900">${{ number_format(auth()->user()->credit ?? 0, 2) }}</p>
                            <div class="flex items-center space-x-1 mt-1">
                                <i class="fas fa-info-circle text-blue-500 text-xs"></i>
                                <span class="text-xs text-gray-500">Ready to use</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Solved -->
            <div class="group bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <i class="fas fa-check-circle text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Questions Solved</p>
                            <p class="text-2xl font-black text-gray-900">0</p>
                            <div class="flex items-center space-x-1 mt-1">
                                <i class="fas fa-arrow-up text-green-500 text-xs"></i>
                                <span class="text-xs text-gray-500">Start solving!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Rate -->
            <div class="group bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <i class="fas fa-percentage text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Success Rate</p>
                            <p class="text-2xl font-black text-gray-900">--%</p>
                            <div class="flex items-center space-x-1 mt-1">
                                <i class="fas fa-target text-purple-500 text-xs"></i>
                                <span class="text-xs text-gray-500">Aim for 100%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Study Streak -->
            <div class="group bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <i class="fas fa-fire text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Study Streak</p>
                            <p class="text-2xl font-black text-gray-900">0 Days</p>
                            <div class="flex items-center space-x-1 mt-1">
                                <i class="fas fa-calendar text-orange-500 text-xs"></i>
                                <span class="text-xs text-gray-500">Keep it going!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
            <!-- Profile Overview -->
            <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-blue-50/50 to-indigo-50/50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Profile Overview</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="mx-auto h-20 w-20 rounded-full bg-gradient-to-br from-blue-400 via-purple-500 to-indigo-600 flex items-center justify-center mb-4 shadow-xl">
                            <span class="text-2xl font-bold text-white">
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h4>
                        <p class="text-gray-600 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-600">Institution</span>
                            <span class="text-sm font-semibold text-gray-900">{{ auth()->user()->institution ?? 'Not specified' }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-600">Member Since</span>
                            <span class="text-sm font-semibold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-600">Status</span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Active</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('profile.index') }}" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-3 rounded-xl font-semibold shadow-lg transition-all duration-300 flex items-center justify-center space-x-2">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Progress Chart & Quick Actions -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Progress Chart -->
                <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-purple-50/50 to-purple-100/50">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Learning Progress</h3>
                                <p class="text-gray-600 text-sm">Track your daily performance</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="h-64">
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-emerald-50/50 to-emerald-100/50">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg">
                                <i class="fas fa-rocket text-white text-lg"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Quick Actions</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <button class="group flex items-center justify-center px-4 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-calculator mr-3 group-hover:rotate-12 transition-transform duration-300"></i>
                                <span class="font-semibold">Practice Questions</span>
                            </button>
                            <button class="group flex items-center justify-center px-4 py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-clock mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="font-semibold">Timed Test</span>
                            </button>
                            <a href="{{ route('user.credits.index') }}" class="group flex items-center justify-center px-4 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-coins mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="font-semibold">Manage Credits</span>
                            </a>
                            <button class="group flex items-center justify-center px-4 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-history mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="font-semibold">Review Answers</span>
                            </button>
                            <button class="group flex items-center justify-center px-4 py-4 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl hover:from-orange-700 hover:to-orange-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-trophy mr-3 group-hover:bounce transition-transform duration-300"></i>
                                <span class="font-semibold">Achievements</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Study Tips -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activity -->
            <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-blue-50/50 to-indigo-50/50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                            <i class="fas fa-history text-white text-lg"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Recent Activity</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clipboard-list text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No recent activity yet</p>
                        <p class="text-sm text-gray-400 mt-2">Start solving questions to see your progress here</p>
                        <button class="mt-4 px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 font-semibold">
                            Get Started
                        </button>
                    </div>
                </div>
            </div>

            <!-- Study Tips -->
            <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border border-white/30 overflow-hidden hover:shadow-2xl transition-all duration-500">
                <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-white/80 via-yellow-50/50 to-yellow-100/50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg">
                            <i class="fas fa-lightbulb text-white text-lg"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Daily Study Tip</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-star text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Practice Consistently</h4>
                                    <p class="text-gray-700 text-sm">Solving just 5-10 questions daily can significantly improve your mathematical skills over time.</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="text-center p-3 bg-blue-50 rounded-lg">
                                <i class="fas fa-brain text-blue-600 text-lg mb-2"></i>
                                <p class="text-xs font-semibold text-blue-900">Focus Mode</p>
                            </div>
                            <div class="text-center p-3 bg-green-50 rounded-lg">
                                <i class="fas fa-clock text-green-600 text-lg mb-2"></i>
                                <p class="text-xs font-semibold text-green-900">Time Management</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Progress Chart
    const progressCtx = document.getElementById('progressChart').getContext('2d');
    new Chart(progressCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Questions Solved',
                data: [0, 0, 0, 0, 0, 0, 0],
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8B5CF6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#6B7280'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280'
                    }
                }
            }
        }
    });

    // Add hover animations to cards
    const cards = document.querySelectorAll('.group');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>

@endsection
