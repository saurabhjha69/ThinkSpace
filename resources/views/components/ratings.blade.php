@props(['rating'])
<div class="ratings flex items-center text-yellow-400">
    @php
        $fullStars = floor($rating);
        $decimalPart = $rating - $fullStars;
    @endphp
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $fullStars)
            <x-stars-svg :percentage="100"></x-stars-svg>
        @elseif ($i == $fullStars + 1 && $decimalPart > 0)
            <x-stars-svg :percentage="$decimalPart * 100"></x-stars-svg>
        @endif
    @endfor
</div>