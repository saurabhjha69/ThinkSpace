<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Course - Ratings</title>
    @vite('resources/css/app.css')
</head>
<body class="w-full">
    <div class="coursed-details w-4/5 py-10 mx-auto">
        <h1 class="text-2xl">{{$course->name}}</h1>
        <h1>Ratings</h1>
    </div>
    <div class="ratings mx-auto w-4/5 grid grid-cols-3 gap-7 ">
        @foreach ($ratings as $rating)

            <x-userratingbox src="#" username="{{$rating->user->username}}" rating="{{$rating->stars}}" day="4" comment="{{$rating->comment}}"/>
        @endforeach
    </div>
    
</body>
</html>
