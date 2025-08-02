@extends('layouts.admin')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<!-- Background with gradient -->
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="w-full px-4 sm:px-6 lg:px-12 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-graduation-cap text-blue-600 mr-3"></i>
                        Subjects Management
                    </h1>
                    <p class="text-gray-600 text-lg">Create and manage educational subjects</p>
                </div>
                <a href="{{ route('admin.subjects.create') }}"
                   class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:-translate-y-0.5 hover:shadow-xl">
                    <i class="fas fa-plus mr-2"></i>Add New Subject
                </a>
            </div>
        </div>

        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Subjects -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Subjects</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $subjects->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Topics -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-tags text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Topics</p>
                        <p class="text-2xl font-bold text-green-600">{{ $subjects->sum(function($subject) { return $subject->topics_count ?? $subject->topics->count(); }) }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Subjects -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Subjects</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $subjects->filter(function($subject) { return ($subject->topics_count ?? $subject->topics->count()) > 0; })->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Average Topics -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-calculator text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Avg Topics</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $subjects->count() > 0 ? round($subjects->sum(function($subject) { return $subject->topics_count ?? $subject->topics->count(); }) / $subjects->count(), 1) : 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-table text-gray-600 mr-2"></i>
                    Subjects Database
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-1"></i>ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-graduation-cap mr-1"></i>Subject
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-tags mr-1"></i>Topics
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-1"></i>Created
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-cog mr-1"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($subjects as $subject)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900"># {{ $subject->id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="bg-blue-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                            <i class="fas fa-graduation-cap text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 leading-5">
                                                {{ $subject->name }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                Subject ID: #{{ $subject->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if(($subject->topics_count ?? $subject->topics->count()) > 0) 
                                            bg-green-100 text-green-800 border border-green-200
                                        @else 
                                            bg-gray-100 text-gray-600 border border-gray-200
                                        @endif transition-all duration-200 hover:scale-105">
                                        <i class="fas fa-tags text-xs mr-1"></i>
                                        {{ $subject->topics_count ?? $subject->topics->count() }} Topics
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $subject->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $subject->created_at->format('g:i A') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.subjects.show', $subject) }}"
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                                            <i class="fas fa-eye text-xs mr-1"></i>View
                                        </a>
                                        <a href="{{ route('admin.subjects.edit', $subject) }}"
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                                            <i class="fas fa-edit text-xs mr-1"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.subjects.destroy', $subject) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this subject? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                                                <i class="fas fa-trash text-xs mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-graduation-cap text-gray-400 text-6xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-600 mb-2">No subjects found</h3>
                                        <p class="text-gray-500 mb-4">Start by creating your first subject to organize topics</p>
                                        <a href="{{ route('admin.subjects.create') }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                                            <i class="fas fa-plus mr-2"></i>Create Subject
                                        </a>
                                    </div>
                                </td>
            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($subjects, 'hasPages') && $subjects->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Showing {{ $subjects->firstItem() }} to {{ $subjects->lastItem() }} of {{ $subjects->total() }} results
                        </div>
                        <div>
                            {{ $subjects->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
