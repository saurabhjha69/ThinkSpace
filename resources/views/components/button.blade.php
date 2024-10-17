@props(['href'])
<a href="{{$href}}" {{$attributes->merge(['class'=>'py-1 px-2 text-center bg-primary text-white rounded-md'])}}>{{$slot}}</a>