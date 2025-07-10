@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Question</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.questions.show', $question) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-eye mr-2"></i>View
            </a>
            <a href="{{ route('admin.questions.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Back to Questions
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Question Text -->
            <div class="mb-6">
                <label for="question" class="block text-sm font-medium text-gray-700 mb-2">Question Text *</label>
                <textarea name="question" id="question" rows="4" 
                          class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter the question text..." required>{{ old('question', $question->question) }}</textarea>
            </div>

            <!-- Options -->
            <div class="mb-6">
                <label for="options" class="block text-sm font-medium text-gray-700 mb-2">Options *</label>
                <textarea name="options" id="options" rows="3" 
                          class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter the answer options..." required>{{ old('options', $question->options) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Enter the possible answer options</p>
            </div>

            <!-- Answer -->
            <div class="mb-6">
                <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">Correct Answer *</label>
                <input type="text" name="answer" id="answer" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter the correct answer..." value="{{ old('answer', $question->answer) }}" required>
            </div>

            <!-- Row 1: Difficulty, Question Type, Education Level -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty *</label>
                    <select name="difficulty" id="difficulty" 
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select Difficulty</option>
                        <option value="easy" {{ old('difficulty', $question->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ old('difficulty', $question->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ old('difficulty', $question->difficulty) == 'hard' ? 'selected' : '' }}>Hard</option>
                    </select>
                </div>

                <div>
                    <label for="question_type" class="block text-sm font-medium text-gray-700 mb-2">Question Type *</label>
                    <select name="question_type" id="question_type" 
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select Type</option>
                        <option value="Multiple Choice" {{ old('question_type', $question->question_type) == 'Multiple Choice' ? 'selected' : '' }}>Multiple Choice</option>
                        <option value="True/False" {{ old('question_type', $question->question_type) == 'True/False' ? 'selected' : '' }}>True/False</option>
                        <option value="Open Ended" {{ old('question_type', $question->question_type) == 'Open Ended' ? 'selected' : '' }}>Open Ended</option>
                        <option value="Fill in the Blank" {{ old('question_type', $question->question_type) == 'Fill in the Blank' ? 'selected' : '' }}>Fill in the Blank</option>
                    </select>
                </div>

                <div>
                    <label for="education_level" class="block text-sm font-medium text-gray-700 mb-2">Education Level *</label>
                    <select name="education_level" id="education_level" 
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select Level</option>
                        <option value="Elementary" {{ old('education_level', $question->education_level) == 'Elementary' ? 'selected' : '' }}>Elementary</option>
                        <option value="Middle School" {{ old('education_level', $question->education_level) == 'Middle School' ? 'selected' : '' }}>Middle School</option>
                        <option value="High School" {{ old('education_level', $question->education_level) == 'High School' ? 'selected' : '' }}>High School</option>
                        <option value="University" {{ old('education_level', $question->education_level) == 'University' ? 'selected' : '' }}>University</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Institution, Source, Year -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">Institution *</label>
                    <input type="text" name="institution" id="institution" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Institution name..." value="{{ old('institution', $question->institution) }}" required>
                </div>

                <div>
                    <label for="source" class="block text-sm font-medium text-gray-700 mb-2">Source *</label>
                    <input type="text" name="source" id="source" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Source..." value="{{ old('source', $question->source) }}" required>
                </div>

                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Year *</label>
                    <input type="number" name="year" id="year" min="1900" max="{{ date('Y') }}"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Year..." value="{{ old('year', $question->year) }}" required>
                </div>
            </div>

            <!-- Row 3: Region, UF -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700 mb-2">Region *</label>
                    <input type="text" name="region" id="region" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Region..." value="{{ old('region', $question->region) }}" required>
                </div>

                <div>
                    <label for="uf" class="block text-sm font-medium text-gray-700 mb-2">State Code (UF) *</label>
                    <input type="text" name="uf" id="uf" maxlength="2" 
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="SP, RJ, MG..." value="{{ old('uf', $question->uf) }}" required>
                    <p class="text-sm text-gray-500 mt-1">2-letter Brazilian state code</p>
                </div>
            </div>

            <!-- Current Files -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Current Image -->
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Current Files</h4>
                    @if($question->image)
                        <div class="border border-gray-200 rounded-lg p-3 mb-3">
                            <p class="text-xs text-gray-700 font-medium">Image: {{ basename($question->image) }}</p>
                        </div>
                    @endif
                    @if($question->doc)
                        <div class="border border-gray-200 rounded-lg p-3 mb-3">
                            <p class="text-xs text-gray-700 font-medium">Document: {{ basename($question->doc) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- File Uploads -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Image Upload (Optional) -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $question->image ? 'Replace Image (Optional)' : 'Add Image (Optional)' }}
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Supported: JPG, PNG, GIF (max 2MB)</p>
                </div>

                <!-- Document Upload (Optional for edit) -->
                <div>
                    <label for="doc" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $question->doc ? 'Replace Document (Optional)' : 'Add Document (Optional)' }}
                    </label>
                    <input type="file" name="doc" id="doc" accept=".doc,.docx"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Supported: DOC or DOCX file (max 10MB)</p>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.questions.show', $question) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancel
                </a>
                <button type="submit" id="submitBtn"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Update Question
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        
        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
    });
});
</script>
@endsection