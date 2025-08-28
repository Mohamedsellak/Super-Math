@extends('layouts.user')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full opacity-80"></div>
        </div>

        <!-- Welcome Header -->
        <div class="mb-8 bg-gradient-to-r from-white via-blue-50/30 to-indigo-50/30 rounded-2xl shadow-sm border border-gray-100 p-6">
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
                    <p class="text-gray-600 ml-16 text-base">Track your usage and manage your resources</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('user.credits.index') }}" class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 rounded-full shadow-sm text-white transition-all duration-300">
                        <i class="fas fa-coins text-sm"></i>
                        <span class="text-sm font-medium">{{ number_format(auth()->user()->credit ?? 0) }} Credits</span>
                    </a>
                    <a href="{{ route('user.questions.index') }}" class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-full shadow-sm text-white transition-all duration-300">
                        <i class="fas fa-question-circle text-sm"></i>
                        <span class="text-sm font-medium">Browse Questions</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Essential Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Available Credits -->
            <div class="group bg-gradient-to-br from-emerald-50 via-emerald-100 to-emerald-200 rounded-2xl border border-emerald-200 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-coins text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Available Credits</p>
                        <p class="text-3xl font-black text-gray-900">{{ number_format($availableCredits) }}</p>
                        @if($creditExpiresAt)
                            <p class="text-xs text-gray-500 mt-1">Expires {{ $creditExpiresAt->format('d M Y') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Downloads / Usage -->
            <div class="group bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 rounded-2xl border border-blue-200 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-download text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-600 uppercase tracking-wide">Downloads (All Time)</p>
                        <p class="text-3xl font-black text-gray-900">{{ $downloadsCount }}</p>
                        <p class="text-xs text-gray-500 mt-1">Last 14 days: {{ $downloadsChartData->sum() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile + Chart + Recent Activity -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
            <!-- Profile Overview -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-white via-blue-50/30 to-indigo-50/30">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Profile</h3>
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
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded-lg">
                            <span class="text-gray-600">Institution</span>
                            <span class="font-semibold text-gray-900">{{ auth()->user()->institution ?? 'Not specified' }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded-lg">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-semibold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('profile.index') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Edit</a>
                        <a href="{{ route('user.credits.index') }}" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Credits</a>
                    </div>
                </div>
            </div>

            <!-- Progress Chart -->
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-white via-purple-50/30 to-purple-100/30">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Downloads (Last 14 Days)</h3>
                                <p class="text-gray-600 text-xs">Daily download activity</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="h-64">
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-white via-blue-50/30 to-indigo-50/30">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                                <i class="fas fa-history text-white text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Recent Credit Activity</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($recentCreditHistory->isEmpty())
                            <div class="text-center py-8">
                                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-clipboard-list text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No recent credit activity</p>
                                <a href="{{ route('user.questions.index') }}" class="inline-block mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition">Download a Question</a>
                            </div>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentCreditHistory as $entry)
                                    <li class="py-3 flex items-start justify-between">
                                        <div class="flex items-start space-x-3">
                                            <div class="mt-1 w-8 h-8 rounded-full flex items-center justify-center {{ $entry->action === 'Download' ? 'bg-blue-100 text-blue-600' : 'bg-emerald-100 text-emerald-600' }}">
                                                <i class="fas {{ $entry->action === 'Download' ? 'fa-download' : 'fa-circle-plus' }} text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">{{ $entry->action }}</p>
                                                <p class="text-xs text-gray-500">{{ $entry->description }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold {{ str_starts_with($entry->amount, '-') ? 'text-red-600' : 'text-emerald-600' }}">{{ $entry->amount }}</p>
                                            <p class="text-[10px] text-gray-400 mt-1">{{ $entry->created_at->diffForHumans() }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-4 text-right">
                                <a href="{{ route('user.credits.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Full history →</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = @json($downloadsChartLabels);
        const dataPoints = @json($downloadsChartData);
        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: { labels: labels, datasets: [{
                label: 'Downloads',
                data: dataPoints,
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139,92,246,0.12)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8B5CF6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
            }]},
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: '#6B7280' } }, x: { grid: { display: false }, ticks: { color: '#6B7280' } } } }
        });
    });
</script>
@endsection
