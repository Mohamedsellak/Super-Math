@extends('layouts.admin')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="p-6">
    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full opacity-80"></div>
    </div>

    <!-- Dashboard Header -->
    <div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 bg-clip-text text-transparent">
                    Admin Dashboard
                </h1>
            </div>
            <p class="text-gray-600 text-lg font-medium ml-16">Complete overview of your Super Math platform performance</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="hidden lg:flex items-center space-x-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-gray-600">System Online</span>
            </div>
            <div class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-sm text-white">
                <i class="fas fa-clock text-sm"></i>
                <span class="text-sm font-medium" id="currentTime">{{ now()->format('H:i') }}</span>
            </div>
        </div>
    </div>
</div>

    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
    <!-- Total Users -->
    <div class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Total Users</p>
                    <p class="text-2xl font-black text-gray-900">{{ \App\Models\User::count() }}</p>
                    <div class="flex items-center space-x-1 mt-1">
                        <i class="fas fa-arrow-up text-green-500 text-xs"></i>
                        <span class="text-xs font-semibold text-green-600">+12.5%</span>
                        <span class="text-xs text-gray-500">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Questions -->
    <div class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-question-circle text-white text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Total Questions</p>
                    <p class="text-2xl font-black text-gray-900">{{ \App\Models\Question::count() }}</p>
                    <div class="flex items-center space-x-1 mt-1">
                        <i class="fas fa-arrow-up text-green-500 text-xs"></i>
                        <span class="text-xs font-semibold text-green-600">+8.3%</span>
                        <span class="text-xs text-gray-500">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Sessions -->
    <div class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-bolt text-white text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Active Sessions</p>
                    <p class="text-2xl font-black text-gray-900">147</p>
                    <div class="flex items-center space-x-1 mt-1">
                        <i class="fas fa-arrow-up text-green-500 text-xs"></i>
                        <span class="text-xs font-semibold text-green-600">+23.1%</span>
                        <span class="text-xs text-gray-500">vs yesterday</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-dollar-sign text-white text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Total Revenue</p>
                    <p class="text-2xl font-black text-gray-900">${{ number_format(\App\Models\Payment::sum('amount'), 2) }}</p>
                    <div class="flex items-center space-x-1 mt-1">
                        <i class="fas fa-arrow-up text-green-500 text-xs"></i>
                        <span class="text-xs font-semibold text-green-600">+15.7%</span>
                        <span class="text-xs text-gray-500">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>    </div>

    <!-- Secondary Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    <!-- Questions by Difficulty -->
    <div class="bg-white rounded-xl shadow-md p-3 border border-gray-100">
        <div class="text-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="fas fa-signal text-green-600 text-sm"></i>
            </div>
            <p class="text-xs font-semibold text-gray-600 uppercase">Easy</p>
            <p class="text-lg font-black text-gray-900">{{ \App\Models\Question::where('difficulty', 'easy')->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-3 border border-gray-100">
        <div class="text-center">
            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="fas fa-signal text-yellow-600 text-sm"></i>
            </div>
            <p class="text-xs font-semibold text-gray-600 uppercase">Medium</p>
            <p class="text-lg font-black text-gray-900">{{ \App\Models\Question::where('difficulty', 'medium')->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-3 border border-gray-100">
        <div class="text-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="fas fa-signal text-red-600 text-sm"></i>
            </div>
            <p class="text-xs font-semibold text-gray-600 uppercase">Hard</p>
            <p class="text-lg font-black text-gray-900">{{ \App\Models\Question::where('difficulty', 'hard')->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-3 border border-gray-100">
        <div class="text-center">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="fas fa-graduation-cap text-blue-600 text-sm"></i>
            </div>
            <p class="text-xs font-semibold text-gray-600 uppercase">Universities</p>
            <p class="text-lg font-black text-gray-900">{{ \App\Models\Question::distinct('institution')->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-3 border border-gray-100">
        <div class="text-center">
            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="fas fa-map-marker-alt text-purple-600 text-sm"></i>
            </div>
            <p class="text-xs font-semibold text-gray-600 uppercase">Regions</p>
            <p class="text-lg font-black text-gray-900">{{ \App\Models\Question::distinct('region')->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-3 border border-gray-100">
        <div class="text-center">
            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="fas fa-credit-card text-indigo-600 text-sm"></i>
            </div>
            <p class="text-xs font-semibold text-gray-600 uppercase">Payments</p>
            <p class="text-lg font-black text-gray-900">{{ \App\Models\Payment::count() }}</p>
        </div>
    </div>    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
    <!-- User Growth Chart -->
    <div class="xl:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">User Growth Analytics</h3>
                <p class="text-gray-600 text-sm">Monthly user registration trends</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Registrations</span>
            </div>
        </div>
        <div class="h-64">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>

    <!-- Question Statistics -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Question Distribution</h3>
                <p class="text-gray-600 text-sm">By difficulty level</p>
            </div>
        </div>
        <div class="h-64">
            <canvas id="questionDistChart"></canvas>
        </div>
    </div>    </div>

    <!-- Content Management and Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Questions -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Recent Questions</h3>
                <p class="text-gray-600 text-sm">Latest questions added to the platform</p>
            </div>
            <a href="{{ route('admin.questions.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-1">
                <span>View All</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="space-y-3">
            @forelse(\App\Models\Question::latest()->take(5)->get() as $question)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-question text-white text-xs"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ Str::limit($question->question, 40) }}</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="px-2 py-1 bg-{{ $question->difficulty == 'easy' ? 'green' : ($question->difficulty == 'medium' ? 'yellow' : 'red') }}-100 text-{{ $question->difficulty == 'easy' ? 'green' : ($question->difficulty == 'medium' ? 'yellow' : 'red') }}-800 rounded-full text-xs font-semibold">
                                {{ ucfirst($question->difficulty) }}
                            </span>
                            <span class="text-xs text-gray-500">{{ Str::limit($question->institution, 20) }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-xs text-gray-500">
                    {{ $question->created_at->diffForHumans() }}
                </div>
            </div>
            @empty
            <div class="text-center py-6 text-gray-500">
                <i class="fas fa-question-circle text-3xl mb-3"></i>
                <p>No questions available</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- System Information & Quick Actions -->
    <div class="space-y-6">
        <!-- System Info -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">System Information</h3>
                    <p class="text-gray-600 text-sm">Current system status and metrics</p>
                </div>
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-server text-green-600"></i>
                        <span class="font-semibold text-gray-900">Server Status</span>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Online</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-database text-blue-600"></i>
                        <span class="font-semibold text-gray-900">Database</span>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Connected</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-memory text-purple-600"></i>
                        <span class="font-semibold text-gray-900">Memory Usage</span>
                    </div>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">67%</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Quick Actions</h3>
                    <p class="text-gray-600 text-sm">Frequently used admin functions</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-3">
                <a href="{{ route('admin.questions.create') }}" class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-3 group-hover:rotate-180 transition-transform duration-300"></i>
                    <span class="font-semibold">Add New Question</span>
                </a>
                <a href="{{ route('admin.questions.index') }}" class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-list mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="font-semibold">Manage Questions</span>
                </a>
                <button class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-chart-bar mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="font-semibold">View Analytics</span>
                </button>
                <button class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl hover:from-orange-700 hover:to-orange-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-cog mr-3 group-hover:rotate-180 transition-transform duration-300"></i>
                    <span class="font-semibold">System Settings</span>
                </button>
            </div>
        </div>        </div>
    </div>
</div>
@endsection

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour12: false, 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        document.getElementById('currentTime').textContent = timeString;
    }
    
    updateTime();
    setInterval(updateTime, 60000); // Update every minute

    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    const userGrowthChart = new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'New Users',
                data: [120, 190, 300, 500, 450, 600, 750],
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6
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
            },
            elements: {
                point: {
                    hoverRadius: 8
                }
            }
        }
    });

    // Question Distribution Chart
    const questionDistCtx = document.getElementById('questionDistChart').getContext('2d');
    const questionDistChart = new Chart(questionDistCtx, {
        type: 'doughnut',
        data: {
            labels: ['Easy', 'Medium', 'Hard'],
            datasets: [{
                data: [
                    {{ \App\Models\Question::where('difficulty', 'easy')->count() }},
                    {{ \App\Models\Question::where('difficulty', 'medium')->count() }},
                    {{ \App\Models\Question::where('difficulty', 'hard')->count() }}
                ],
                backgroundColor: [
                    '#10B981',
                    '#F59E0B',
                    '#EF4444'
                ],
                borderWidth: 0,
                cutout: '60%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            weight: 'bold'
                        }
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
