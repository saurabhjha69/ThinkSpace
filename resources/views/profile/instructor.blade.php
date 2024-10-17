<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instructor - profile</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container w-full mx-auto p-4">
        <div class="main-body w-full ">
            <div class="p-4 w-full divide-y-8 divide-gray-100">
                <div class="flex flex-col pb-5 p-5 bg-white items-center text-center rounded-lg shadow">
                    <img src="{{$user->userinfo->profile_picture}}" id="editProfilePicturePreview"
                        class="w-40 h-40 object-cover rounded-full border-2 border-purpolis" alt="avatar" >

                    <div class="mt-3">
                        <h4 class="text-lg font-semibold">{{ $user->fullname() }}</h4>
                        <p class="text-gray-500 mb-1">{{$user->userinfo?->education}}</p>
                        <p class="text-gray-400 text-sm mb-2">{{$user->userinfo?->address}}</p>
                        <p class="text-gray-400 mx-auto w-2/3 text-sm mb-2">{{$user->userinfo?->bio}}</p>
                        @can('edit_profile', $user)

                            <div class="editbtn flex justify-end pr-10">
                                <a href="/profile/edit" class=" border border-primary text-primary py-1 px-3 rounded mt-2">Edit</a>
                            </div>
                        @endcan

                    </div>
                </div>


            </div>

        </div>
    </div>
    <div class="courses mx-auto w-4/5 flex gap-10 mb-10 flex-wrap">
        @foreach ($courses as $course)
        <div class="relative w-[350px] flex px-4 flex-col overflow-hidden rounded-2xl border hover:border-purpolis transition-all duration-200 ease-in-out bg-white shadow-md">
            <a class="relative mt-3 flex h-40 overflow-hidden rounded-xl" href="#">
            <img class="object-cover h-full w-full" src="{{$course->thumbnail_url}}" alt="product image" />
            <span class="absolute top-0 left-0 m-2 rounded-full bg-black px-2 text-center text-sm font-medium text-white">{{$course->calcDiscount($course)}}% OFF</span>
            </a>
            <div class="mt-2 pb-3">
            <a href="#">
                <h5 class="text-xl tracking-tight text-slate-900">{{Str::upper($course->name)}}</h5>
            </a>
            <div class=" mb-2 flex items-center justify-between">
                <p>
                <span class="text-3xl font-bold text-slate-900">${{$course->price}}</span>
                <span class="text-sm text-slate-900 line-through">${{$course->est_price}}</span>
                </p>
                <div class="flex items-center">
                <x-ratings rating="{{$course->averageRating()}}"></x-ratings>
                <span class="mr-2 ml-3 rounded bg-yellow-200 px-2.5 py-0.5 text-xs font-semibold">{{$course->averageRating()}}</span>
                </div>
            </div>
            <a href="/course/{{$course->id}}" class="flex items-center justify-center rounded-md bg-purpolis px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Explore it..</a>
            </div>
        </div>
    @endforeach
    </div>

</body>
</html>
