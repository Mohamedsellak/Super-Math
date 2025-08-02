@extends('layouts.user')

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
                MathJax.startup.defaultReady();
            }
        }
    };
</script>
<script type="text/javascript" id="MathJax-script" async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .credit-warning {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .question-card-enter {
        animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    .badge-animate {
        transition: all 0.2s ease-in-out;
    }
    .badge-animate:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')

<!-- Background with gradient -->
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-2">
                <i class="fas fa-brain text-blue-600 mr-3"></i>
                Question Bank
            </h1>
            <p class="text-gray-600 text-lg">Browse and select questions for your exam preparation</p>
        </div>

        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Questions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-list text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Questions</p>
                        <p class="text-2xl font-bold text-gray-800" id="totalQuestions">{{ count($questions) }}</p>
                    </div>
                </div>
            </div>

            <!-- Selected Questions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Selected</p>
                        <p class="text-2xl font-bold text-green-600" id="selectedCount">0</p>
                    </div>
                </div>
            </div>

            <!-- Credits Required -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-coins text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Credits Needed</p>
                        <p class="text-2xl font-bold text-yellow-600" id="creditsNeeded">0</p>
                    </div>
                </div>
            </div>

            <!-- Available Credits -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-wallet text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Available Credits</p>
                        <p class="text-2xl font-bold text-purple-600" id="availableCredits">{{ auth()->user()->credit ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Layout -->
        <div class="flex flex-col xl:flex-row gap-8">
            <!-- Sidebar: Filter and Search -->
            <div class="w-full xl:w-80 flex-shrink-0 order-2 xl:order-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-filter text-indigo-600 text-xl mr-3"></i>
                        <h3 class="text-xl font-bold text-gray-800">Filter & Search</h3>
                    </div>

                    <div class="space-y-5">
                        <!-- Search Input -->
                        <div>
                            <label for="search-input" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-search mr-2"></i>Search Questions
                            </label>
                            <input type="text" id="search-input"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Search by ID or content...">
                        </div>

                        <!-- Education Level Filter -->
                        <div>
                            <label for="filter-education" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-graduation-cap mr-2"></i>Education Level
                            </label>
                            <select id="filter-education" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Levels</option>
                                @foreach($questions->pluck('education_level')->unique()->filter() as $level)
                                    <option value="{{ $level }}">{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Question Type Filter -->
                        <div>
                            <label for="filter-type" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-tags mr-2"></i>Question Type
                            </label>
                            <select id="filter-type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Types</option>
                                @foreach($questions->pluck('question_type')->unique()->filter() as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject Selector (for loading topics) -->
                        <div>
                            <label for="filter-subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-book mr-2"></i>Select Subject
                            </label>
                            <select id="filter-subject" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Choose subject to load topics</option>
                                @foreach($questions->pluck('topic.subject.name')->unique()->filter() as $subject)
                                    <option value="{{ $subject }}">{{ $subject }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Topic Filter -->
                        <div>
                            <label for="filter-topic" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-tags mr-2"></i>Filter by Topic
                            </label>
                            <select id="filter-topic" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent" disabled>
                                <option value="">Select a subject first</option>
                            </select>
                        </div>

                        <!-- Difficulty Filter -->
                        <div>
                            <label for="filter-difficulty" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-signal mr-2"></i>Difficulty Level
                            </label>
                            <select id="filter-difficulty" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Difficulties</option>
                                @foreach($questions->pluck('difficulty')->unique()->filter() as $diff)
                                    <option value="{{ $diff }}">{{ ucfirst($diff) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3 pt-4">
                            <button type="button" id="applyFilters"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-filter mr-2"></i>Apply Filters
                            </button>
                            <button type="button" id="clearFilters"
                                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>Clear All
                            </button>
                        </div>

                        <!-- Quick Actions -->
                        <div class="border-t pt-5 mt-6">
                            <h4 class="font-semibold text-gray-700 mb-3">Quick Actions</h4>
                            <div class="space-y-2">
                                <button type="button" id="selectAll"
                                        class="w-full text-left px-3 py-2 rounded-lg text-sm text-blue-600 hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-check-double mr-2"></i>Select All Visible
                                </button>
                                <button type="button" id="deselectAll"
                                        class="w-full text-left px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-times-circle mr-2"></i>Deselect All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Question Area -->
            <div class="flex-1 order-1 xl:order-2">
                <!-- Navigation Controls -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Music Player Style Navigation -->
                        <div class="flex justify-center items-center space-x-1">
                            <!-- First Button -->
                            <button type="button" id="firstBtn"
                                    class="bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-600 p-3 rounded-full transition-all duration-200 shadow-sm hover:shadow-md"
                                    title="First Question">
                                <i class="fas fa-backward-step text-lg"></i>
                            </button>

                            <!-- Previous Button -->
                            <button type="button" id="prevBtn"
                                    class="bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-600 p-3 rounded-full transition-all duration-200 shadow-sm hover:shadow-md ml-1"
                                    title="Previous Question">
                                <i class="fas fa-caret-left text-lg"></i>
                            </button>

                            <!-- Question ID Selector -->
                            <div class="mx-6 flex items-center bg-gray-50 rounded-full px-4 py-2 border border-gray-200">
                                <label for="gotoInput" class="text-sm font-medium text-gray-600 mr-2">Q:</label>
                                <input type="number" id="gotoInput" min="1"
                                       class="w-16 bg-transparent text-center text-lg font-bold text-gray-800 focus:outline-none focus:ring-0 border-0 p-0"
                                       placeholder="1">
                                <span class="text-gray-400 mx-1">/</span>
                                <span id="totalQuestionsNav" class="text-gray-600 font-medium">{{ count($questions) }}</span>
                                <button type="button" id="gotoBtn"
                                        class="ml-2 text-blue-600 hover:text-blue-800 transition-colors"
                                        title="Go to Question">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>

                            <!-- Next Button -->
                            <button type="button" id="nextBtn"
                                    class="bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-600 p-3 rounded-full transition-all duration-200 shadow-sm hover:shadow-md mr-1"
                                    title="Next Question">
                                <i class="fas fa-caret-right text-lg"></i>
                            </button>

                            <!-- Last Button -->
                            <button type="button" id="lastBtn"
                                    class="bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-600 p-3 rounded-full transition-all duration-200 shadow-sm hover:shadow-md"
                                    title="Last Question">
                                <i class="fas fa-forward-step text-lg"></i>
                            </button>
                        </div>

                        <!-- Current Question Info -->
                        <div class="text-center lg:text-right">
                            <p class="text-sm text-gray-600">Question <span id="currentQuestionIndex">1</span> of <span id="totalVisible">{{ count($questions) }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Question Cards Container -->
                <div id="questionContainer">
                    <!-- Questions will be rendered here by JavaScript -->
                </div>

                <!-- No Questions Found -->
                <div id="noQuestionsFound" class="hidden text-center py-12">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No Questions Found</h3>
                        <p class="text-gray-500">Try adjusting your search criteria or filters.</p>
                    </div>
                </div>

                <!-- Download Section -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
                    <!-- Credit Warning -->
                    <div id="creditWarning" class="hidden mb-6 bg-red-50 border border-red-200 rounded-xl p-4 credit-warning">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-red-800">Insufficient Credits</h4>
                                <p class="text-red-600 text-sm">You need <span id="creditShortage">0</span> more credits to download the selected questions.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Selection Summary -->
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center text-lg">
                                <i class="fas fa-list-check text-blue-600 mr-3"></i>
                                <span class="font-semibold text-gray-800">
                                    <span id="selectedCountText">0</span> Questions Selected
                                </span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>1 credit per question • Total: <span id="totalCreditsNeeded" class="font-semibold">0</span> credits</span>
                            </div>
                        </div>

                        <form id="downloadForm" method="POST" action="{{ route('user.questions.download') }}">
                            @csrf
                            <input type="hidden" name="selected_questions" id="selectedQuestionIds">
                            <button type="submit" id="downloadBtn" disabled
                                    class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed text-white px-8 py-3 rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105 disabled:transform-none">
                                <i class="fas fa-download mr-2"></i>
                                Download Selected Questions
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Questions data from Laravel
    const questionsData = @json($questions);
    let filteredQuestions = [...questionsData];
    let currentIndex = 0;
    let selectedQuestions = new Set();
    const userCredits = {{ auth()->user()->credit ?? 0 }};

    // DOM Elements
    const questionContainer = document.getElementById('questionContainer');
    const noQuestionsFound = document.getElementById('noQuestionsFound');
    const selectedCount = document.getElementById('selectedCount');
    const selectedCountText = document.getElementById('selectedCountText');
    const creditsNeeded = document.getElementById('creditsNeeded');
    const totalCreditsNeeded = document.getElementById('totalCreditsNeeded');
    const availableCredits = document.getElementById('availableCredits');
    const creditWarning = document.getElementById('creditWarning');
    const creditShortage = document.getElementById('creditShortage');
    const downloadBtn = document.getElementById('downloadBtn');
    const selectedQuestionIds = document.getElementById('selectedQuestionIds');
    const currentQuestionIndex = document.getElementById('currentQuestionIndex');
    const totalVisible = document.getElementById('totalVisible');
    const totalQuestionsNav = document.getElementById('totalQuestionsNav');
    const gotoInput = document.getElementById('gotoInput');

    // Difficulty color mapping
    const difficultyColors = {
        'easy': 'bg-green-100 text-green-800',
        'medium': 'bg-yellow-100 text-yellow-800',
        'hard': 'bg-red-100 text-red-800'
    };

    // Question type color mapping
    const typeColors = {
        'multiple_choice': 'bg-blue-100 text-blue-800',
        'true_false': 'bg-purple-100 text-purple-800',
        'short_answer': 'bg-indigo-100 text-indigo-800',
        'essay': 'bg-pink-100 text-pink-800'
    };

    // Render question card
    function renderQuestionCard(question, index) {
        const isSelected = selectedQuestions.has(question.id);
        const difficultyClass = difficultyColors[question.difficulty?.toLowerCase()] || 'bg-gray-100 text-gray-800';
        const typeClass = typeColors[question.question_type?.toLowerCase()] || 'bg-gray-100 text-gray-800';

        // Image HTML if exists
        const imageHtml = question.image ? `
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-image text-purple-600"></i>
                    </div>
                    <label class="text-lg font-bold text-gray-800">Visual Content</label>
                </div>
                <div class="flex justify-center">
                    <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200 max-w-lg">
                        <img src="/storage/${question.image}" alt="Question Image" class="w-full h-auto">
                    </div>
                </div>
            </div>
        ` : '';

        // Options HTML
        const optionsHtml = question.options ? `
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-list-ul text-orange-600"></i>
                    </div>
                    <label class="text-lg font-bold text-gray-800">Answer Options</label>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <div class="mathjax-content text-gray-700 leading-relaxed space-y-2">${question.options.replace(/\n/g, '<br>')}</div>
                </div>
            </div>
        ` : '';

        // Answer section - only show warning
        const answerHtml = `
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 shadow-sm border border-yellow-200 mb-6">
                <div class="flex items-center mb-4">
                    <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-lock text-yellow-600"></i>
                    </div>
                    <label class="text-lg font-bold text-gray-800">Correct Answer</label>
                </div>
                <div class="bg-white rounded-xl p-4 border border-yellow-200 shadow-sm">
                    <div class="flex items-center text-yellow-700">
                        <i class="fas fa-download mr-2"></i>
                        <span class="font-medium">Download this question to view the correct answer</span>
                    </div>
                </div>
            </div>
        `;

        return `
            <div class="question-card bg-white rounded-2xl shadow-lg border border-gray-100 p-6 question-card-enter"
                 data-question-id="${question.id}" data-index="${index}">
                <!-- Question Header -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-xl mr-4">
                            <i class="fas fa-question text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Question #${question.id}</h3>
                            <p class="text-gray-600">Answer hidden - Download for complete access</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="checkbox-${question.id}"
                               class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 question-checkbox"
                               data-question-id="${question.id}" ${isSelected ? 'checked' : ''}>
                        <label for="checkbox-${question.id}" class="ml-2 text-sm font-medium text-gray-700">Select</label>
                    </div>
                </div>

                <!-- Question Metadata -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-gray-600"></i>
                        <span class="text-sm text-gray-600">Education:</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium badge-animate">
                            ${question.education_level || 'Not specified'}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-tag text-gray-600"></i>
                        <span class="text-sm text-gray-600">Type:</span>
                        <span class="px-3 py-1 ${typeClass} rounded-full text-sm font-medium badge-animate">
                            ${question.question_type || 'Not specified'}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-book text-gray-600"></i>
                        <span class="text-sm text-gray-600">Subject:</span>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium badge-animate">
                            ${question.topic && question.topic.subject ? question.topic.subject.name : 'Not specified'}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-tags text-gray-600"></i>
                        <span class="text-sm text-gray-600">Topic:</span>
                        <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-sm font-medium badge-animate">
                            ${question.topic ? question.topic.name : 'Not specified'}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-signal text-gray-600"></i>
                        <span class="text-sm text-gray-600">Difficulty:</span>
                        <span class="px-3 py-1 ${difficultyClass} rounded-full text-sm font-medium badge-animate">
                            ${question.difficulty ? question.difficulty.charAt(0).toUpperCase() + question.difficulty.slice(1) : 'Not specified'}
                        </span>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Question Text -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                <i class="fas fa-question text-indigo-600"></i>
                            </div>
                            <label class="text-lg font-bold text-gray-800">Question</label>
                        </div>
                        <div class="prose prose-lg max-w-none">
                            <div class="mathjax-content text-gray-700 leading-relaxed">${question.question ? question.question.replace(/\n/g, '<br>') : 'Question content not available'}</div>
                        </div>
                    </div>

                    <!-- Image Section -->
                    ${imageHtml}

                    <!-- Options Section -->
                    ${optionsHtml}

                    <!-- Answer Section -->
                    ${answerHtml}

                    <!-- Document Section if exists -->
                    ${question.doc ? `
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-file-alt text-red-600 mr-2"></i>
                                    Document Available
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-amber-100">
                                    <p class="text-gray-600 mb-4">Additional document available for this question</p>
                                    <div class="flex items-center text-amber-600">
                                        <i class="fas fa-download mr-2"></i>
                                        <span class="font-medium">Download question to access document</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    }

    // Update display
    function updateDisplay() {
        questionContainer.innerHTML = '';

        if (filteredQuestions.length === 0) {
            noQuestionsFound.classList.remove('hidden');
            questionContainer.classList.add('hidden');
            return;
        }

        noQuestionsFound.classList.add('hidden');
        questionContainer.classList.remove('hidden');

        if (currentIndex >= filteredQuestions.length) {
            currentIndex = 0;
        }

        const question = filteredQuestions[currentIndex];
        questionContainer.innerHTML = renderQuestionCard(question, currentIndex);

        // Process MathJax for the new content
        if (window.MathJax && window.MathJax.typesetPromise) {
            window.MathJax.typesetPromise([questionContainer]).catch((err) => console.log(err.message));
        }

        // Update navigation info
        currentQuestionIndex.textContent = currentIndex + 1;
        totalVisible.textContent = filteredQuestions.length;
        totalQuestionsNav.textContent = filteredQuestions.length;
        gotoInput.value = currentIndex + 1;
        gotoInput.max = filteredQuestions.length;

        // Add event listener to checkbox
        const checkbox = document.querySelector('.question-checkbox');
        if (checkbox) {
            checkbox.addEventListener('change', handleCheckboxChange);
        }
    }

    // Handle checkbox change
    function handleCheckboxChange(e) {
        const questionId = parseInt(e.target.dataset.questionId);

        if (e.target.checked) {
            selectedQuestions.add(questionId);
        } else {
            selectedQuestions.delete(questionId);
        }

        updateSelectionUI();
    }

    // Update selection UI
    function updateSelectionUI() {
        const count = selectedQuestions.size;
        const credits = count;

        selectedCount.textContent = count;
        selectedCountText.textContent = count;
        creditsNeeded.textContent = credits;
        totalCreditsNeeded.textContent = credits;

        // Update download button
        downloadBtn.disabled = count === 0;

        // Update hidden input
        selectedQuestionIds.value = JSON.stringify([...selectedQuestions]);

        // Show/hide credit warning
        if (credits > userCredits && count > 0) {
            creditWarning.classList.remove('hidden');
            creditShortage.textContent = credits - userCredits;
            downloadBtn.disabled = true;
        } else {
            creditWarning.classList.add('hidden');
        }
    }

    // Navigation functions
    function goToQuestion(index) {
        if (index >= 0 && index < filteredQuestions.length) {
            currentIndex = index;
            updateDisplay();
        }
    }

    // Filter questions
    function filterQuestions() {
        const searchTerm = document.getElementById('search-input').value.toLowerCase();
        const educationFilter = document.getElementById('filter-education').value;
        const typeFilter = document.getElementById('filter-type').value;
        const topicFilter = document.getElementById('filter-topic').value;
        const difficultyFilter = document.getElementById('filter-difficulty').value;

        filteredQuestions = questionsData.filter(question => {
            const matchesSearch = !searchTerm ||
                question.id.toString().includes(searchTerm) ||
                (question.question && question.question.toLowerCase().includes(searchTerm));

            const matchesEducation = !educationFilter || question.education_level === educationFilter;
            const matchesType = !typeFilter || question.question_type === typeFilter;
            const matchesTopic = !topicFilter || (question.topic && question.topic.name === topicFilter);
            const matchesDifficulty = !difficultyFilter || question.difficulty === difficultyFilter;

            return matchesSearch && matchesEducation && matchesType && matchesTopic && matchesDifficulty;
        });

        currentIndex = 0;
        updateDisplay();
    }

    // Event listeners
    document.getElementById('applyFilters').addEventListener('click', filterQuestions);
    document.getElementById('clearFilters').addEventListener('click', () => {
        document.getElementById('search-input').value = '';
        document.getElementById('filter-education').value = '';
        document.getElementById('filter-type').value = '';
        document.getElementById('filter-subject').value = '';
        document.getElementById('filter-topic').value = '';
        document.getElementById('filter-topic').disabled = true;
        document.getElementById('filter-topic').innerHTML = '<option value="">Select a subject first</option>';
        document.getElementById('filter-difficulty').value = '';
        filterQuestions();
    });

    // Subject/Topic dynamic loading
    document.getElementById('filter-subject').addEventListener('change', function() {
        const subjectName = this.value;
        const topicSelect = document.getElementById('filter-topic');
        
        // Reset topic select
        topicSelect.innerHTML = '<option value="">Loading topics...</option>';
        topicSelect.disabled = true;
        
        if (subjectName) {
            // Find the subject ID from the questionsData
            const subjectQuestion = questionsData.find(q => q.topic && q.topic.subject && q.topic.subject.name === subjectName);
            
            if (subjectQuestion && subjectQuestion.topic && subjectQuestion.topic.subject) {
                const subjectId = subjectQuestion.topic.subject.id;
                
                // Fetch topics for selected subject
                fetch(`{{ url('dashboard/subjects') }}/${subjectId}/topics`)
                    .then(response => response.json())
                    .then(topics => {
                        topicSelect.innerHTML = '<option value="">All Topics</option>';
                        
                        topics.forEach(topic => {
                            const option = document.createElement('option');
                            option.value = topic.name;
                            option.textContent = topic.name;
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
                topicSelect.innerHTML = '<option value="">No topics found</option>';
                topicSelect.disabled = false;
            }
        } else {
            topicSelect.innerHTML = '<option value="">Select a subject first</option>';
            topicSelect.disabled = true;
        }
        
        // Clear topic filter when subject changes (but don't filter yet)
        topicSelect.value = '';
    });

    // Topic filter change event
    document.getElementById('filter-topic').addEventListener('change', filterQuestions);

    document.getElementById('selectAll').addEventListener('click', () => {
        filteredQuestions.forEach(question => selectedQuestions.add(question.id));
        updateDisplay();
        updateSelectionUI();
    });

    document.getElementById('deselectAll').addEventListener('click', () => {
        selectedQuestions.clear();
        updateDisplay();
        updateSelectionUI();
    });

    // Navigation event listeners
    document.getElementById('firstBtn').addEventListener('click', () => goToQuestion(0));
    document.getElementById('lastBtn').addEventListener('click', () => goToQuestion(filteredQuestions.length - 1));
    document.getElementById('prevBtn').addEventListener('click', () => goToQuestion(currentIndex - 1));
    document.getElementById('nextBtn').addEventListener('click', () => goToQuestion(currentIndex + 1));

    document.getElementById('gotoBtn').addEventListener('click', () => {
        const value = parseInt(gotoInput.value);
        if (value >= 1 && value <= filteredQuestions.length) {
            goToQuestion(value - 1);
        }
    });

    gotoInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            document.getElementById('gotoBtn').click();
        }
    });

    // Search on input
    document.getElementById('search-input').addEventListener('input', filterQuestions);

    // Initialize
    updateDisplay();
    updateSelectionUI();
</script>
@endpush

@endsection

