@component('layout')
<div class="bg-white overflow-y-auto p-8 mt-10 rounded-lg shadow-lg w-[60%]">
    <h1 class="text-3xl font-bold text-gray-700 mb-6">Create Quiz</h1>

    <form id="quizForm" action="/quiz/create" method="POST">
        @csrf
        <!-- Title and Description -->
        <div class="mb-6">
            <label for="quizTitle" class="block text-lg font-medium text-gray-700 mb-2">Quiz Title</label>
            <input type="text" name="title" id="quizTitle" placeholder="Enter quiz title" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-300 focus:border-indigo-500">
            <x-validationError error_name="title"/>
        </div>
        <div class="mb-6">
            <label for="quizDescription" class="block text-lg font-medium text-gray-700 mb-2">Description</label>
            <textarea id="quizDescription" name="description" rows="4" placeholder="Enter quiz description" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-300 focus:border-indigo-500"></textarea>
            <x-validationError error_name="description"/>
        </div>

        <!-- Question Components -->
        <div id="questionsContainer" class="space-y-6">
            <!-- Predefined components will be dynamically added here -->
        </div>

    </form>
</div>
<!-- Add Question Button -->
<div class="addQuestionsDiv fixed right-10 top-24 bg-white rounded-lg shadow-lg w-[28%] h-50 p-4">
    <div class=" space-y-4">
        <div class="options flex justify-between gap-4">
            <select class="" name="questionOptions" id="addQuestionOption">
                <option value="truefalse">True/False</option>
                <option value="mcq">MCQ</option>
                <option value="oneline">OneLine</option>
                <option value="multians">MultiAns</option>
            </select>
            <button type="button" id="addQuestionBtn"  class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Add Question
            </button>
        </div>
        <button type="submit" form="quizForm" id="submitQuizForm" class="w-full bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Create Quiz
        </button>
    </div>
</div>

@endcomponent
