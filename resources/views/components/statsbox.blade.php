@props(['value','topic'])
<div {{$attributes->merge(['class'=>'tabs h-32 w-56 rounded-2xl text-purpolis bg-white border hover:border-[#925fe2] transition-all ease-in-out duration-500  place-content-center shadow-sm'])}}>
    <h1 class="text-5xl text-center font-extrabold">{{$value}}</h1>
    <h5 class="text-center
    ">{{$topic}}</h5>
</div>