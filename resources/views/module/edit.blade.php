<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Modules</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Course Modules</h1>

        <form action="/modules/edit/{{$module->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Module Section -->
            <div id="module-section">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Module Title</h2>
                    <input type="text" name="module_title" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter module title" value="{{$module->title}}">
                    <input type="hidden" name="category_id" value="{{$module->course->category_id}}">
                </div>
    
                <!-- Submodule Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-600 mb-4">Submodules</h3>
                    
                    <div id="submodule-list" count={{$module->submodules->count()}}>
                        @foreach ($module->submodules->sortBy('order') as $key => $submodule)
                        <!-- Submodule Template -->
                        
                        <div class="submodule px-4 rounded-md mb-4 relative">
                            <div class="blueline absolute bg-blue-500 h-[100%] w-2 rounded-l-sm left-0"></div>
                            <input type="hidden" name="submodule[{{$submodule->order}}][id]" value="{{$submodule->id}}">
                            <label class="block text-gray-700 mt-2">Title:</label>
                            <input type="text" name="submodule[{{$submodule->order}}][title]" value="{{$submodule->title}}" class="w-full p-2 border border-gray-300 rounded mb-2" placeholder="Enter submodule title">
    
                            <label class="block text-gray-700">Video:</label>
                            <input type="file" name="submodule[{{$submodule->order}}][file]" class="w-full p-2 border border-gray-300 rounded"  value="null" onchange="previewVideo(event,'video{{$submodule->order}}')">
                            <video id="video{{$submodule->order}}" controls class=" mx-auto">
                                <source src="{{$submodule->video?->url}}"  type="video/mp4">
                            </video>
                        </div>
                        <!-- End of Submodule Template -->
                        @endforeach
                    </div>
    
                    <!-- Add Submodule Button -->
                    <button type="button" id="add-submodule" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        + Add Submodule
                    </button>
                </div>
            </div>
    
            <!-- Save Changes Button -->
            <button type="submit" class="mt-6 bg-green-500 text-white px-6 py-3 rounded hover:bg-green-600">
                Save Changes
            </button>
        </form>
    </div>

    <script>
        function previewVideo(event, previewId) {
            const video = document.getElementById(previewId);
            console.log(video);
            video.src = URL.createObjectURL(event.target.files[0]);
            video.load();
        }

        document.getElementById('add-submodule').addEventListener('click', function() {
            const submoduleList = document.getElementById('submodule-list');
            const submoduleCount = parseInt(submoduleList.getAttribute('count'));
            console.log(submoduleCount);

            const newSubmodule = `
            
                <div class="submodule relative px-4 rounded-md mb-4">
                    <div class="blueline absolute bg-blue-500 h-[100%] w-2 rounded-l-sm left-0"></div>
                    <label class="block text-gray-700 mt-2">Title:</label>
                    <input type="text" name="submodule[${submoduleCount+1}][title]" class="w-full p-2 border border-gray-300 rounded mb-2" placeholder="Enter submodule title">

                    <input type="file" name="submodule[${submoduleCount+1}][file]" class="w-full p-2 border border-gray-300 rounded" onchange="previewVideo(event,'video${submoduleCount+1}')">
                    <video id="video${submoduleCount+1}" controls class=" mx-auto">
                        <source src=""  type="video/mp4">
                    </video>
                </div>
            `;

            submoduleList.insertAdjacentHTML('beforeend', newSubmodule);
            submoduleList.setAttribute('count',submoduleCount+1);
        });
    </script>
</body>
</html>
