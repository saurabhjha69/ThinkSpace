<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    @vite('resources/css/app.css')
    <script>
        // Function to preview selected image
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('thumbnail-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Function to preview selected video
        function previewVideo(event, previewId) {
            const video = document.getElementById(previewId);
            console.log(video);
            video.src = URL.createObjectURL(event.target.files[0]);
            video.load();
        }

        // Function to show module details
    </script>
</head>

<body class="bg-gray-100 p-6 space-y-2">
    <div class="max-w-5xl mx-auto bg-white shadow-md p-8 rounded-lg">
        <!-- Course Edit Form -->
        <h2 class="text-2xl font-semibold mb-6">Edit Course</h2>
        @if ($errors->any())
            {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
        <form class="space-y-4" action="/course/edit/{{ $course->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-2">
                <!-- Thumbnail Image -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700">Thumbnail Image</label>
                    <input class="absolute -translate-x-[50%] -translate-y-[50%] top-1/2 left-1/2 text-xs"
                        name="thumbnail_url" type="file" accept="image/*" class="mt-2"
                        onchange="previewImage(event)">
                    <img id="thumbnail-preview" src="{{ $course->thumbnail_url }}" alt="Thumbnail Preview"
                        class="mt-4 w-74 h-48 object-cover">
                </div>
                <div>
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" class="w-full mt-1 p-2 border rounded" name="name"
                            value="{{ $course->name }}" placeholder="Course Title">
                    </div>
                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea class="w-full mt-1 p-2 border rounded" name="description" rows="4" placeholder="Course Description">{{ $course->description }}
                        </textarea>
                    </div>
                </div>
            </div>
            <!-- About -->
            <div>
                <label class="block text-sm font-medium text-gray-700">About</label>
                <textarea class="w-full mt-1 p-2 border rounded" name="about" rows="4" placeholder="About the Course">{{ $course->about }}</textarea>
            </div>
            <!-- Category -->
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select class="w-full mt-1 p-2 border rounded" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Is Free -->
                <div class="flex justify-between">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Is Free</label>
                        <input type="checkbox" name="is_free" value=1 class="mt-1 p-2 border rounded"
                            {{ $course->is_free ? 'checked' : '' }}>

                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max Students</label>
                        <input type="text" name="max_students" value="{{ $course->max_students }}"
                            class="w-full mt-1 p-2 border rounded" placeholder="Max Students">
                    </div>
                </div>

                <!-- Language -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Language</label>
                    <input type="text" name="language" value="{{ $course->language }}"
                        class="w-full mt-1 p-2 border rounded" placeholder="Language">
                </div>

                <!-- Difficulty -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Difficulty</label>
                    <select class="w-full mt-1 p-2 border rounded" name="difficulty">
                        <option value="easy" {{ $course->difficulty === 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="intermediate" {{ $course->difficulty === 'intermediate' ? 'selected' : '' }}>
                            Intermediate</option>
                        <option value="advanced" {{ $course->difficulty === 'advance' ? 'selected' : '' }}>Advance
                        </option>

                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" class="w-full mt-1 p-2 border rounded"
                        value="{{ $course->price }}" placeholder="Course Price">
                </div>

                <!-- Estimated Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estimated Price</label>
                    <input type="number" name="est_price" class="w-full mt-1 p-2 border rounded"
                        value="{{ $course->est_price }}" placeholder="Estimated Price">
                </div>
            </div>

            @if ($course->introvideo)
                <div class="intro">
                    <div class="flex justify-around">
                        <label class="block text-sm font-medium text-gray-700 mb-2 ">Intro</label>
                        <input class="text-xs" name="intro_url" type="file" accept="video/*" class="mt-2"
                            onchange="previewVideo(event,'intro_video')">
                    </div>
                    <video id="intro_video" controls width="700px" class=" mx-auto">
                        <source src="{{ $course->introvideo?->url }}" type="video/mp4">
                    </video>

                </div>
            @endif

            <button class="w-full bg-blue-600 text-white p-2 rounded mt-4">Save Changes</button>
        </form>

    </div>
    <div class="btn flex justify-center">
        <a href="/course/{{$course->id}}/modules" class=" border border-blue-500 rounded-md px-6 py-1">View Modules</a>
    </div>
    
</body>

</html>
