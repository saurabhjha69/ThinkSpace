@props(['username','src','rating','comment'=> 'No Reviews','day'])
<div class="px-6 min-w-[30%] py-4 border border-gray-100 rounded-lg shadow-md">
    <div class="flex items-center">
        <!-- User Avatar -->
        <img class="w-12 h-12 rounded-full object-cover" src="{{$src}}" alt="User Avatar">
        <div class="ml-4">
            <p class="text-lg font-semibold text-gray-800">{{$username}}</p>
            <p class="text-sm text-gray-500">Reviewed {{$day}} days ago</p>
        </div>
    </div>

    <div class="mt-4">
        <x-ratings rating={{$rating}} />
        <p class="text-gray-700 mt-2">Rating: {{$rating}}/5</p>
    </div>

    <div class="mt-4">
        <p class="text-gray-600 text-sm">{{$comment}}</p>
    </div>
</div>
