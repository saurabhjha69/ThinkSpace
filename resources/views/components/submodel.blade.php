@props(['title','duration'])
<div class="tab flex justify-between px-4 py-1">
    <p class="flex gap-2"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"
            fill="#2e2e2e">
            <path
                d="m384-312 264-168-264-168v336Zm96.28 216Q401-96 331-126t-122.5-82.5Q156-261 126-330.96t-30-149.5Q96-560 126-629.5q30-69.5 82.5-122T330.96-834q69.96-30 149.5-30t149.04 30q69.5 30 122 82.5T834-629.28q30 69.73 30 149Q864-401 834-331t-82.5 122.5Q699-156 629.28-126q-69.73 30-149 30Z" />
        </svg>
        <span class="text-sm">{{$title}}</span>
    </p>
    <span class="submodel-duration text-xs "><b>{{$duration}}</b> min</span>

</div>
