@props(['title','duration','target'])
<div class="model flex justify-between items-center px-4 py-4 bg-gray-100">
    <h1 class="font-bold">{{$title}}</h1>
    <p class="text-sm flex items-center gap-2">
        {{$duration}} min
        {{$slot}}
    </p>
</div>