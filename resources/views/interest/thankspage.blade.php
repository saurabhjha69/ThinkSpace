<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto my-8 p-4 bg-white rounded-lg shadow-lg text-center">
        <h1 class="text-2xl font-semibold mb-6">Thank You! {{$username}}</h1>
        <p class="text-lg mb-4">Your interests have been successfully saved.</p>
        <a href="/dash" class="text-blue-500 hover:underline">Go to Homepage</a>
    </div>
</body>
</html>
