@extends('layouts.admin')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<!-- Background with gradient -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <div class="container mx-auto px-8 py-8 lg:py-12 max-w-full">

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full opacity-80"></div>
        </div>

        <!-- Header Section -->
        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                            <i class="fas fa-plus-circle text-white text-xl"></i>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 bg-clip-text text-transparent">
                            Create New Question
                        </h1>
                    </div>
                    <p class="text-gray-600 text-xl font-medium ml-16">Build comprehensive math assessments with precision</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden lg:flex items-center space-x-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-600">Ready to create</span>
                    </div>
                    <a href="{{ route('admin.questions.index') }}"
                       class="group flex items-center space-x-2 bg-white hover:bg-gray-50 text-gray-700 hover:text-gray-900 px-6 py-3 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow-md font-medium">
                        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                        <span>Back to Questions</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center space-x-3">
                    <i class="fas fa-edit"></i>
                    <span>Question Creation Form</span>
                </h2>
                <p class="text-blue-100 mt-2">Fill in all required fields to create a comprehensive question</p>
            </div>

            <div class="p-8 lg:p-10">
                <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf

                <!-- Question Content Section -->
                <div class="group bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-8 border border-blue-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-300">
                            <i class="fas fa-edit text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Question Content</h3>
                            <p class="text-gray-600 text-sm">Enter the question text and answer options</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <!-- Question Text -->
                        <div class="space-y-3">
                            <label for="question" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-question-circle text-white text-sm"></i>
                                </div>
                                Question Text *
                            </label>
                            <textarea name="question" id="question" rows="5"
                                      class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 resize-y hover:border-gray-300 bg-white shadow-sm"
                                      placeholder="Enter the complete question text with proper formatting..." required>{{ old('question') }}</textarea>
                        </div>

                        <!-- Options -->
                        <div class="space-y-3">
                            <label for="options" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-list-ul text-white text-sm"></i>
                                </div>
                                Answer Options *
                            </label>
                            <textarea name="options" id="options" rows="5"
                                      class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 resize-y hover:border-gray-300 bg-white shadow-sm"
                                      placeholder="Enter all possible answer options (A, B, C, D)..." required>{{ old('options') }}</textarea>
                            <div class="flex items-center space-x-2 text-sm text-gray-600 bg-blue-50 p-3 rounded-lg">
                                <i class="fas fa-lightbulb text-blue-500"></i>
                                <span>Provide clear and distinct answer options for multiple choice questions</span>
                            </div>
                        </div>

                        <!-- Answer -->
                        <div class="space-y-3">
                            <label for="answer" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-check-circle text-white text-sm"></i>
                                </div>
                                Correct Answer *
                            </label>
                            <textarea name="answer" id="answer" rows="4"
                                      class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 resize-y hover:border-gray-300 bg-white shadow-sm"
                                      placeholder="Enter the complete correct answer with explanation..." required>{{ old('answer') }}</textarea>
                            <div class="flex items-center space-x-2 text-sm text-emerald-700 bg-emerald-50 p-3 rounded-lg">
                                <i class="fas fa-shield-check text-emerald-500"></i>
                                <span>Provide the definitive correct answer for this question</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question Properties Section -->
                <div class="group bg-gradient-to-br from-purple-50 to-pink-100 rounded-2xl p-8 border border-purple-200 hover:border-purple-300 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-300">
                            <i class="fas fa-sliders-h text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Question Properties</h3>
                            <p class="text-gray-600 text-sm">Define the question characteristics and difficulty</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                        <div class="space-y-3">
                            <label for="difficulty" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-signal text-white text-sm"></i>
                                </div>
                                Difficulty *
                            </label>
                            <select name="difficulty" id="difficulty"
                                    class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium" required>
                                <option value="">Choose difficulty level</option>
                                <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }} class="text-green-700">🟢 Easy - Basic concepts</option>
                                <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }} class="text-yellow-700">🟡 Medium - Intermediate skills</option>
                                <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }} class="text-red-700">🔴 Hard - Advanced problem solving</option>
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label for="question_type" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-tag text-white text-sm"></i>
                                </div>
                                Question Type *
                            </label>
                            <select name="question_type" id="question_type"
                                    class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium" required>
                                <option value="">Select question format</option>
                                <option value="Multiple Choice" {{ old('question_type') == 'Multiple Choice' ? 'selected' : '' }}>📝 Multiple Choice</option>
                                <option value="True/False" {{ old('question_type') == 'True/False' ? 'selected' : '' }}>✅ True/False</option>
                                <option value="Open Ended" {{ old('question_type') == 'Open Ended' ? 'selected' : '' }}>💭 Open Ended</option>
                                <option value="Fill in the Blank" {{ old('question_type') == 'Fill in the Blank' ? 'selected' : '' }}>📄 Fill in the Blank</option>
                            </select>
                        </div>

                        <div class="space-y-3 md:col-span-2 xl:col-span-1">
                            <label for="education_level" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                <div class="w-8 h-8 bg-violet-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-graduation-cap text-white text-sm"></i>
                                </div>
                                Education Level *
                            </label>
                            <select name="education_level" id="education_level"
                                    class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium" required>
                                <option value="">Choose education level</option>
                                <option value="Elementary" {{ old('education_level') == 'Elementary' ? 'selected' : '' }}>🎒 Elementary School</option>
                                <option value="Middle School" {{ old('education_level') == 'Middle School' ? 'selected' : '' }}>📚 Middle School</option>
                                <option value="High School" {{ old('education_level') == 'High School' ? 'selected' : '' }}>🎓 High School</option>
                                <option value="University" {{ old('education_level') == 'University' ? 'selected' : '' }}>🏛️ University Level</option>
                            </select>
                        </div>

                        <div class="space-y-3 md:col-span-2 xl:col-span-1">
                            <label for="subject_id" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-book text-white text-sm"></i>
                                </div>
                                Subject *
                            </label>
                            <select name="subject_id" id="subject_id"
                                    class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium" required>
                                <option value="">Choose subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-3 md:col-span-2 xl:col-span-1">
                            <label for="topic_id" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-tags text-white text-sm"></i>
                                </div>
                                Topic *
                            </label>
                            <select name="topic_id" id="topic_id"
                                    class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium" required disabled>
                                <option value="">First select a subject</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Source Information Section -->
                <div class="group bg-gradient-to-br from-emerald-50 to-teal-100 rounded-2xl p-8 border border-emerald-200 hover:border-emerald-300 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-300">
                            <i class="fas fa-info-circle text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Source Information</h3>
                            <p class="text-gray-600 text-sm">Provide attribution and source details</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                            <div class="space-y-3">
                                <label for="institution" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-building text-white text-sm"></i>
                                    </div>
                                    Institution *
                                </label>
                                <input type="text" name="institution" id="institution"
                                       class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium"
                                       placeholder="University or institution name..." value="{{ old('institution') }}" required>
                            </div>

                            <div class="space-y-3">
                                <label for="source" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-bookmark text-white text-sm"></i>
                                    </div>
                                    Source *
                                </label>
                                <input type="text" name="source" id="source"
                                       class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium"
                                       placeholder="Exam, textbook, or source name..." value="{{ old('source') }}" required>
                            </div>

                            <div class="space-y-3 md:col-span-2 xl:col-span-1">
                                <label for="year" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar text-white text-sm"></i>
                                    </div>
                                    Year *
                                </label>
                                <input type="number" name="year" id="year" min="1900" max="{{ date('Y') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium"
                                       placeholder="{{ date('Y') }}" value="{{ old('year') }}" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label for="region" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-map-marker-alt text-white text-sm"></i>
                                    </div>
                                    Region *
                                </label>
                                <input type="text" name="region" id="region"
                                       class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium"
                                       placeholder="Geographic region or area..." value="{{ old('region') }}" required>
                            </div>

                            <div class="space-y-3">
                                <label for="uf" class="flex items-center text-sm font-bold text-gray-800 uppercase tracking-wide">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-flag text-white text-sm"></i>
                                    </div>
                                    State Code (UF) *
                                </label>
                                <input type="text" name="uf" id="uf" maxlength="2"
                                       class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm font-medium uppercase"
                                       placeholder="SP, RJ, MG..." value="{{ old('uf') }}" required>
                                <div class="flex items-center space-x-2 text-sm text-yellow-700 bg-yellow-50 p-3 rounded-lg">
                                    <i class="fas fa-info-circle text-yellow-500"></i>
                                    <span>Enter the 2-letter Brazilian state code</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Uploads Section -->
                <div class="group bg-gradient-to-br from-amber-50 to-orange-100 rounded-2xl p-8 border border-amber-200 hover:border-amber-300 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="p-3 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-300">
                            <i class="fas fa-paperclip text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">File Attachments</h3>
                            <p class="text-gray-600 text-sm">Upload supporting documents and images</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Image Upload (Optional) -->
                        <div class="bg-white rounded-2xl p-6 border-2 border-dashed border-gray-200 hover:border-blue-300 transition-all duration-300 hover:bg-blue-50">
                            <div class="text-center space-y-4">
                                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto">
                                    <i class="fas fa-image text-blue-600 text-2xl"></i>
                                </div>
                                <div>
                                    <label for="image" class="flex items-center justify-center text-sm font-bold text-gray-800 uppercase tracking-wide cursor-pointer">
                                        Image Upload (Optional)
                                    </label>
                                    <p class="text-sm text-gray-600 mt-2">Drag and drop or click to browse</p>
                                </div>
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <div class="flex items-center justify-center space-x-2 text-sm text-blue-700 bg-blue-50 p-3 rounded-lg">
                                    <i class="fas fa-info-circle text-blue-500"></i>
                                    <span>JPG, PNG, GIF up to 2MB</span>
                                </div>
                            </div>
                        </div>

                        <!-- Document Upload (Required) -->
                        <div class="bg-white rounded-2xl p-6 border-2 border-dashed border-red-200 hover:border-red-300 transition-all duration-300 hover:bg-red-50">
                            <div class="text-center space-y-4">
                                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto">
                                    <i class="fas fa-file-word text-red-600 text-2xl"></i>
                                </div>
                                <div>
                                    <label for="doc" class="flex items-center justify-center text-sm font-bold text-gray-800 uppercase tracking-wide cursor-pointer">
                                        Question Document *
                                    </label>
                                    <p class="text-sm text-gray-600 mt-2">Required Word document with question</p>
                                </div>
                                <input type="file" name="doc" id="doc" accept=".doc,.docx" required
                                       class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <div class="flex items-center justify-center space-x-2 text-sm text-red-700 bg-red-50 p-3 rounded-lg">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                    <span>DOC or DOCX files up to 10MB</span>
                                </div>
                            </div>
                        </div>

                        <!-- Answer Document Upload (Required) -->
                        <div class="bg-white rounded-2xl p-6 border-2 border-dashed border-green-200 hover:border-green-300 transition-all duration-300 hover:bg-green-50">
                            <div class="text-center space-y-4">
                                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto">
                                    <i class="fas fa-file-check text-green-600 text-2xl"></i>
                                </div>
                                <div>
                                    <label for="answer_doc" class="flex items-center justify-center text-sm font-bold text-gray-800 uppercase tracking-wide cursor-pointer">
                                        Answer Document *
                                    </label>
                                    <p class="text-sm text-gray-600 mt-2">Required Word document with answer</p>
                                </div>
                                <input type="file" name="answer_doc" id="answer_doc" accept=".doc,.docx" required
                                       class="w-full border-2 border-gray-200 rounded-xl p-4 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 hover:border-gray-300 bg-white shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                <div class="flex items-center justify-center space-x-2 text-sm text-green-700 bg-green-50 p-3 rounded-lg">
                                    <i class="fas fa-exclamation-circle text-green-500"></i>
                                    <span>DOC or DOCX files up to 10MB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gradient-to-r from-gray-50 to-slate-100 rounded-2xl p-8 border border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <div class="flex items-center space-x-3 text-gray-600">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-shield-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Ready to submit?</p>
                                <p class="text-sm">All required fields must be completed</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                            <a href="{{ route('admin.questions.index') }}"
                               class="group flex items-center justify-center space-x-2 px-8 py-4 border-2 border-gray-300 rounded-xl text-gray-700 hover:text-gray-900 hover:border-gray-400 transition-all duration-300 font-semibold bg-white hover:bg-gray-50 shadow-sm hover:shadow-md">
                                <i class="fas fa-times group-hover:rotate-90 transition-transform duration-200"></i>
                                <span>Cancel</span>
                            </a>

                            <button type="submit" id="submitBtn"
                                    class="group flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-700 hover:from-blue-700 hover:via-purple-700 hover:to-blue-800 text-white rounded-xl transition-all duration-300 font-bold shadow-lg hover:shadow-xl transform hover:scale-105 hover:-translate-y-1">
                                <i class="fas fa-plus group-hover:rotate-180 transition-transform duration-300"></i>
                                <span>Create Question</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    const fileInputs = document.querySelectorAll('input[type="file"]');
    let isSubmitting = false;

    // Enhanced form submission
    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Creating Question...</span>';

        // Add progress indication
        const progressBar = document.createElement('div');
        progressBar.className = 'fixed top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 z-50 animate-pulse';
        document.body.appendChild(progressBar);
    });

    // File upload enhancements
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const container = input.closest('.bg-white');

            if (file) {
                const fileName = file.name;
                const fileSize = (file.size / (1024 * 1024)).toFixed(2);

                // Create file info display
                let fileInfo = container.querySelector('.file-info');
                if (!fileInfo) {
                    fileInfo = document.createElement('div');
                    fileInfo.className = 'file-info mt-3 p-3 bg-green-50 border border-green-200 rounded-lg';
                    container.appendChild(fileInfo);
                }

                fileInfo.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="text-sm font-medium text-green-800">${fileName}</span>
                        </div>
                        <span class="text-xs text-green-600">${fileSize} MB</span>
                    </div>
                `;

                // Add success animation
                container.classList.add('ring-2', 'ring-green-300', 'border-green-300');
                setTimeout(() => {
                    container.classList.remove('ring-2', 'ring-green-300');
                }, 2000);
            }
        });
    });

    // Form validation enhancements
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('border-red-300', 'ring-red-100');
                this.classList.remove('border-gray-200');
            } else {
                this.classList.remove('border-red-300', 'ring-red-100');
                this.classList.add('border-green-300');
                setTimeout(() => {
                    this.classList.remove('border-green-300');
                    this.classList.add('border-gray-200');
                }, 1000);
            }
        });
    });

    // Auto-uppercase UF field
    const ufField = document.getElementById('uf');
    if (ufField) {
        ufField.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }

    // Subject/Topic dynamic loading
    const subjectSelect = document.getElementById('subject_id');
    const topicSelect = document.getElementById('topic_id');

    if (subjectSelect && topicSelect) {
        subjectSelect.addEventListener('change', function() {
            const subjectId = this.value;
            
            // Reset topic select
            topicSelect.innerHTML = '<option value="">Loading topics...</option>';
            topicSelect.disabled = true;

            if (subjectId) {
                // Fetch topics for selected subject
                fetch(`{{ url('Dashboard/subjects') }}/${subjectId}/topics`)
                    .then(response => response.json())
                    .then(topics => {
                        topicSelect.innerHTML = '<option value="">Choose topic</option>';
                        
                        topics.forEach(topic => {
                            const option = document.createElement('option');
                            option.value = topic.id;
                            option.textContent = topic.name;
                            option.selected = {{ old('topic_id') ?: 'null' }} == topic.id;
                            topicSelect.appendChild(option);
                        });
                        
                        topicSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching topics:', error);
                        topicSelect.innerHTML = '<option value="">Error loading topics</option>';
                        topicSelect.disabled = false;
                    });
            } else {
                topicSelect.innerHTML = '<option value="">First select a subject</option>';
                topicSelect.disabled = true;
            }
        });

        // Trigger change event if subject is pre-selected (for edit mode or validation errors)
        if (subjectSelect.value) {
            subjectSelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endsection
