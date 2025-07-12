@extends('layouts.admin')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
<!-- Background with gradient -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50 to-teal-100">
    <div class="container mx-auto px-8 py-8 lg:py-12 max-w-full">
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-full opacity-80"></div>
        </div>

        <!-- Header Section -->
        <div class="mb-10">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('admin.questions.index') }}" class="flex items-center text-gray-600 hover:text-emerald-600 transition-colors duration-200 font-medium">
                            <i class="fas fa-list mr-2"></i>
                            Questions
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-emerald-600 font-semibold">Question Details</span>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg">
                            <i class="fas fa-eye text-white text-xl"></i>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-gray-900 via-emerald-800 to-teal-800 bg-clip-text text-transparent">
                            Question Details
                        </h1>
                    </div>
                    <p class="text-gray-600 text-xl font-medium ml-16">Comprehensive view of question information and content</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden lg:flex items-center space-x-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-600">Viewing mode</span>
                    </div>
                    <a href="{{ route('admin.questions.edit', $question) }}" 
                       class="group flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-medium transform hover:scale-105">
                        <i class="fas fa-edit group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Edit Question</span>
                    </a>
                    <a href="{{ route('admin.questions.index') }}" 
                       class="group flex items-center space-x-2 bg-white hover:bg-gray-50 text-gray-700 hover:text-gray-900 px-6 py-3 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow-md font-medium">
                        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                        <span>Back to List</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <!-- Question Display - 3/4 width -->
            <div class="xl:col-span-3 space-y-8">
                <!-- Question Content Section -->
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center space-x-3">
                            <i class="fas fa-file-alt"></i>
                            <span>Question Content</span>
                        </h2>
                        <p class="text-emerald-100 mt-2">Complete question presentation with mathematical content</p>
                    </div>

                    <div class="p-8 lg:p-10 space-y-8">
                        <!-- Question Text -->
                        <div class="group bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-8 border border-blue-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md">
                                    <i class="fas fa-question-circle text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Question</h3>
                                    <p class="text-gray-600 text-sm">Main question content</p>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-blue-100">
                                <div class="prose prose-lg max-w-none">
                                    <div class="mathjax-content text-gray-800 leading-relaxed text-lg">{!! nl2br($question->question) !!}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Visual Content -->
                        @if($question->image)
                        <div class="group bg-gradient-to-br from-purple-50 to-pink-100 rounded-2xl p-8 border border-purple-200 hover:border-purple-300 transition-all duration-300 hover:shadow-lg">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-md">
                                    <i class="fas fa-image text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Visual Content</h3>
                                    <p class="text-gray-600 text-sm">Supporting image or diagram</p>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-purple-100">
                                <div class="flex justify-center">
                                    <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200 max-w-full">
                                        <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="w-full h-auto max-h-96 object-contain">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Answer Options -->
                        <div class="group bg-gradient-to-br from-orange-50 to-amber-100 rounded-2xl p-8 border border-orange-200 hover:border-orange-300 transition-all duration-300 hover:shadow-lg">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-3 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-md">
                                    <i class="fas fa-list-ul text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Answer Options</h3>
                                    <p class="text-gray-600 text-sm">Available choices for the question</p>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-orange-100">
                                <div class="mathjax-content text-gray-800 leading-relaxed text-lg space-y-3">{!! nl2br($question->options) !!}</div>
                            </div>
                        </div>

                        <!-- Correct Answer -->
                        <div class="group bg-gradient-to-br from-emerald-50 to-green-100 rounded-2xl p-8 border border-emerald-200 hover:border-emerald-300 transition-all duration-300 hover:shadow-lg">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-md">
                                    <i class="fas fa-check-circle text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Correct Answer</h3>
                                    <p class="text-gray-600 text-sm">The definitive solution to this question</p>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-6 shadow-sm border border-emerald-100">
                                <div class="mathjax-content text-emerald-800 font-bold text-xl leading-relaxed">{!! nl2br($question->answer) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - 1/4 width -->
            <div class="space-y-6">
                <!-- Quick Properties Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Quick Info
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium text-gray-600">Education Level</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg font-bold text-sm">{{ $question->education_level }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium text-gray-600">Question Type</span>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-lg font-bold text-sm">{{ $question->question_type }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium text-gray-600">Difficulty</span>
                            <span class="px-3 py-1 rounded-lg font-bold text-sm
                                @if($question->difficulty == 'easy') bg-green-100 text-green-800
                                @elseif($question->difficulty == 'medium') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($question->difficulty == 'easy') 🟢 {{ ucfirst($question->difficulty) }}
                                @elseif($question->difficulty == 'medium') 🟡 {{ ucfirst($question->difficulty) }}
                                @else 🔴 {{ ucfirst($question->difficulty) }} @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Source Information Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-building mr-2"></i>
                            Source Details
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-3">
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Institution</p>
                                <p class="font-bold text-gray-900">{{ $question->institution }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Source</p>
                                <p class="font-bold text-gray-900">{{ $question->source }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Year</p>
                                <p class="font-bold text-gray-900">{{ $question->year }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Information Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Location
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-3">
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Region</p>
                                <p class="font-bold text-gray-900">{{ $question->region }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">State Code (UF)</p>
                                <p class="font-bold text-gray-900 text-xl">{{ strtoupper($question->uf) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timestamps Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Timestamps
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-3">
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Created</p>
                                <p class="font-bold text-gray-900">{{ $question->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $question->created_at->format('g:i A') }}</p>
                            </div>
                            @if($question->updated_at != $question->created_at)
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Last Updated</p>
                                <p class="font-bold text-gray-900">{{ $question->updated_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $question->updated_at->format('g:i A') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Document Download Card -->
                @if($question->doc)
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-file-download mr-2"></i>
                            Document
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center space-y-4">
                            <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto">
                                <i class="fas fa-file-word text-amber-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 mb-2">Question Document</p>
                                <p class="text-sm text-gray-600 mb-4">Download the complete document file</p>
                            </div>
                            <a href="{{ route('admin.questions.download-document', $question) }}" 
                               class="group inline-flex items-center justify-center space-x-2 w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-download group-hover:scale-110 transition-transform duration-200"></i>
                                <span>Download</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-cogs mr-2"></i>
                            Actions
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <a href="{{ route('admin.questions.edit', $question) }}" 
                           class="group flex items-center justify-center space-x-2 w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            <i class="fas fa-edit group-hover:scale-110 transition-transform duration-200"></i>
                            <span>Edit Question</span>
                        </a>
                        
                        <form action="{{ route('admin.questions.destroy', $question) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this question? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="group flex items-center justify-center space-x-2 w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                <i class="fas fa-trash group-hover:scale-110 transition-transform duration-200"></i>
                                <span>Delete Question</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced JavaScript for MathJax -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // MathJax processing after content load
    if (typeof MathJax !== 'undefined') {
        MathJax.typesetPromise().then(() => {
            console.log('MathJax content processed successfully');
        }).catch((err) => {
            console.log('MathJax processing error:', err.message);
        });
    }

    // Add smooth animations to cards
    const cards = document.querySelectorAll('.group');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection