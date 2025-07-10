@extends('layouts.admin')

@push('head')
<!-- MathJax Configuration -->
<script>
    window.MathJax = {
        tex: {
            inlineMath: [['\\(', '\\)'], ['$', '$']],
            displayMath: [['\\[', '\\]'], ['$$', '$$']],
            processEscapes: true,
            processEnvironments: true
        },
        options: {
            skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre']
        },
        startup: {
            ready: () => {
                console.log('MathJax is loaded and ready');
                MathJax.startup.defaultReady();
            }
        }
    };
</script>

<!-- MathJax Library -->
<script type="text/javascript" id="MathJax-script" async 
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
</script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header with Breadcrumb -->
    <div class="mb-6">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.questions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-list mr-2"></i>
                        Questions
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Question Details</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Question Details</h1>
                <p class="text-gray-600 mt-1">View and manage question information</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.questions.edit', $question) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Edit Question
                </a>
                <a href="{{ route('admin.questions.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-8">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
                <!-- Main Exam-like Question Display - 2/3 width -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Exam Style: Question, Image, Options, Answer -->
                    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8 border border-gray-100 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Exam Question</h3>
                        </div>
                        
                        <div class="space-y-8">
                            <!-- Question Text -->
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-question text-indigo-600"></i>
                                    </div>
                                    <label class="text-lg font-bold text-gray-800">Question</label>
                                </div>
                                <div class="prose prose-lg max-w-none">
                                    <div class="mathjax-content text-gray-700 leading-relaxed">{!! nl2br($question->question) !!}</div>
                                </div>
                            </div>
                            <!-- Image if exists -->
                            @if($question->image)
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-image text-purple-600"></i>
                                    </div>
                                    <label class="text-lg font-bold text-gray-800">Visual Content</label>
                                </div>
                                <div class="flex justify-center">
                                    <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200 max-w-lg">
                                        <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="w-full h-auto">
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Options -->
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-orange-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-list-ul text-orange-600"></i>
                                    </div>
                                    <label class="text-lg font-bold text-gray-800">Answer Options</label>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                    <div class="mathjax-content text-gray-700 leading-relaxed space-y-2">{!! nl2br($question->options) !!}</div>
                                </div>
                            </div>
                            <!-- Answer -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 shadow-sm border border-green-100">
                                <div class="flex items-center mb-4">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    </div>
                                    <label class="text-lg font-bold text-gray-800">Correct Answer</label>
                                </div>
                                <div class="bg-white rounded-xl p-4 border border-green-200 shadow-sm">
                                    <div class="mathjax-content text-green-800 font-bold text-xl">{!! nl2br($question->answer) !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - 1/3 width -->
                <div class="space-y-6">
                    <!-- Academic Information Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100 shadow-lg">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Academic Info</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Education Level</span>
                                    <span class="font-bold text-gray-900 bg-blue-50 px-3 py-1 rounded-lg">{{ $question->education_level }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Question Type</span>
                                    <span class="font-bold text-gray-900 bg-blue-50 px-3 py-1 rounded-lg">{{ $question->question_type }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Difficulty</span>
                                    <span class="px-3 py-1 text-sm font-bold rounded-lg
                                        @if($question->difficulty == 'easy') bg-green-100 text-green-800
                                        @elseif($question->difficulty == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($question->difficulty) }}
                                    </span>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Source</span>
                                    <span class="font-bold text-gray-900 bg-blue-50 px-3 py-1 rounded-lg">{{ $question->source }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Source & Location Card -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100 shadow-lg">
                        <div class="flex items-center mb-6">
                            <div class="bg-green-100 p-3 rounded-xl mr-4">
                                <i class="fas fa-map-marked-alt text-green-600 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Location</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-green-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Institution</span>
                                    <span class="font-bold text-gray-900 bg-green-50 px-3 py-1 rounded-lg">{{ $question->institution }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-green-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Region</span>
                                    <span class="font-bold text-gray-900 bg-green-50 px-3 py-1 rounded-lg">{{ $question->region }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-green-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">State (UF)</span>
                                    <span class="font-bold text-gray-900 bg-green-50 px-3 py-1 rounded-lg">{{ strtoupper($question->uf) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100 shadow-lg">
                        <div class="flex items-center mb-6">
                            <div class="bg-purple-100 p-3 rounded-xl mr-4">
                                <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Statistics</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-purple-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Year</span>
                                    <span class="font-bold text-gray-900 bg-purple-50 px-3 py-1 rounded-lg">{{ $question->year }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-purple-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Created</span>
                                    <span class="font-bold text-gray-900 bg-purple-50 px-3 py-1 rounded-lg">{{ $question->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            @if($question->updated_at != $question->created_at)
                            <div class="bg-white rounded-xl p-4 shadow-sm border border-purple-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Updated</span>
                                    <span class="font-bold text-gray-900 bg-purple-50 px-3 py-1 rounded-lg">{{ $question->updated_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Document Section -->
                    @if($question->doc)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-file-alt text-red-600 mr-2"></i>
                                    Document
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-amber-100">
                                    <p class="text-gray-600 mb-4">Question document available for download</p>
                                    <a href="{{ route('admin.questions.download-document', $question) }}" 
                                       class="inline-flex items-center bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                                        <i class="fas fa-download mr-2"></i>
                                        Download Document
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Card -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-cogs text-gray-600 mr-2"></i>
                                Actions
                            </h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <a href="{{ route('admin.questions.edit', $question) }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>Edit Question
                            </a>
                            <form action="{{ route('admin.questions.destroy', $question) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this question? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-trash mr-2"></i>Delete Question
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection