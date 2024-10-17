@component('layout')
<x-header href="/explore" value="{{request('search') != '' ? request('search') : ''}}"></x-header>
<form action="/explore" method="GET" id="filterForm" class="mt-10 flex justify-between">

    <div>
        <label for="categoryFilter" class="mr-2 font-medium">Filter by Category:</label>
        <select id="exploreCategoryFilter" name="categoryFilter" onchange="submitFiltering()" class="border border-gray-300 rounded-md p-2">
            <option value="All" {{request('categoryFilter') == 'All' ? 'selected' : ''}}>All</option>
            @foreach ($categories as $category)
            <option value="{{$category->id}}" {{request('categoryFilter') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="orderBy" class="mr-2 font-medium">Order by:</label>
        <select id="exploreOrderBy" name="orderBy" onchange="submitFiltering()" class="border border-gray-300 rounded-md p-2">
            <option value="newest" {{request('orderBy') == 'newest' ? 'selected' : ''}}>Newest</option>
            <option value="oldest" {{request('orderBy') == 'oldest' ? 'selected' : ''}}>Oldest</option>
            <option value="avgrating" {{request('orderBy') == 'avgrating' ? 'selected' : ''}}>Avg Rating</option>
            <option value="lowtohigh" {{request('orderBy') == 'lowtohigh' ? 'selected' : ''}}>Price: Low - High</option>
            <option value="hightolow" {{request('orderBy') == 'hightolow' ? 'selected' : ''}}>Price: High - Low</option>

        </select>
    </div>
</form>
<div class="course-div pt-8 flex flex-wrap justify-between gap-8">
    @foreach ($courses as $course)
        <div class="relative w-[350px] flex px-4 flex-col overflow-hidden rounded-2xl border hover:border-purpolis transition-all duration-200 ease-in-out bg-white shadow-md">
            <a class="relative mt-3 flex h-40 overflow-hidden rounded-xl" href="#">
            <img class="object-cover h-full w-full" src="{{$course->thumbnail_url}}" alt="product image" />
            <span class="absolute top-0 left-0 m-2 rounded-full bg-black px-2 text-center text-sm font-medium text-white">{{$course->calcDiscount($course)}}% OFF</span>
            </a>
            <div class="mt-2 pb-3">
            <a href="#">
                <h5 class="text-xl tracking-tight text-slate-900">{{Str::upper($course->name)}}</h5>
            </a>
            <div class=" mb-2 flex items-center justify-between">
                <p>
                <span class="text-3xl font-bold text-slate-900">${{$course->price}}</span>
                <span class="text-sm text-slate-900 line-through">${{$course->est_price}}</span>
                </p>
                <div class="flex items-center">
                    <span class="text-xs italic text-gray-600">{{App\Helper\Helper::formatDateTime($course->created_at)}}</span>
                <x-ratings rating="{{$course->averageRating()}}"></x-ratings>
                <span class="mr-2 ml-3 rounded bg-yellow-200 px-2.5 py-0.5 text-xs font-semibold">{{$course->averageRating()}}</span>
                </div>
            </div>
            <a href="/course/{{$course->id}}" class="flex items-center justify-center rounded-md bg-purpolis px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Explore it..</a>
            </div>
        </div>
    @endforeach
</div>
{{$courses->links()}}

@endcomponent
