
<div class="bg-white overflow-y-auto p-8 rounded-lg shadow-lg w-[60%]">
    <h1 class="text-3xl font-bold text-gray-700 mb-6">{{$quiz->title}}</h1>

    <!-- Title and Description -->
    <div class="mb-6">
        <label for="quizTitle" class="block text-lg font-medium text-gray-700 mb-2">{{$quiz->des}}</label>
        
        @if($errors->any())
        {{ implode('', $errors->all('<div >:message</div>')) }}
    @endif
    </div>

    <!-- Question Components -->
    <form action="/attempt/quiz/{{$quiz->id}}" method="POST" id="quizAttemptForm">
        @csrf
        <div id="questionsContainer" class="space-y-6">
            @foreach ($quiz->mcqs as $key => $mcq)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" >
                        <label class="block flex justify-between text-lg font-medium text-gray-700 mb-2">Multiple Choice
                            (One Answer)
                            
                        </label>
                        <input type="text" value="{{ $mcq->question }}" name="mcq[{{$key+1}}][question]" placeholder="Enter question"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                            <input type="hidden" name="mcq[{{$key+1}}][id]" value="{{$mcq->id}}">
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
                            <input type="number"  name="mcq[{{$key+1}}][ans]" min="1" 
                                max="4" placeholder="Enter correct option number"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                
                            @error('fail')
                                <p class="text-red-500 text-xs">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
     
            @endforeach
            @foreach ($quiz->multians as $key => $multians)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" >
                        <label class="block flex justify-between text-lg font-medium text-gray-700 mb-2">Multiple
                            Choice (Multiple Answers)
                            \
                        </label>
                        <input type="text" value="{{ $multians->question }}" name="multians[{{$key+1}}][question]"
                            placeholder="Enter question"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                            <input type="hidden" name="multians[{{$key+1}}][id]" value="{{$multians->id}}">
                        <div class="space-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="multians[{{$key+1}}][choice1]" value="1"
                                
                                    class="form-checkbox text-indigo-500">
                                <span class="ml-2">Option 1</span>
                            </label>
                            <input type="text" value="{{ $multians->option1 }}" name="option1"
                                placeholder="Option 1"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="multians[{{$key+1}}][choice2]"
                                
                                    value="2" class="form-checkbox text-indigo-500">
                                <span class="ml-2">Option 2</span>
                            </label>
                            <input type="text" value="{{ $multians->option2 }}" name="option2"
                                placeholder="Option 2"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="multians[{{$key+1}}][choice3]" 
                              
                                    value="3" class="form-checkbox text-indigo-500">
                                <span class="ml-2">Option 3</span>
                            </label>
                            <input type="text" value="{{ $multians->option3 }}" name="option3"
                                placeholder="Option 3"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="multians[{{$key+1}}][choice4]" 
                               
                                    value="4" class="form-checkbox text-indigo-500">
                                <span class="ml-2">Option 4</span>
                            </label>
                            <input type="text" name="option4" value="{{ $multians->option4 }}"
                                placeholder="Option 4" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                
                            @error('choice')
                                <p class="text-red-500 text-xs">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
            @endforeach
    
            @foreach ($quiz->onelines as $key => $oneline)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" >
                        <label
                            class="block flex justify-between text-lg font-medium text-gray-700 mb-2">Question/Answer
                            
                        </label>
                        <input type="text" value="{{ $oneline->question }}" name="oneline[{{$key+1}}][question]"
                            placeholder="Enter question"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                            <input type="hidden" name="oneline[{{$key+1}}][id]" value="{{$oneline->id}}">
                        <input type="text"  name="oneline[{{$key+1}}][ans]" placeholder="Enter answer"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
            @endforeach
    
            @foreach ($quiz->truefalse as $key => $truefalse)
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200" >
                    <label class="block flex justify-between text-lg font-medium text-gray-700 mb-2">True or False
                        
                        </label>
                    <input type="text" value="{{ $truefalse->question }}"
                        name="truefalse[{{$key+1}}][question]" placeholder="Enter question"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                        <input type="hidden" name="truefalse[{{$key+1}}][id]" value="{{$truefalse->id}}">
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="truefalse[{{$key+1}}][ans]" value="1"
                          
                             class="form-radio text-indigo-500">
                            <span class="ml-2">True</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="truefalse[{{$key+1}}][ans]" value="0"
                            
                            class="form-radio text-indigo-500">
                            <span class="ml-2">False</span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </form>
</div>

<div class="addQuestionsDiv fixed right-10 top-0 bg-white rounded-lg shadow-lg w-[30%] h-80 p-8">
    <div >
        <button type="submit" form="quizAttemptForm" id="submitQuizAttemptForm"
            class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Submit Quiz
        </button>
    </div>
</div>


