@extends('layouts.admin')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('title', 'Create Subject')

@section('content')
<!-- Background with gradient -->
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="w-full px-4 sm:px-6 lg:px-12 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <a href="{{ route('admin.subjects.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Subjects
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-graduation-cap text-blue-600 mr-3"></i>
                Create New Subject
            </h1>
            <p class="text-gray-600 mt-1">Add a new subject to organize educational content</p>
        </div>

        <!-- Form Container -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
                        Subject Information
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Enter the details for the new subject</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form action="{{ route('admin.subjects.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-900 mb-3">
                                <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                                Subject Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required 
                                       placeholder="Enter subject name (e.g., Mathematics, Physics, Chemistry)">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-600">
                                <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                Enter a unique subject name that will be used to organize topics and questions
                            </p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-gray-200">
                            <!-- Cancel Button -->
                            <a href="{{ route('admin.subjects.index') }}" 
                               class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-gray-700 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-md hover:shadow-lg border border-gray-300 group">
                                <svg class="w-5 h-5 mr-2 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span class="transition-all duration-200">Cancel</span>
                            </a>
                            
                            <!-- Create Button -->
                                                        <!-- Create Button -->
                            <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-3.5 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-2xl ring-2 ring-blue-500 ring-opacity-20 hover:ring-opacity-40 group relative overflow-hidden">
                                <!-- Button Background Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <!-- Button Content -->
                                <div class="relative flex items-center">
                                    <svg class="w-5 h-5 mr-2 transition-transform duration-200 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="transition-all duration-200">Create Subject</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
