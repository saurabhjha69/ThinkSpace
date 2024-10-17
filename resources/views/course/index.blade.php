@component('layout')
<x-header class="px-0"></x-header>   
<div class="main px-10 w-full py-4 space-y-3">
    <div class="search-keyword-result-sorting flex justify-between">
        {{-- <h1>425 Results of "<span class="font-semibold"> Web Dev </span>"</h1> --}}
        <h1>Total Courses<span class="font-semibold"> 45 </span></h1>
        <div class="">
            <form action="">
                <label for="sorting">SortBy</label>
                <select name="" id="sorting" class="outline-none">
                    <option value="Most Relevant">Latest</option>
                    <option value="Most Relevant">Old</option>
                </select>
            </form>
        </div>
    </div>
    <hr>
    <div class="course-container py-4">
        <div class="courses">
            <a class="course-item" href="">
                <x-course-card :rating="2.7" reviews=33 img_h=100px img_w=175vw
                    img="https://images.unsplash.com/photo-1724963475892-a3274091955e?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    title="This is my new course"
                    des="bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla"
                    creator="Sandy gaonwala"
                    {{-- :img_h="96" --}}
                    ></x-course-card>
            </a>

        </div>
    </div>
    
</div>

@endcomponent


