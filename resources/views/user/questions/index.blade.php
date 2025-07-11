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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-papm6Q+...your-integrity-hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')

<div class="container mx-auto px-4 py-6">
    <form id="questionsForm" method="POST" action="#">
        @csrf


        <!-- Main Content with Sidebar Layout -->
        <div class="flex flex-col xl:flex-row gap-8">
            <!-- Main Question Area -->
            <div class="flex-1">
                <!-- Navigation Controls and Submit Button at Top -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                    <div class="flex justify-center items-center space-x-2">
                        <button type="button" id="firstBtn" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg shadow-sm" title="First">
                            <i class="fas fa-angle-double-left"></i>
                        </button>
                        <button type="button" id="backwardBtn" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg shadow-sm" title="Backward">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="prevBtn" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg shadow-sm" title="Previous">
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <span class="inline-flex items-center space-x-1">
                            <input type="number" id="gotoInput" min="1" max="{{ count($questions) }}" value="1" class="w-20 px-2 py-2 border rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="ID">
                            <button type="button" id="gotoBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg shadow-sm" title="Go">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </span>
                        <button type="button" id="nextBtn" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg shadow-sm" title="Next">
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button type="button" id="forwardBtn" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg shadow-sm" title="Forward">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button type="button" id="lastBtn" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg shadow-sm" title="Last">
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                    <div class="flex justify-center md:justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-md">Submit Selection</button>
                    </div>
                </div>
                <!-- Only one question visible at a time -->
                <div id="questionCards">
                    @foreach($questions as $idx => $question)
                    <div class="question-card" data-index="{{ $idx }}" style="display: {{ $idx === 0 ? 'block' : 'none' }};">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                            <div class="p-8">
                                <div class="flex items-center mb-4">
                                    <input type="checkbox" name="selected_questions[]" value="{{ $question->id }}" class="mr-3 question-checkbox" id="checkbox-{{ $idx }}">
                                    <label for="checkbox-{{ $idx }}" class="font-semibold text-blue-700">Select this question</label>
                                </div>
                                <div class="space-y-8">
                                    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8 border border-gray-100 shadow-sm">
                                        <div class="flex items-center mb-6">
                                            <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                                            </div>
                                            <h3 class="text-2xl font-bold text-gray-900">Exam Question #{{ $question->id }}</h3>
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
                                                    <button type="button" class="inline-flex items-center bg-amber-300 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all duration-200 shadow-md cursor-not-allowed" disabled>
                                                        <i class="fas fa-download mr-2"></i>
                                                        Download Document
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Sidebar: Filter and Search -->
            <div class="w-full xl:w-80 flex-shrink-0">
                <div class="bg-white rounded-xl shadow p-6 sticky top-8">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Filter & Search</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="filter-education" class="block text-sm font-medium text-gray-700 mb-1">Education Level</label>
                            <select id="filter-education" class="form-select rounded-lg border-gray-300 w-full">
                                <option value="">All</option>
                                @foreach($questions->pluck('education_level')->unique() as $level)
                                    <option value="{{ $level }}">{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="filter-type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select id="filter-type" class="form-select rounded-lg border-gray-300 w-full">
                                <option value="">All</option>
                                @foreach($questions->pluck('question_type')->unique() as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="filter-difficulty" class="block text-sm font-medium text-gray-700 mb-1">Difficulty</label>
                            <select id="filter-difficulty" class="form-select rounded-lg border-gray-300 w-full">
                                <option value="">All</option>
                                @foreach($questions->pluck('difficulty')->unique() as $diff)
                                    <option value="{{ $diff }}">{{ ucfirst($diff) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="search-input" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" id="search-input" class="form-input rounded-lg border-gray-300 w-full" placeholder="Search question text...">
                        </div>
                        <div>
                            <button type="button" id="filterBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow w-full">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Only one question visible at a time -->
        <div id="questionCards">
            @foreach($questions as $idx => $question)
            <div class="question-card" data-index="{{ $idx }}" style="display: {{ $idx === 0 ? 'block' : 'none' }};">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-8">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="selected_questions[]" value="{{ $question->id }}" class="mr-3 question-checkbox" id="checkbox-{{ $idx }}">
                            <label for="checkbox-{{ $idx }}" class="font-semibold text-blue-700">Select this question</label>
                        </div>
                        <div class="space-y-8">
                            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8 border border-gray-100 shadow-sm">
                                <div class="flex items-center mb-6">
                                    <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900">Exam Question #{{ $question->id }}</h3>
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
                                            <button type="button" class="inline-flex items-center bg-amber-300 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all duration-200 shadow-md cursor-not-allowed" disabled>
                                                <i class="fas fa-download mr-2"></i>
                                                Download Document
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-center mt-8">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-md">Submit Selection</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const questionCards = document.querySelectorAll('.question-card');
    const totalQuestions = questionCards.length;
    let currentIdx = 0;

    function showQuestion(idx) {
        questionCards.forEach((card, i) => {
            card.style.display = (i === idx) ? 'block' : 'none';
        });
        document.getElementById('gotoInput').value = idx + 1;
    }

    function clamp(val, min, max) {
        return Math.max(min, Math.min(max, val));
    }

    document.getElementById('firstBtn').onclick = function() {
        currentIdx = 0;
        showQuestion(currentIdx);
    };
    document.getElementById('lastBtn').onclick = function() {
        currentIdx = totalQuestions - 1;
        showQuestion(currentIdx);
    };
    document.getElementById('backwardBtn').onclick = function() {
        currentIdx = clamp(currentIdx - 5, 0, totalQuestions - 1);
        showQuestion(currentIdx);
    };
    document.getElementById('prevBtn').onclick = function() {
        currentIdx = clamp(currentIdx - 1, 0, totalQuestions - 1);
        showQuestion(currentIdx);
    };
    document.getElementById('nextBtn').onclick = function() {
        currentIdx = clamp(currentIdx + 1, 0, totalQuestions - 1);
        showQuestion(currentIdx);
    };
    document.getElementById('forwardBtn').onclick = function() {
        currentIdx = clamp(currentIdx + 5, 0, totalQuestions - 1);
        showQuestion(currentIdx);
    };
    document.getElementById('gotoBtn').onclick = function() {
        let val = parseInt(document.getElementById('gotoInput').value, 10);
        if (!isNaN(val)) {
            currentIdx = clamp(val - 1, 0, totalQuestions - 1);
            showQuestion(currentIdx);
        }
    };
    document.getElementById('gotoInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('gotoBtn').click();
        }
    });

    // Maintain checkbox state across navigation
    // (HTML form will submit all checked checkboxes regardless of visibility)

    // On page load, show the first question
    showQuestion(currentIdx);
</script>
@endpush

@endsection




all the duestions should be rendred by java script so wen can have a full access on the navigation betwen questions and filter the questions


i dont want you to show the question the image if exist and the options
fot the answse rno need you can just show a warning with download the question to get the full inforrmation or something like that


you can render the tyni information we have about the question like the difficulty the type ande more

the submit selection button should be  download selected question

and i want a counter for the selectedquestion
like 5 question selected

and like a message 1 credit for question

totcal credit 5 credit for the 5 question

a warning if the user doesnt have this amount of credit




after this i want you to creatae a modern ui design and user-friendly for this page using tailwind css and make sure the design is responsive and looks good on all devices

