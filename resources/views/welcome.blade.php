<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite('resources/css/app.css')
       
    </head>
    <body>
        @include('components.header')
       
        <div class="main px-40 w-full py-4 space-y-3">
            <div class="search-keyword-result-sorting flex justify-between">
                <h1>425 Results of "<span class="font-semibold"> Web Dev </span>"</h1>
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
                        <x-course-card 
                        :rating="2.7" 
                        reviews=33
                        img="https://images.unsplash.com/photo-1724963475892-a3274091955e?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        title="This is my new course"
                        des="bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla"
                        creator="Sandy gaonwala"
                        ></x-course-card>
                    </a>
                    
                </div>
            </div>
        </div>
    </body>
</html>
