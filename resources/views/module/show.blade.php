@props(['video_url' => null])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stream Course</title>

    @vite('resources/css/app.css')
    @vite('resources/js/videoplayer.js')
    @vite('resources/js/ratecourse.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dashjs/3.2.0/dash.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hls.js/1.0.0/hls.min.js"></script>
    <style>
        .star {
            cursor: pointer;
        }

        .star:hover,
        .star.selected {
            color: #fbbf24;
            /* Tailwind amber-400 */
        }
    </style>

</head>

<body>
    <x-sessions.success></x-sessions.success>
    <x-sessions.fail></x-sessions.fail>
    <div id="ratingModal" class="fixed inset-0 z-10 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white relative rounded-lg p-6 max-w-md w-full shadow-lg">
            <h2 class="text-lg font-bold mb-4">Rate this Course</h2>

            <!-- Star Rating -->
            <div class="flex mb-4">
                <span class="star text-gray-400 text-3xl" data-value="1">&#9733;</span>
                <span class="star text-gray-400 text-3xl" data-value="2">&#9733;</span>
                <span class="star text-gray-400 text-3xl" data-value="3">&#9733;</span>
                <span class="star text-gray-400 text-3xl" data-value="4">&#9733;</span>
                <span class="star text-gray-400 text-3xl" data-value="5">&#9733;</span>
            </div>

            <!-- Content (Optional) -->
            <textarea id="reviewContent" class="w-full p-2 border border-gray-300 rounded-lg mb-4" rows="4"
                placeholder="Leave your review (optional)"></textarea>

            <!-- Submit Button -->
            <button id="submitReview" onclick="submitReview('{{ $course->id }}','{{ Auth::user()->id }}')"
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Submit Review</button>

            <!-- Close Button -->
            <button id="closeModal" onclick="closeRateCourse()"
                class="absolute text-xl top-2 right-4 text-gray-400 hover:text-gray-600">&times;</button>
        </div>
    </div>
    <div class="main w-full flex overflow-y-auto">
        <div class="sidebar relative md:w-[300px]">
            <div
                class="sidebar-content fixed top-0 min-h-screen md:w-[300px] overflow-scroll border-r border-gray-400 bg-gray-900 text-white">
                <div class="course-title p-5">
                    <h1 class="text-2xl">{{ $course->name }}</h1>
                </div>
                <div class="progress p-5">
                    <div class="progress-bar p-5 bg-blue-700/15 rounded-md">
                        <h1 class="text-xs mb-1 font-semibold">Your
                            Progress: {{ $course->progress() == 100 ? 'completed' : $course->progress() . '%' }}</h1>
                        <div class="bar relative w-full bg-blue-800/70 py-1 rounded-md">
                            <div
                                class="percentage absolute left-0 top-0 py-1 w-{{ $course->progress() == 100 ? 'full' : '[' . $course->progress() . '%]' }} rounded-md bg-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modules" id="modules_container" default-module="{{ $defaultSubModule->id}}" is_completed={{isset($allCompleted) ? 'true' : 'false'}}>
                    @foreach ($modules->sortby('title') as $moduleIndex => $module)
                        <div class="module p-5">
                            <a href="#" class="flex justify-between items-center">
                                <div>
                                    <span class="text-xl font-semibold">{{ $module->title }}</span>
                                    <div class="duration flex items-center gap-1 text-gray-400 font-semibold ">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960"
                                            width="14px" fill="#9ca3af">
                                            <path
                                                d="M480-96q-79 0-149-30t-122.5-82.5Q156-261 126-331T96-480q0-80 30-149.5t82.5-122Q261-804 331-834t149-30q80 0 149.5 30t122 82.5Q804-699 834-629.5T864-480q0 27-3.5 53T850-376q-14-13-31-21t-36-10q5-18 7-36t2-37q0-130-91-221t-221-91q-130 0-221 91t-91 221q0 130 91 221t221 91q52 0 98.5-15.5T664-228q9 17 23 29t31 20q-49 39-109.5 61T480-96Zm288-144q-20 0-34-14t-14-34q0-20 14-34t34-14q20 0 34 14t14 34q0 20-14 34t-34 14Zm-154-70L444-480v-240h72v210l149 149-51 51Z" />
                                        </svg>
                                        <span class="text-[12px]">4min</span>
                                    </div>
                                </div>
                                <button type="button" onclick="toggleHidden('sub-modules{{ $moduleIndex }}')"
                                    class="dropdown text-sm down" target="module1">&#11206;</button>
                            </a>
                            <div class="sub-modules{{ $moduleIndex }} mt-4 space-y-1 font-light" id="module1">
                                @foreach ($module->submodules as $submodule)
                                    <div class="sub-module hover:bg-gray-400/15 transition-all duration-200 ease-in-out rounded-md p-3"
                                        id="submodule" hisId="{{ $submodule->id }}">
                                        <button type="button"
                                            onclick="loadNewVideo(['{{ $submodule->video->public_id }}','{{ $submodule->id }}'])"
                                            class="flex gap-3 items-center " parent="sub-modules{{ $moduleIndex }}">
                                            {{-- href="/course/{{$course->id}}/modules/submodule/{{$submodule->id}}" --}}
                                            <input type="checkbox"
                                                onchange="markAsComplete('{{ $submodule->id }}')"
                                                {{ $submodule->isMarkedCompleted() ? 'checked' : '' }}
                                                class="size-4 border border-white/25 rounded-md">
                                            <div class="leading-4 flex items-center gap-1">
                                                <svg class="flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                                    height="18px" viewBox="0 -960 960 960" width="18px"
                                                    fill="#9ca3af">
                                                    <path
                                                        d="M216-192q-29 0-50.5-21.5T144-264v-432q0-29.7 21.5-50.85Q187-768 216-768h432q29.7 0 50.85 21.15Q720-725.7 720-696v168l144-144v384L720-432v168q0 29-21.15 50.5T648-192H216Z" />
                                                </svg>
                                                <span>{{ $submodule->title }}</span>
                                            </div>
                                        </button>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    @endforeach



                </div>
                <div class="quizs">
                    @foreach ($course->quizzes as $quiz)
                        <a href="/course/watch/{{ $course->id }}/{{ $quiz->id }}">
                            <div class="flex items-center pl-7 gap-4">

                                <svg width="20px" height="20px" viewBox="0 0 16 16"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentcolor">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.75 4.48h-.71L2 3.43l.71-.7.69.68L4.81 2l.71.71-1.77 1.77zM6.99 3h8v1h-8V3zm0 3h8v1h-8V6zm8 3h-8v1h8V9zm-8 3h8v1h-8v-1zM3.04 7.48h.71l1.77-1.77-.71-.7L3.4 6.42l-.69-.69-.71.71 1.04 1.04zm.71 3.01h-.71L2 9.45l.71-.71.69.69 1.41-1.42.71.71-1.77 1.77zm-.71 3.01h.71l1.77-1.77-.71-.71-1.41 1.42-.69-.69-.71.7 1.04 1.05z">
                                        </path>
                                    </g>
                                </svg>
                                <div class="duration flex justify-between w-full text-gray-400 font-semibold ">
                                    <span class="text-sm">{{ $quiz->title }}</span>
                                    <span class="text-sm">{{ $quiz?->total_marks }} marks</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="btn-certificate-claim p-5">
                    <div class="btn  ">
                        <button disabled href="#"
                            class="w-full bg-blue-700/85 rounded-md place-content-center py-2 cursor-pointer">
                            <span>Complete And Claim Certificate...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="main flex-grow min-h-screen bg-gray-900 ">
            <div class="header h-16 border-b border-white/35 flex justify-between px-5">
                <div class="logo h-full place-content-center">
                    <img src="" alt="" class="object-cover h-10 w-10">
                </div>
                <div class="btn h-full place-content-center text-white flex items-center gap-4">
                    @can('approve_courses')
                        <div class="btn flex justify-center">

                            <a href="/approve-course/{{ $course->id }}"
                                class="cursor-pointer text-white px-4 py-1 rounded-md bg-purpolis">Review</a>
                        </div>
                    @endcan
                    @if (!$course->hasUserRated())
                        <button class="bg-blue-700/85 px-3 py-1 rounded-md" onclick="rateCourse()">
                            Rate Course
                        </button>
                    @endif
                </div>
            </div>
            @if (isset($questions) && count($questions) > 0 && $quiz->isAttemped()==false)
            {{-- {{dd($questions)}} --}}


                <div class="quiz-container">
                    <div class="text-white  overflow-y-auto m-auto p-8 rounded-lg shadow-lg w-[60%]">
                        <h1 class="text-3xl font-bold text-white mb-6">{{$quiz->title}}</h1>

                        <!-- Title and Description -->
                        <div class="mb-6">
                            <label for="quizTitle" class="block text-lg font-medium text-gray-500 mb-2">{{$quiz->des}}</label>

                            @if($errors->any())
                            {{ implode('', $errors->all('<div >:message</div>')) }}
                        @endif
                        </div>
                        <!-- Questions -->
                        <form action="/submit-quiz/{{$quiz->id}}" method="POST">
                            @csrf

                            <div class="max-w-3xl mx-auto bg-gray-800 shadow-md rounded-lg p-8">


                                @foreach ($questions as $index => $question)
                                    <div class="mb-6">
                                        <p class="text-lg font-semibold mb-4">{{ (int)$index + 1 }}. {{ $question['question']['question'] }}</p>
                                        <div class="space-y-4">
                                            @if ($question['type'] == 'mcq')
                                                <!-- Single answer options like MCQ and True/False -->
                                                @for ($i = 0; $i < 4; $i++)
                                                    <input type="hidden" name="mcq[{{$index}}][id]" value="{{$question['question']['id']}}">
                                                    <button type="button" class="w-full py-3 px-4 border border-gray-600 rounded-lg text-left hover:bg-gray-700 focus:outline-none" onclick="selectOption(this,'mcq[{{$i}}][radio]')"

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
                                                <input type="text" class="w-full py-3 px-4 border border-gray-600 rounded-lg bg-gray-900 text-gray-100 focus:outline-none" name="oneline[{{$index}}][ans]" placeholder="Your answer...">

                                            @elseif ($question['type'] == 'truefalse')
                                            <input type="hidden" name="truefalse[{{$index}}][id]" value="{{$question['question']['id']}}">
                                                <button type="button" class="w-full py-3 px-4 border border-gray-600 rounded-lg text-left hover:bg-gray-700 focus:outline-none" onclick="selectOption(this)">
                                                    <input type="radio" class="hidden" id="truefalse[radio]" name="truefalse[{{$index}}][ans]" value="true">
                                                    True
                                                </button>
                                                <button type="button" class="w-full py-3 px-4 border border-gray-600 rounded-lg text-left hover:bg-gray-700 focus:outline-none" onclick="selectOption(this)">
                                                    <input type="radio" class="hidden" id="truefalse[radio]" name="truefalse[{{$index}}][ans]" value="false">
                                                    False
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" id="quizSubmitBtn" class="py-3 px-8 bg-gray-600 hover:bg-gray-500 text-white rounded-lg focus:outline-none">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>


                </div>
            @elseif(isset($questions) && count($questions) > 0 && $quiz->isAttemped()==true)
            <div class="max-w-md mx-auto mt-10 p-6 border-2 border-gray-700 rounded-lg bg-gray-900 text-center">
                <h2 class="text-2xl font-bold text-white mb-4">Quiz Completed</h2>
                <p class="text-lg text-gray-400 mb-6">You have already completed this quiz.</p>

                <div class="mb-6">
                    <p class="text-lg font-semibold text-white">Your Score:
                        <span class="text-2xl font-bold">{{$quiz->userScore()}}</span>
                    </p>
                    <p class="text-lg font-semibold text-white">Total Correct Answers:
                        <span class="text-2xl font-bold">{{$quiz->userCorrectAttemptedAns()->total_correct_ans}}</span> /
                        <span class="text-xl text-gray-500">{{$quiz->userTotalAttemptedAns()->total_attempted_ans}}</span>
                    </p>
                </div>

                <button class="px-6 py-2 border-2 border-gray-500 text-white hover:bg-gray-700 hover:border-white transition-colors rounded-lg">
                    Go Back
                </button>
            </div>
            @else
            <div class="container w-[70%] m-auto  pt-14">
                <div class="videoplayer bg-black rounded-lg overflow-hidden">
                    <video id="video-player" controls autoplay class="h-[450px] w-full object-contain"
                        publicid="{{ isset($defaultSubModule) ? $defaultSubModule->video->public_id : $submodule->video->public_id }}">

                    </video>

                </div>
            </div>
            <div class="flex justify-center">
                <hr class="bg-gray-400 mt-10 w-[90%]">

            </div>


            <section class=" bg-gray-900 py-8 lg:py-16 antialiased">
                <div class="w-[70%] mx-auto px-4" id="comments-container">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg lg:text-2xl font-bold  text-white">Discussion ({{ $comments->count() }})
                        </h2>
                    </div>
                    <form class="mb-6" action="/comment/create" method="POST">
                        @csrf
                        <div class="py-2 px-4 mb-4  rounded-lg rounded-t-lg border  bg-gray-800 border-gray-700">
                            <label for="comment" class="sr-only">Your comment</label>

                            <input type="hidden" id="submodule_comment" name="submodule_id"
                                value="{{ isset($defaultSubModule) ? $defaultSubModule->id : $submodule->id }}">
                            <textarea id="comment" name="content" rows="6"
                                class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                placeholder="Write a comment..." required></textarea>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-black rounded-lg focus:ring-4 focus:ring-primary-200  hover:bg-primary-800">
                            Post comment
                        </button>
                    </form>


                    @foreach ($comments as $comment)
                        @if ($comment->parent_id == null)
                            <article class="p-6 text-base  rounded-lg bg-gray-900">

                                <footer class="flex justify-between items-center mb-2">
                                    <div class="flex items-center">
                                        <p
                                            class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                            @if ($comment->user->userinfo->profile_picture)
                                            <img class="{{$comment->user->userinfo->profile_picture}}">
                                            @endif
                                            {{'@'. $comment->user->username }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate
                                                datetime="2022-02-08"
                                                title="February 8th, 2022">{{ Illuminate\Support\Carbon::parse($comment->created_at) }}</time>
                                        </p>
                                        <h2 class="text-gray-400 text-xs ml-5">(On:
                                            <b>{{ $comment->submodule->title }}</b>)</h2>
                                    </div>

                                    <form action="/comment/delete/{{ $comment->id }}"
                                        id="delCommentForm{{ $comment->id }}" method="POST" hidden>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <div class="btns flex gap-2">
                                        <button type="submit" id="saveEditedCommentBtn{{ $comment->id }}"
                                            form="editCommentForm{{ $comment->id }}" class="text-gray-400 hidden"
                                            onclick="saveComment('comment_text{{ $comment->id }}')">
                                            Save
                                        </button>
                                        @if (Auth::id() == $comment->user_id)

                                        <button class="text-gray-400" id="editCommentBtn{{ $comment->id }}"
                                            onclick="editComment('comment_text','{{ $comment->id }}')">
                                            Edit
                                        </button>
                                        <button type="submit" form="delCommentForm{{ $comment->id }}"
                                            class="text-gray-400">
                                            <x-svgs.delete></x-svgs.delete>
                                        </button>
                                        @endif

                                    </div>
                                </footer>
                                <form action="/comment/edit/{{ $comment->id }}"
                                    id="editCommentForm{{ $comment->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="comment" id="comment_text{{ $comment->id }}"
                                        class="text-gray-400 bg-transparent w-full" value="{{ $comment->comment }}"
                                        disabled>
                                </form>
                                
                            </article>
                        @endif
                        @if ($comment->replies->count() > 0)
                            <article class="p-6 mb-3 ml-6 lg:ml-12 text-base bg-white rounded-lg dark:bg-gray-900">

                                <footer class="flex justify-between items-center mb-2">
                                    <div class="flex items-center">
                                        <p
                                            class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                            <img class="mr-2 w-6 h-6 rounded-full"
                                                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                                alt="Jese Leos">{{ $comment->user->username }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate
                                                datetime="2022-02-12"
                                                title="February 12th, 2022">{{ $comment->created_at }}</time></p>
                                    </div>

                                    <form action="/comment/delete/{{ $comment->id }}"
                                        id="delCommentForm{{ $comment->id }}" method="POST" hidden>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <div class="btns flex gap-2">
                                        <button type="submit" id="saveEditedCommentBtn{{ $comment->id }}"
                                            form="editCommentForm{{ $comment->id }}" class="text-gray-400 hidden"
                                            onclick="saveComment('comment_text{{ $comment->id }}')">
                                            Save
                                        </button>
                                        <button class="text-gray-400" id="editCommentBtn{{ $comment->id }}"
                                            onclick="editComment('comment_text','{{ $comment->id }}')">
                                            Edit
                                        </button>
                                        <button type="submit" form="delCommentForm{{ $comment->id }}"
                                            class="text-gray-400">
                                            <x-svgs.delete></x-svgs.delete>
                                        </button>

                                    </div>
                                </footer>
                                <form action="/comment/edit/{{ $comment->id }}"
                                    id="editCommentForm{{ $comment->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="comment" id="comment_text{{ $comment->id }}"
                                        class="text-gray-400 bg-transparent w-full" value="{{ $comment->comment }}"
                                        disabled>
                                </form>
                                <div class="flex items-center mt-4 space-x-4">
                                    <button type="button"
                                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                        <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
                                        </svg>
                                        Reply
                                    </button>
                                </div>
                            </article>
                        @endif
                    @endforeach


                </div>
            </section>
            @endif


        </div>
    </div>
    <script>
        // Function to select a single option for MCQs and True/False
        function selectOption(button,id) {
            // Remove selected class from all siblings
            const buttons = button.parentNode.children;
            for (let i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove('bg-gray-700', 'border-gray-400');

            }
            // Add selected class to clicked button
            button.classList.add('bg-gray-700', 'border-gray-400');
            button.children[0].checked = true;


        }

        // Function to toggle option for multiple correct answers
        function toggleOption(button) {
            button.classList.toggle('bg-gray-700');
            button.classList.toggle('border-gray-400');
            button.children[0].checked = !button.children[0].checked;
        }

    </script>


</body>

</html>
