<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js');
    @vite('resources/js/quiz.js');
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <x-sidebar></x-sidebar>
    
    <div class="bg-transparent container relative ml-64 max-w-[calc(100%-16rem)] min-h-screen px-10 pb-20 overflow-x-hidden">
        {{$slot}}
        
    </div>
    
</body>
</html>