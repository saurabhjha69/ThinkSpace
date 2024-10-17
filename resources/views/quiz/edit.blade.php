@component('layout')
<div class="bg-white overflow-y-auto p-8 rounded-lg shadow-lg w-[60%]">
    <h1 class="text-3xl font-bold text-gray-700 mb-6">Edit Quiz</h1>

    <!-- Title and Description -->
    <div class="mb-6">
        <label for="quizTitle" class="block text-lg font-medium text-gray-700 mb-2">Quiz Title</label>
        <input type="text" name="title" value="{{ $quiz->title }}" id="quizTitle"
            placeholder="Enter quiz title"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-300 focus:border-indigo-500">
    </div>
    <div class="mb-6">
        <label for="quizDescription" class="block text-lg font-medium text-gray-700 mb-2">Description</label>
        <textarea id="quizDescription" name="description" rows="4" placeholder="Enter quiz description"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-300 focus:border-indigo-500">{{ $quiz->des }}</textarea>
    </div>

    <!-- Question Components -->
    <div id="questionsContainer" class="space-y-6">
        @foreach ($quiz->mcqs as $mcqIndex => $mcq)
            <form action="/mcq/{{ $mcq->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" >
                    <label class="block flex justify-between text-lg font-medium text-gray-700 mb-2">Multiple Choice
                        (One Answer)
                        <div class="btn flex items-center">
                            <button class="text-red-700"
                                onclick="removeQuestion('mcq{{ $mcqIndex }}')"><x-svgs.delete></x-svgs.delete></button>
                            <button type="submit"
                                class=" bg-blue-500 text-white text-sm p-1 rounded-md ">Save</button>
                        </div>
                    </label>
                    <input type="text" value="{{ $mcq->question }}" name="question" placeholder="Enter question"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                    <div class="space-y-2">
                        <input type="text" value="{{ $mcq->option1 }}" name="option1" placeholder="Option 1"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" value="{{ $mcq->option2 }}" name="option2" placeholder="Option 2"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" value="{{ $mcq->option3 }}" name="option3" placeholder="Option 3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <input type="text" value="{{ $mcq->option4 }}" name="option4" placeholder="Option 4"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div class="mt-4">
                        <label for="mcq_correct" class="block text-sm font-medium text-gray-700">Correct Answer
                            (1-4)</label>
                        <input type="number" value="{{ $mcq->ans }}" name="ans" min="1"
                            max="4" placeholder="Enter correct option number"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        @error('fail')
                            <p class="text-red-500 text-xs">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </form>
        @endforeach
        @foreach ($quiz->multians as $multiansIndex => $multians)
            <form action="/multians/{{ $multians->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" >
                    <label class="block flex justify-between text-lg font-medium text-gray-700 mb-2">Multiple
                        Choice (Multiple Answers)
                        <div class="btn flex items-center">
                            <button class="text-red-700"
                                onclick="removeQuestion('multians{{ $multiansIndex }}')"><x-svgs.delete></x-svgs.delete></button>
                            <button type="submit"
                                class=" bg-blue-500 text-white text-sm p-1 rounded-md ">Save</button>
                        </div>
                    </label>
                    <input type="text" value="{{ $multians->question }}" name="question"
                        placeholder="Enter question"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="choice1" value="1"
                                @if ($multians->choice1 != null) checked @endif
                                class="form-checkbox text-indigo-500">
                            <span class="ml-2">Option 1</span>
                        </label>
                        <input type="text" value="{{ $multians->option1 }}" name="option1"
                            placeholder="Option 1"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="choice2" @if ($multians->choice2 != null) checked @endif
                                value="2" class="form-checkbox text-indigo-500">
                            <span class="ml-2">Option 2</span>
                        </label>
                        <input type="text" value="{{ $multians->option2 }}" name="option2"
                            placeholder="Option 2"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="choice3" @if ($multians->choice3 != null) checked @endif
                                value="3" class="form-checkbox text-indigo-500">
                            <span class="ml-2">Option 3</span>
                        </label>
                        <input type="text" value="{{ $multians->option3 }}" name="option3"
                            placeholder="Option 3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="choice4" @if ($multians->choice4 != null) checked @endif
                                value="4" class="form-checkbox text-indigo-500">
                            <span class="ml-2">Option 4</span>
                        </label>
                        <input type="text" value="{{ $multians->option4 }}" name="option4"
                            placeholder="Option 4" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        @error('choice')
                            <p class="text-red-500 text-xs">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </form>
        @endforeach

        @foreach ($quiz->onelines as $key => $oneline)
            <form action="/oneline/{{ $oneline->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" >
                    <label
                        class="block flex justify-between text-lg font-medium text-gray-700 mb-2">Question/Answer
                        <div class="btn flex items-center">
                            <button class="text-red-700"
                                onclick="removeQuestion('online{{ $key + 1 }}')"><x-svgs.delete></x-svgs.delete></button>
                            <button type="submit"
                                class=" bg-blue-500 text-white text-sm p-1 rounded-md ">Save</button>
                        </div>
                    </label>
                    <input type="text" value="{{ $oneline->question }}" name="question"
                        placeholder="Enter question"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                    <input type="text" value="{{ $oneline->ans }}" name="ans" placeholder="Enter answer"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
            </form>
        @endforeach

        @foreach ($quiz->truefalse as $key => $truefalse)
        <form action="/truefalse/{{$truefalse->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" >
                <label class="block flex justify-between text-lg font-medium text-gray-700 mb-2">True or False
                    <div class="btn flex items-center">
                        <button class="text-red-700" onclick="removeQuestion('truefalse{{ $key + 1 }}')"><x-svgs.delete></x-svgs.delete></button>
                        <button type="submit"  class=" bg-blue-500 text-white text-sm p-1 rounded-md ">Save</button>
                    </div>
                    </label>
                <input type="text" value="{{ $truefalse->question }}"
                    name="question" placeholder="Enter question"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="ans{{$key}}" value="1"
                        {{$truefalse->ans === 1 ? 'checked' : ''}} class="form-radio text-indigo-500">
                        <span class="ml-2">True</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="ans{{$key}}" value="0"
                        {{$truefalse->ans === 0 ? 'checked' : ''}}  class="form-radio text-indigo-500">
                        <span class="ml-2">False</span>
                    </label>
                </div>
            </div>
        </form>
        @endforeach
        <form id="quizForm" action="/quiz/edit/{{ $quiz->id }}" method="POST">
            @csrf
            @method('PUT')
            
            
        </form>
    </div>
</div>
<!-- Add Question Button -->
<div class="addQuestionsDiv fixed right-10 top-0 bg-white rounded-lg shadow-lg w-[30%] h-80 p-8">
    <div class=" space-y-4">
        <div class="options flex justify-between gap-3">
            
            <select class="border border-gray-700 rounded-md" name="questionOptions" id="addQuestionOption">
                <option value="truefalse">True/False</option>
                <option value="mcq">MCQ</option>
                <option value="oneline">OneLine</option>
                <option value="multians">MultiAns</option>
            </select>
            <button type="button" id="addQuestionBtn" page="edit"
                class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Add Question
            </button>
        </div>
        <button type="submit" form="quizForm" id="submitQuizForm"
            class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Save Changes
        </button>
    </div>
</div>


@endcomponent