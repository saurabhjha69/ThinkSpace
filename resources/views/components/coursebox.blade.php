@props(['title','description','image','progress'=>null,'isadmin'=>false,'course_id'])
<div class="tabs h-32 w-full p-4 flex gap-8 items-center rounded-2xl text-purpolis bg-white border hover:shadow-[#925fe2] hover:translate-y-1 transition-all ease-in-out duration-500 shadow-sm">
    <div class="img 1/3">
        <img src="{{$image}}" class="h-24 w-44 rounded-lg" alt="">
    </div>
    <div class="info w-2/3 flex flex-col gap-2">
        <h1 class="text-2xl font-extrabold">{{$title}}</h1>
        @if ($isadmin)
        <div class="btn flex items-center justify-between">
            {{-- <div class="approval space-x-2">
                <a href="/course" class="text-center px-4 py-1 border border-green-500 text-green-500 rounded-lg">Approve</a>
                <a href="/course" class="text-center px-4 py-1 border border-red-500 text-red-500 rounded-lg">Reject</a>
            </div> --}}
            <a href="/course/{{$course_id}}" class="text-center px-4 py-1 bg-purpolis text-white rounded-lg">View</a>
        </div>
        @else
        @if ($progress!=0)
        <div class="w-full bg-gray-200 rounded-full ">
            <div class="bg-purpolis text-xs font-medium text-blue-100 text-center h-[4px] rounded-full" style="width: {{$progress}}%"></div>
        </div>
        @else
        <p>Haven't Started Yet...</p>
        @endif
            <a href="/course/watch/{{$course_id}}" class="text-center px-4 py-1 bg-purpolis text-white rounded-lg">View</a>
        @endif
    </div>

</div>
