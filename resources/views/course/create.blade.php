@component('layout')
    <div class="main flex gap-4">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-6">Create Course</h1>
            <form action="/course" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @if ($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }} --}}
                {{-- @endif --}}
                <!-- Course Information -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h2 class="text-2xl font-semibold mb-4">Course Information</h2>
                    <div class="mb-4 flex space-x-5">
                        <div class="title flex-grow">
                            <label class="block text-gray-700 font-bold mb-2">Course Title</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Course Title">
                            <x-validationError error_name="title"></x-validationError>
                        </div>
                        <div class="max_students">

                            <label class="block text-gray-700 font-bold mb-2">Max User Limit (optional)</label>
                            <input type="number" name="max_students" value="{{ old('max_students') }}"
                                class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Users Limit..">
                            <x-validationError error_name="max_students"></x-validationError>
                        </div>
                        <div class="difficulty">
                            <label class="block text-gray-700 font-bold mb-2" for="difficulty">Difficulty</label>
                            <select name="difficulty" name="difficulty" value="{{ old('difficulty') }}" id="difficulty"
                                class="w-full border border-gray-300 p-2 rounded-lg">
                                <option value="Easy">Easy</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>

                            </select>
                            <x-validationError error_name="difficulty"></x-validationError>
                        </div>
                        
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <input type="text" name="description" value="{{ old('description') }}"
                            class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Course Description">
                        <x-validationError error_name="description"></x-validationError>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">About</label>
                        <textarea name="about" value="{{ old('about') }}" class="w-full border border-gray-300 p-2 rounded-lg"
                            placeholder="About the Course"></textarea>
                        <x-validationError error_name="about"></x-validationError>
                    </div>
                    <div class="mb-4 grid grid-cols-4 space-x-5">
                        <div class="mb-4">
                            <label class="flex items-center gap-4 text-gray-700 font-bold mb-2">Current Price <p
                                    class="text-yellow-500 text-xs flex items-center" id="discount"></p></label>
                            <input id="currentPrice" type="number" value="{{ old('cr_price') }}" name="cr_price"
                                class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Current Price">
                            <x-validationError error_name="cr_price"></x-validationError>
                            <x-validationError error_name="min_price"></x-validationError>
                            <x-validationError error_name="max_price"></x-validationError>
                            <p class="text-yellow-500 text-xs" id="discount"></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Estimated Price</label>
                            <input id="estimatedPrice" type="number" name="es_price" value="{{ old('es_price') }}"
                                class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Estimated Price">
                            <x-validationError error_name="es_price"></x-validationError>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Category</label>
                            {{-- <input type="text" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Estimated Price"> --}}
                            <select name="category" name="category" id="category"
                                class="w-full border border-gray-300 p-2 rounded-lg" value="{{ old('category') }}">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}
                                        {{ $category?->categoryPrice ? '($' . $category?->categoryPrice?->min_price . '-$' . $category?->categoryPrice?->max_price . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <x-validationError error_name="category"></x-validationError>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="language">Language</label>
                            <select name="language" name="language" id="language"
                                class="w-full border border-gray-300 p-2 rounded-lg">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->name }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                            <x-validationError error_name="language"></x-validationError>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Thumbnail Upload</label>
                        <input type="file" id="thumbnailUpload" name="thumbnail_url"
                            value="{{ old('thumbnail_url') }}" class="w-full border border-gray-300 p-2 rounded-lg"
                            accept="image/*">
                        <x-validationError error_name="thumbnail_url"></x-validationError>
                        @if ($errors->any())
                            <p class="text-red-500">Please re-upload the file.</p>
                        @endif
                        <img id="thumbnailPreview" class="mt-4 hidden" src="" alt="Image Preview"
                            class="w-32 h-32 object-cover rounded-lg">
                    </div>
                    {{-- <button type="button" class="mb-4 bg-sky-400 rounded p-2 text-white" onclick="addIntro()">Add Intro</button> --}}
                    <div class="course_intro mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Intro Upload (Optional)</label>
                        <input type="file" id="introUpload" name="intro_url"
                            class="w-full border border-gray-300 p-2 rounded-lg" accept="video/*">
                        <x-validationError error_name="intro_url"></x-validationError>
                    </div>
                </div>
                <div class="quiz bg-white mb-4 shadow-md rounded-lg p-6">
                    <label for="" class="block text-gray-700 font-bold mb-2">Add Quiz</label>
                    @if ($quizzes->count() <= 0)
                    <label for="" class="block text-gray-700 font-bold mb-2">Either you havent created any Quiz or All Quizzes are associated with an Course</label>
                    <x-button href="/quiz" class="bg-purpolis">Click to Create New Quiz</x-button>
                    @else
                    <select name="quiz_id"  class="w-full border border-gray-300 p-2 rounded-lg">
                        @foreach ($quizzes as $quiz)
                            <option value="{{$quiz->id}}">{{$quiz->title}}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="p-6 bg-white shadow-md rounded-lg mb-7">
                    <h2 class="text-lg font-bold mb-4">Course Scheduling</h2>

                    <!-- Start Date and Time -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="start_datetime" class="block text-sm font-medium text-gray-700">Start Date &
                                Time</label>
                            <input type="datetime-local" id="start_datetime" name="start_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- End Date and Time -->
                        <div class="mb-4">
                            <label for="end_datetime" class="block text-sm font-medium text-gray-700">End Date &
                                Time</label>
                            <input type="datetime-local" id="end_datetime" name="end_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Schedule Date and Time -->
                    <div class="mb-4">
                        <label for="schedule_datetime" class="block text-sm font-medium text-gray-700">Schedule Date &
                            Time (optional)</label>
                        <input type="datetime-local" id="schedule_datetime" name="listing_date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Submit Button -->

                </div>




                <!-- Modules and Submodules -->
                <div class="bg-white mb-4 shadow-md rounded-lg p-6">
                    <h2 class="text-2xl font-semibold mb-4">Modules</h2>
                    <div class="modules">

                    </div>
                </div>
                <p class="addModule bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-4">Add Module</p>
                <input class="py-2 bg-primary px-4 text-white rounded-md cursor-pointer" type="submit" value="Submit">
            </form>
        </div>

    </div>
@endcomponent
