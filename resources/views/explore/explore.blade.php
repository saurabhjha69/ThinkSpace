@component('layout')
<div class="course-div grid grid-cols-3 gap-5">
    @foreach ($courses as $course)
        <div class="relative m-10 w-96 flex px-4 flex-col overflow-hidden rounded-lg border border-gray-100 bg-white shadow-md">
            <a class="relative mt-3 flex h-40 overflow-hidden rounded-xl" href="#">
            <img class="object-cover h-full w-full" src="{{$course->thumbnail_url}}" alt="product image" />
            <span class="absolute top-0 left-0 m-2 rounded-full bg-black px-2 text-center text-sm font-medium text-white">{{$course->calcDiscount($course)}}% OFF</span>
            </a>
            <div class="mt-4 pb-5">
            <a href="#">
                <h5 class="text-xl tracking-tight text-slate-900">{{Str::upper($course->name)}}</h5>
            </a>
            <div class="mt-2 mb-5 flex items-center justify-between">
                <p>
                <span class="text-3xl font-bold text-slate-900">${{$course->price}}</span>
                <span class="text-sm text-slate-900 line-through">${{$course->est_price}}</span>
                </p>
                <div class="flex items-center">
                <x-ratings rating="{{$course->averageRating()}}"></x-ratings>
                <span class="mr-2 ml-3 rounded bg-yellow-200 px-2.5 py-0.5 text-xs font-semibold">{{$course->averageRating()}}</span>
                </div>
            </div>
            <a href="/course/{{$course->id}}" class="flex items-center justify-center rounded-md bg-slate-900 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Explore it..</a>
            </div>
        </div>
    @endforeach
</div>
  
@endcomponent