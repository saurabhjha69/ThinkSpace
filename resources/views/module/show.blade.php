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
        <div class="sidebar">
            <div
                class="sidebar-content sticky top-0 min-h-screen md:w-[300px] border-r border-gray-400 bg-gray-900 text-white">
                <div class="course-title p-5">
                    <h1 class="text-2xl">{{ $course->name }}</h1>
                </div>
                <div class="progress p-5">
                    <div class="progress-bar p-5 bg-blue-700/15 rounded-md">
                        <h1 class="text-xs mb-1 font-semibold">Your
                            Progress: {{$course->progress() ==100 ? 'completed' : $course->progress().'%'}}</h1>
                        <div class="bar relative w-full bg-blue-800/70 py-1 rounded-md">
                            <div class="percentage absolute left-0 top-0 py-1 w-{{ $course->progress() ==100 ? 'full' : '['.$course->progress().'%]' }} rounded-md bg-blue-500"></div>
                        </div>
                    </div>
                </div>
                <div class="modules">
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
                                    <div
                                        class="sub-module hover:bg-gray-400/15 transition-all duration-200 ease-in-out rounded-md p-3">
                                        <button type="button"
                                            onclick="loadNewVideo('{{ $submodule->video->public_id }}')"
                                            class="flex gap-3 items-center " parent="sub-modules{{ $moduleIndex }}">
                                            {{-- href="/course/{{$course->id}}/modules/submodule/{{$submodule->id}}" --}}
                                            <input type="checkbox" onchange="markAsComplete('{{$course->id}}','{{$module->id}}','{{$submodule->id}}','{{ Auth::user()->id }}')"
                                            {{$submodule->isMarkedCompleted() ? 'checked' : ''}}
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
        <div class="main flex-grow min-h-screen bg-gray-900/95 ">
            <div class="header h-16 border-b border-white/35 flex justify-between px-5">
                <div class="logo h-full place-content-center">
                    <img src="" alt="" class="object-cover h-10 w-10">
                </div>
                <div class="btn h-full place-content-center text-white">
                    @if (!$course->hasUserRated())
                        <button class="bg-blue-700/85 px-3 py-1 rounded-md" onclick="rateCourse()">
                            Rate Course
                        </button>
                    @endif
                </div>
            </div>

            <div class="container w-[70%] m-auto pt-14">
                <div class="videoplayer bg-black rounded-lg overflow-hidden">
                    <video id="video-player" controls autoplay class="h-[450px] w-full object-contain">


                    </video>

                </div>
            </div>
        </div>
    </div>


</body>

</html>
