<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Interests</title>
    @vite('resources/css/app.css')
    <style>
        .glow-border {
            box-shadow: 0 0 0 4px rgba(34, 193, 195, 0.5);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto my-8 p-4 bg-white rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center mb-6">Select Your Interests</h1>
        <form id="interest-form" action="/user/prefrences" method="POST">
            @csrf
            <div class="flex flex-wrap gap-4 mb-10">
                <!-- Category Item -->
                @foreach ($categories as $index => $category)
                    <div class="relative group flex-grow">
                        <div class="image-container">
                            <img src="https://images.unsplash.com/photo-1497681883844-82b4f0a359a4?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Category {{$index+1}}" class="w-full h-40 object-cover rounded-lg category-image" id="category{{$index+1}}">
                            <div class="absolute inset-0 rounded-lg bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <p class="text-white text-xl font-semibold">{{$category->name}}</p>
                                <input type="checkbox" name="categories[]" value="{{$category->id}}" class="absolute inset-0 opacity-0 cursor-pointer" onclick="toggleGlow(this, 'category{{$index+1}}')">
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <!-- Add more categories as needed -->
            </div>
            @error('perfrences')
                <p class="text-red-500 text-sm">{{$message}}</p>
            @enderror
            <div class="flex justify-center mt-8">
                <button type="button" onclick="nextPage()" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Next</button>
            </div>
        </form>
    </div>
    <script>
        function toggleGlow(checkbox, imageId) {
            const image = document.getElementById(imageId);
            if (checkbox.checked) {
                image.classList.add('glow-border');
            } else {
                image.classList.remove('glow-border');
            }
        }

        function nextPage() {
            document.getElementById('interest-form').submit();
        }
    </script>
</body>
</html>
