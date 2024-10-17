<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/quiz.js')
    @vite('resources/js/userenroll.js')
    @vite('resources/js/coupon.js')

    @vite('resources/js/imagepreview.js')
    @vite('resources/js/delete_confirmation.js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
</head>
<body class="relative w-full flex justify-between bg-gray-100 ">
    <div class="sidebar relative h-full w-96">
        <x-sidebar></x-sidebar>
    </div>

    <div class=" container relative max-w-[calc(100%-300px)] min-h-screen px-10 pb-20 overflow-x-hidden">

        {{$slot}}

    </div>


</body>
</html>
