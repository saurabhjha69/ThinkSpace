<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Course Form</title>
    @vite('resources/css/app.css')
</head>
<body>

    <form action="/course/create" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div id="modules" class="space-y-4">
            <!-- Dynamically added modules will go here -->
        </div>
    
        <button type="button" onclick="addModule()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Add Module
        </button>
    
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            Submit
        </button>
    </form>
    
    <script>
        let moduleCount = 0;
    
        function addModule() {
            moduleCount++;
            const moduleTemplate = `
                <div id="module-${moduleCount}" class="border border-gray-300 p-4 rounded space-y-4">
                    <h3 class="text-lg font-semibold">Module ${moduleCount}</h3>
                    <input type="text" name="modules[${moduleCount}][title]" placeholder="Module Title" required 
                           class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
    
                    <div id="submodules-${moduleCount}" class="space-y-2">
                        <!-- Submodules for this module will go here -->
                    </div>
    
                    <button type="button" onclick="addSubmodule(${moduleCount})" 
                            class="bg-blue-400 text-black px-3 py-1 rounded hover:bg-yellow-600 transition">
                        Add Submodule
                    </button>
    
                    <input type="file" name="modules[${moduleCount}][file]" required 
                           class="block w-full text-gray-700 bg-white border border-gray-300 rounded p-2 focus:outline-none focus:border-blue-500">
    
                    <button type="button" onclick="removeModule(${moduleCount})" 
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                        Remove Module
                    </button>
                </div>
            `;
            document.getElementById('modules').insertAdjacentHTML('beforeend', moduleTemplate);
        }
    
        function addSubmodule(moduleId) {
            const submoduleCount = document.querySelectorAll(`#module-${moduleId} .submodule`).length + 1;
            const submoduleTemplate = `
                <div class="submodule border-l-4 border-blue-300 pl-4 space-y-2">
                    <h4 class="text-md font-medium">Submodule ${submoduleCount}</h4>
                    <input type="text" name="modules[${moduleId}][submodules][${submoduleCount}][title]" placeholder="Submodule Title" required 
                           class="w-full p-2 border border-gray-300 rounded focus:ring focus:ring-blue-300">
                    <input type="file" name="modules[${moduleId}][submodules][${submoduleCount}][file]" required 
                           class="block w-full text-gray-700 bg-white border border-gray-300 rounded p-2 focus:outline-none focus:border-blue-500">
    
                    <button type="button" onclick="removeSubmodule(this)" 
                            class="bg-red-400 text-white px-3 py-1 rounded hover:bg-red-500 transition">
                        Remove Submodule
                    </button>
                </div>
            `;
            document.getElementById(`submodules-${moduleId}`).insertAdjacentHTML('beforeend', submoduleTemplate);
        }
    
        function removeModule(moduleId) {
            document.getElementById(`module-${moduleId}`).remove();
        }
    
        function removeSubmodule(button) {
            button.parentElement.remove();
        }
    </script>
        
    
</body>
</html>