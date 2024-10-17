<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Modules</title>
    @vite('resources/css/app.css')
    @vite('resources/js/module.js')
</head>

<body class="bg-gray-100 p-6 space-y-2">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <path
                        d="M14.348 14.849a1 1 0 01-1.414 0L10 11.415l-2.935 2.934a1 1 0 11-1.414-1.414L8.586 10 5.651 7.065a1 1 0 011.414-1.414L10 8.586l2.934-2.935a1 1 0 111.414 1.414L11.415 10l2.933 2.934a1 1 0 010 1.415z" />
                </svg>
            </span>
        </div>
    @endif

    @if (session('fail'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('ratingfail') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <path
                        d="M14.348 14.849a1 1 0 01-1.414 0L10 11.415l-2.935 2.934a1 1 0 11-1.414-1.414L8.586 10 5.651 7.065a1 1 0 011.414-1.414L10 8.586l2.934-2.935a1 1 0 111.414 1.414L11.415 10l2.933 2.934a1 1 0 010 1.415z" />
                </svg>
            </span>
        </div>
    @endif
    <div class="tile max-w-5xl mx-auto bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold p-2 px-8">{{ $course->name }}</h1>
    </div>
    <div class="modules max-w-5xl mx-auto bg-white rounded-lg shadow-md divide-y-2">
        @foreach ($course->modules->sortBy('order') as $key => $module)
            <div class="module1 relative p-8 flex items-center justify-between">
                <div class="blueline absolute bg-blue-500 h-[90%] w-2 rounded-l-sm left-1"></div>
                <div class="moduleid absolute top-2">
                    <span>Module {{ $key + 1 }}</span>
                </div>
                <h2 class="text-2xl font-semibold mb-6">{{ $module->title }} </h2>
                <div class="tools flex ">
                    <a href="/modules/{{ $module->id }}">
                        <x-svgs.edit></x-svgs.edit>
                    </a>
                    <button type="submit" onclick="deleteModule('{{$course->id}}','{{$module->id}}')">
                        <x-svgs.delete></x-svgs.delete>
                    </button>
                </div>
                <div class="submodules absolute bottom-2 flex gap-3">
                    @foreach ($module->submodules->sortBy('order') as $submodule)
                        <span
                            class="border border-gray-300 bg-gray-200 rounded-md px-4 py-1 text-xs">{{ $submodule->title }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach


    </div>
    <form class="max-w-5xl mx-auto bg-white rounded-lg shadow-md divide-y-2"  action="/course/modules/add" method="POST"
        id="modules" count={{ $course->modules->count() }}>
        @csrf

        <input type="hidden" name="course_id" value="{{ $course->id }}">

    </form>
    <div class="btn max-w-5xl mx-auto bg-transparent rounded-lg flex justify-between">
        <button type="button" counter="0" onclick="addModule()" id="add-submodule"
            class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Add Module
        </button>
        <button type="submit" form="modules" id="moduleSubmitBtn"
            class="mt-4 border border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white hidden">Save</button>
    </div>
</body>

</html>
