@extends('layouts.admin')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
<style>
    .ck-content img {
        max-width: 100px !important;
        height: auto !important;
    }
    .question-preview {
        max-height: 60px;
        overflow: hidden;
        position: relative;
    }
    .question-preview::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 30px;
        height: 20px;
        background: linear-gradient(to right, transparent, white);
    }
</style>
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
                        <i class="fas fa-cogs text-blue-600 mr-3"></i>
                        Questions Management
                    </h1>
                    <p class="text-gray-600 text-lg">Manage and organize your question database</p>
                </div>
                <a href="{{ route('admin.questions.create') }}"
                   class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:-translate-y-0.5 hover:shadow-xl">
                    <i class="fas fa-plus mr-2"></i>Add New Question
                </a>
            </div>
        </div>

        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Questions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-list text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Questions</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $questions->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Easy Questions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-smile text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Easy Questions</p>
                        <p class="text-2xl font-bold text-green-600">{{ $questions->where('difficulty', 'easy')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Medium Questions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-meh text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Medium Questions</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $questions->where('difficulty', 'medium')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Hard Questions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transition-transform duration-200 hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-frown text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Hard Questions</p>
                        <p class="text-2xl font-bold text-red-600">{{ $questions->where('difficulty', 'hard')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-table text-gray-600 mr-2"></i>
                    Questions Database
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-question-circle mr-1"></i>Question
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-signal mr-1"></i>Difficulty
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-tag mr-1"></i>Type
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-graduation-cap mr-1"></i>Education
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-book mr-1"></i>Subject
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-tags mr-1"></i>Topic
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-1"></i>Year
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-paperclip mr-1"></i>Files
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-cog mr-1"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($questions as $question)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="bg-blue-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                            <i class="fas fa-question text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 leading-5 question-preview">
                                                {!! Str::limit(strip_tags($question->question, '<b><i><strong><em>'), 100) !!}
                                            </div>
                                            <div class="text-sm text-gray-500 mt-1">
                                                <i class="fas fa-building text-xs mr-1"></i>{{ $question->institution }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                ID: #{{ $question->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-all duration-200 hover:scale-105
                                        @if($question->difficulty == 'easy') bg-green-100 text-green-800 border border-green-200
                                        @elseif($question->difficulty == 'medium') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @else bg-red-100 text-red-800 border border-red-200 @endif">
                                        @if($question->difficulty == 'easy')
                                            <i class="fas fa-smile text-xs mr-1"></i>
                                        @elseif($question->difficulty == 'medium')
                                            <i class="fas fa-meh text-xs mr-1"></i>
                                        @else
                                            <i class="fas fa-frown text-xs mr-1"></i>
                                        @endif
                                        {{ ucfirst($question->difficulty) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200 transition-all duration-200 hover:scale-105">
                                        <i class="fas fa-tag text-xs mr-1"></i>
                                        {{ $question->question_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200 transition-all duration-200 hover:scale-105">
                                        <i class="fas fa-graduation-cap text-xs mr-1"></i>
                                        {{ $question->education_level }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200 transition-all duration-200 hover:scale-105">
                                        <i class="fas fa-book text-xs mr-1"></i>
                                        {{ $question->topic->subject->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800 border border-teal-200 transition-all duration-200 hover:scale-105">
                                        <i class="fas fa-tags text-xs mr-1"></i>
                                        {{ $question->topic->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $question->year }}</div>
                                    <div class="text-xs text-gray-500">{{ $question->region }}, {{ $question->uf }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-1">
                                        @if($question->image)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                <i class="fas fa-image text-xs mr-1"></i>Image
                                            </span>
                                        @endif
                                        @if($question->doc)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                <i class="fas fa-file-word text-xs mr-1"></i>Document
                                            </span>
                                        @endif
                                        @if(!$question->image && !$question->doc)
                                            <span class="text-xs text-gray-400">No files</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.questions.show', $question) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg"
                                           title="View Question">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.questions.edit', $question) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg"
                                           title="Edit Question">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.questions.destroy', $question) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this question?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center w-8 h-8 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg"
                                                    title="Delete Question">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-question-circle text-gray-400 text-6xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-600 mb-2">No questions found</h3>
                                        <p class="text-gray-500 mb-4">Get started by creating your first question</p>
                                        <a href="{{ route('admin.questions.create') }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                                            <i class="fas fa-plus mr-2"></i>Create Question
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($questions, 'hasPages') && $questions->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Showing {{ $questions->firstItem() }} to {{ $questions->lastItem() }} of {{ $questions->total() }} results
                        </div>
                        <div>
                            {{ $questions->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configure MathJax
    window.MathJax = {
        tex: {
            inlineMath: [['\\(', '\\)'], ['$', '$']],
            displayMath: [['\\[', '\\]'], ['$$', '$$']],
            processEscapes: true,
            processEnvironments: true
        },
        options: {
            skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre']
        }
    };

    // Process MathJax when page loads
    if (window.MathJax && window.MathJax.typesetPromise) {
        MathJax.typesetPromise().then(() => {
            console.log('MathJax initial typeset complete');
        }).catch((err) => console.log('MathJax typeset failed: ' + err.message));
    }
});
</script>
@endsection
