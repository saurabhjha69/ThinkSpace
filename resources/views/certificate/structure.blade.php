<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')
    <style>
        @media print {
            @page {
                margin: 0;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white border-8 border-yellow-500 w-[800px] h-auto pt-5 pb-10 px-10 text-center relative">
        <div class="logo">
            <img src="{{$logo}}" class="w-28 object-cover m-auto mb-10" alt="Logo">
        </div>

        <!-- Certificate Title -->
        <h1 class="text-4xl font-bold text-gray-800">CERTIFICATE OF COMPLETION</h1>

        <!-- Subtitle -->
        <p class="mt-8 text-sm font-semibold text-gray-700">This certifies that</p>

        <!-- User's Name -->
        <h2 class="mt-4 text-3xl font-bold text-gray-800">{{ $user->username }}</h2>

        <!-- Course Name and Certificate Description -->
        <div>
            <p class="w-[80%] m-auto mt-8 text-sm font-semibold text-gray-700 leading-8">
                has completed the necessary courses of {{ $course->name }} and is hereby declared a
            </p>
        </div>

        <!-- Certification Title -->
        <h2 class="mt-4 text-2xl font-bold text-gray-800">Certified {{ $course->category_id }} Developer</h2>

        <p class="mt-6 text-sm text-gray-700 font-semibold">
            with fundamental knowledge of web development using HTML5.
        </p>

        <!-- Issue Date -->
        <p class="mt-4 text-xs font-bold underline text-gray-700">
            Issued: {{ $date }}
        </p>

        <!-- Signatory Section -->
        <div class="mt-20 text-end">
            <div class="sign relative">
                <img src="{{$sign}}" class="absolute right-8 bottom-0 w-20" alt="Signature">
            </div>
            <h3 class="text-sm font-semibold">{{$course->user->name}}</h3>
            <p class="text-xs text-gray-600">For W3Schools.com</p>
        </div>
    </div>

</body>
</html>
