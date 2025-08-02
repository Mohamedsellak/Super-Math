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
                        <a href="{{ route('admin.topics.index') }}" 
                           class="text-gray-500 hover:text-gray-700 mr-4 transition-colors duration-200">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </a>
                        <h1 class="text-4xl font-bold text-gray-800">
                            <i class="fas fa-tag text-green-600 mr-3"></i>
                            {{ $topic->name }}
                        </h1>
                    </div>
                    <p class="text-gray-600 text-lg">Topic details and associated questions</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.subjects.show', $topic->subject) }}"
                       class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:-translate-y-0.5 hover:shadow-xl">
                        <i class="fas fa-graduation-cap mr-2"></i>View Subject
                    </a>
                    <a href="{{ route('admin.topics.edit', $topic) }}"
                       class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:-translate-y-0.5 hover:shadow-xl">
                        <i class="fas fa-edit mr-2"></i>Edit Topic
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Topic ID -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-gray-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-hashtag text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Topic ID</p>
                        <p class="text-2xl font-bold text-gray-800">#{{ $topic->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Subject -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-indigo-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-graduation-cap text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Subject</p>
                        <p class="text-lg font-bold text-indigo-600 truncate">{{ $topic->subject->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Questions Count -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-question-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Questions</p>
                        <p class="text-2xl font-bold text-green-600">{{ $topic->questions->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Created Date -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-calendar text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Created</p>
                        <p class="text-sm font-bold text-purple-600">{{ $topic->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $topic->created_at->format('g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topic Details and Questions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Topic Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                            Topic Information
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                        <i class="fas fa-tag text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Topic Name</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $topic->name }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="bg-indigo-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                        <i class="fas fa-graduation-cap text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Subject</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                            {{ $topic->subject->name }}
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
                                        <p class="text-lg font-semibold text-gray-900">{{ $topic->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $topic->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="bg-yellow-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                        <i class="fas fa-calendar-edit text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $topic->updated_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $topic->updated_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Questions Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-question-circle text-gray-600 mr-2"></i>
                            Questions ({{ $topic->questions->count() }})
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if($topic->questions->count() > 0)
                            <div class="space-y-4">
                                @foreach($topic->questions->take(5) as $question)
                                    <div class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-100 hover:bg-gray-100 transition-colors duration-200">
                                        <div class="bg-blue-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                            <i class="fas fa-question text-blue-600 text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-800 leading-5">{{ Str::limit($question->question, 80) }}</p>
                                            <div class="flex items-center mt-2 space-x-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                                    @if($question->difficulty == 'easy') bg-green-100 text-green-800
                                                    @elseif($question->difficulty == 'medium') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($question->difficulty) }}
                                                </span>
                                                <span class="text-xs text-gray-500">ID: #{{ $question->id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                @if($topic->questions->count() > 5)
                                    <div class="text-center py-3 border-t border-gray-200">
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-ellipsis-h mr-1"></i>
                                            And {{ $topic->questions->count() - 5 }} more questions
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-question-circle text-gray-400 text-4xl mb-4"></i>
                                <h4 class="text-lg font-medium text-gray-600 mb-2">No Questions Yet</h4>
                                <p class="text-gray-500 text-sm">This topic doesn't have any questions associated with it.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
