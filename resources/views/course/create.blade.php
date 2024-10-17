@component('layout')
    <div class="main flex gap-4">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-6">Create Course</h1>
            <form action="/course" method="POST" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif
                <!-- Course Information -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h2 class="text-2xl font-semibold mb-4">Course Information</h2>
                    <div class="mb-4 flex space-x-5">
                        <div class="title flex-grow">
                            <label class="block text-gray-700 font-bold mb-2">Course Title</label>
                            <input type="text" name="title" class="w-full border border-gray-300 p-2 rounded-lg"
                                placeholder="Course Title">
                            <x-validationError error_name="title"></x-validationError>
                        </div>
                        <div class="max_students">

                            <label class="block text-gray-700 font-bold mb-2">Max User Limit (optional)</label>
                            <input type="number" name="max_students" class="w-full border border-gray-300 p-2 rounded-lg"
                                placeholder="Users Limit..">
                                <x-validationError error_name="max_students"></x-validationError>
                        </div>
                        <div class="difficulty">
                            <label class="block text-gray-700 font-bold mb-2" for="difficulty">Difficulty</label>
                            <select name="difficulty" name="difficulty" id="difficulty"
                                class="w-full border border-gray-300 p-2 rounded-lg">
                                <option value="Easy">Easy</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>

                            </select>
                            <x-validationError error_name="difficulty"></x-validationError>
                        </div>
                        <div class="isfree flex items-center gap-5">
                            <input type="checkbox" name="isfree" value="true">
                            <label for="isfree" class="block text-gray-700 font-bold">Is Free</label>
                            <x-validationError error_name="isfree"></x-validationError>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <input type="text" name="description" class="w-full border border-gray-300 p-2 rounded-lg"
                            placeholder="Course Description">
                        <x-validationError error_name="description"></x-validationError>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">About</label>
                        <textarea name="about" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="About the Course"></textarea>
                        <x-validationError error_name="about"></x-validationError>
                    </div>
                    <div class="mb-4 grid grid-cols-4 space-x-5">
                        <div class="mb-4">
                            <label class="flex items-center gap-4 text-gray-700 font-bold mb-2">Current Price <p
                                    class="text-yellow-500 text-xs flex items-center" id="discount"></p></label>
                            <input id="currentPrice" type="number" name="cr_price"
                                class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Current Price">
                                <x-validationError error_name="cr_price"></x-validationError>
                            <p class="text-yellow-500 text-xs" id="discount"></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Estimated Price</label>
                            <input id="estimatedPrice" type="number" name="es_price"
                                class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Estimated Price">
                                <x-validationError error_name="es_price"></x-validationError>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Category</label>
                            {{-- <input type="text" class="w-full border border-gray-300 p-2 rounded-lg" placeholder="Estimated Price"> --}}
                            <select name="category" name="category" id="category"
                                class="w-full border border-gray-300 p-2 rounded-lg">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                            class="w-full border border-gray-300 p-2 rounded-lg" accept="image/*">
                            <x-validationError error_name="thumbnail_url"></x-validationError>
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
                {{-- <div class="quiz bg-white mb-4 shadow-md rounded-lg p-6">
                    <label for="" class="block text-gray-700 font-bold mb-2">Add Quiz</label>
                    <select name="quiz" id="" class="w-full border border-gray-300 p-2 rounded-lg">
                        @foreach ($quizzes as $quiz)
                            <option value="">{{$quiz->title}}</option>
                        @endforeach
                    </select>
                </div> --}}
                

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
