@component('layout')
<div class="quiz-container mt-10">
    <div class="text-white   overflow-y-auto m-auto p-8  w-[60%]">
        <h1 class="text-3xl font-bold text-black mb-2">{{$quiz->title}}</h1>

        <!-- Title and Description -->
        <div class="mb-6">
            <label for="quizTitle" class="block text-lg font-medium text-gray-500 mb-2">{{$quiz->des}}</label>

            @if($errors->any())
            {{ implode('', $errors->all('<div >:message</div>')) }}
        @endif
        </div>
        <!-- Questions -->

            <div class="max-w-3xl mx-auto bg-purpolis/70 shadow-md rounded-lg p-8">


                @foreach ($quiz->questions() as $index => $question)
                    <div class="mb-6">
                        <p class="text-lg font-semibold mb-4">{{ (int)$index + 1 }}. {{ $question['question']['question'] }}</p>
                        <div class="space-y-4">
                            @if ($question['type'] == 'mcq')
                                <!-- Single answer options like MCQ and True/False -->
                                @for ($i = 0; $i < 4; $i++)
                                    <input type="hidden" name="mcq[{{$index}}][id]" value="{{$question['question']['id']}}">
                                    <button type="button" class="w-full py-3 px-4 border border-gray-600 rounded-lg text-left {{$question['question']['ans'] == $i+1 ? 'bg-gray-700' : ''}} focus:outline-none" onclick="selectOption(this,'mcq[{{$i}}][radio]')"

                                     ><input type="radio" class="hidden" id="mcq[{{$i}}][radio]" name="mcq[{{$index}}][ans]" value="{{$i+1}}">

                                        {{ $question['question']['option'.($i+1)] }}
                                    </button>
                                    {{-- <input type="radio" id="mcq[{{$i}}][radio]" name="mcq[ans]" value="{{$i+1}}"> --}}
                                @endfor
                            @elseif ($question['type'] == 'multians')
                                @for ($i = 0; $i < 4; $i++)
                                <input type="hidden" name="multians[{{$index}}][id]" value="{{$question['question']['id']}}">
                                    <button type="button" class="w-full py-3 px-4 border border-gray-600 rounded-lg text-left hover:bg-gray-700 focus:outline-none" onclick="toggleOption(this)">
                                        <input type="checkbox" class="hidden" id="multians[{{$i}}][checkbox]" name="multians[{{$index}}][ans][]" value="{{$i+1}}">
                                        {{ $question['question']['option'.($i+1)] }}
                                    </button>
                                @endfor


                            @elseif ($question['type'] == 'oneline')

                                <!-- One-line text input -->
                                <input type="hidden" name="oneline[{{$index}}][id]" value="{{$question['question']['id']}}">
                                <input type="text" value="{{$question['question']['ans']}}" class="w-full py-3 px-4 border border-gray-600 rounded-lg bg-gray-900 text-gray-100 focus:outline-none" name="oneline[{{$index}}][ans]" placeholder="Your answer...">

                            @elseif ($question['type'] == 'truefalse')

                            <input type="hidden" name="truefalse[{{$index}}][id]" value="{{$question['question']['id']}}">
                                <button type="button" class="w-full py-3 px-4 border border-gray-600 rounded-lg text-left {{$question['question']['ans'] == '1' ? 'bg-gray-700' : ''}} focus:outline-none" onclick="selectOption(this)">
                                    <input type="radio" class="hidden" id="truefalse[radio]" name="truefalse[{{$index}}][ans]" value="true">
                                    True
                                </button>
                                <button type="button" class="w-full py-3 px-4 border border-gray-600 rounded-lg text-left {{$question['question']['ans'] == '0' ? 'bg-gray-700' : ''}} focus:outline-none" onclick="selectOption(this)">
                                    <input type="radio" class="hidden" id="truefalse[radio]" name="truefalse[{{$index}}][ans]" value="false">
                                    False
                                </button>
                            @endif

                        </div>
                    </div>
                @endforeach


            </div>



</div>
@endcomponent
