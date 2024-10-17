@props(['rating' => null, 'reviews' => 0, 'title', 'des', 'creator'=>null, 'img','btn'=>false,'img_w','img_h'])

<div class="course1 flex items-center gap-4 py-4 ">
    <div class="img object-cover">
        <img src="{{ $img }}" height="{{$img_h}}" width="{{$img_w}}" class="rounded-lg  " alt="">
    </div>
    <div class="course-info flex flex-col justify-between">
        <h1 class="text-xl font-bold">{{ $title }}</h1>
        <p class="mb-3">{{ $des }}</p>
         @if ($creator!=null)  
            <a href="#" class="text-xs hover:underline">{{ $creator }}</a>
         @endif   
        
         @if ($rating!=null)
             
            <div class="ratings-box flex gap-2 items-center">
                <span class="text-lg font-semibold">{{ number_format($rating, 1) }}</span>
                <x-ratings :rating="4.6"></x-ratings>
                <p class="text-gray-500 text-[12px]">({{ $reviews }} reviews)</p>
            </div>
         @endif

         @if ($btn)
             <a href="#" class="bg-primary text-white rounded-md text-center py-1">Resume</a>
         @endif


    </div>
</div>
