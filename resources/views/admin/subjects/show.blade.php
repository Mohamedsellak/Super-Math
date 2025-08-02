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
                    <div class="flex items-center mb-2">
                        <a href="{{ route('admin.subjects.index') }}" 
                           class="text-gray-500 hover:text-gray-700 mr-4 transition-colors duration-200">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </a>
                        <h1 class="text-4xl font-bold text-gray-800">
                            <i class="fas fa-graduation-cap text-blue-600 mr-3"></i>
                            {{ $subject->name }}
                        </h1>
                    </div>
                    <p class="text-gray-600 text-lg">Subject details and associated topics</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.subjects.edit', $subject) }}"
                       class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:-translate-y-0.5 hover:shadow-xl">
                        <i class="fas fa-edit mr-2"></i>Edit Subject
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Subject ID -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-gray-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-hashtag text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Subject ID</p>
                        <p class="text-2xl font-bold text-gray-800">#{{ $subject->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Topics Count -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-tags text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Topics</p>
                        <p class="text-2xl font-bold text-green-600">{{ $subject->topics->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Questions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-question-circle text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Questions</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $subject->topics->sum(function($topic) { return $topic->questions->count(); }) }}</p>
                    </div>
                </div>
            </div>

            <!-- Created Date -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-calendar text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Created</p>
                        <p class="text-sm font-bold text-yellow-600">{{ $subject->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $subject->created_at->format('g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subject Details and Topics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Subject Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                            Subject Information
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                        <i class="fas fa-graduation-cap text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Subject Name</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $subject->name }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                        <i class="fas fa-tags text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Total Topics</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                            {{ $subject->topics->count() }} Topics
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Metadata -->
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="bg-purple-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                        <i class="fas fa-calendar-plus text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Created</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $subject->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $subject->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="bg-yellow-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                        <i class="fas fa-calendar-edit text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $subject->updated_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $subject->updated_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Topics Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-tags text-gray-600 mr-2"></i>
                            Topics ({{ $subject->topics->count() }})
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if($subject->topics->count() > 0)
                            <div class="space-y-4">
                                @foreach($subject->topics as $topic)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100 hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex items-center">
                                            <div class="bg-green-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                                <i class="fas fa-tag text-green-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">{{ $topic->name }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $topic->questions->count() }} questions
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.topics.show', $topic) }}"
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                                            <i class="fas fa-eye text-xs mr-1"></i>View
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-tags text-gray-400 text-4xl mb-4"></i>
                                <h4 class="text-lg font-medium text-gray-600 mb-2">No Topics Yet</h4>
                                <p class="text-gray-500 text-sm">This subject doesn't have any topics associated with it.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
