@component('layout')
<div class="courses-tabs py-6 flex justify-between flex-wrap  ">
    <div class="course-container relative flex justify-center h-36 w-[16rem] bg-gray-500/25 rounded-lg box-border overflow-hidden  drop-shadow-xl">
        <div class="thumbnail">
            <img class="object-cover" src="https://plus.unsplash.com/premium_photo-1661331911412-330f2e99cf53?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img" class="object-cover" >
        </div>

            <div class="title-des absolute flex flex-col justify-center items-center opacity-0 group hover:opacity-100 bg-black/40 transition duration-300 ease-in-out text-white h-full w-full px-3">
                <!-- <h1 class="text-md font-bold">Lorem ipsum dolor sit.</h1> -->
                <div class="btn flex items-end mt-4">
                    <a href="#" class="px-6 py-[0.40rem] bg-black rounded-lg text-sm text-white hover:translate-y-2 transition duration-300 ease-in-out">Resume ..</a>
                </div>
            </div>
    </div> 
</div>
<div class="main min-h-screen w-full flex justify-between py-2 ">
    
    <div class="left w-[65%] space-y-16 ">
        <div class="resume-course space-y-6 rounded-lg py-10 px-5 shadow-lg">
            <h2 class="text-2xl text-primary font-semibold">Resume Your Course</h2>
            
            <x-course-card
                img="https://images.unsplash.com/photo-1725109431763-36524de95bf9?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                title="Ultimate Java Course for Beginners"
                des="In this course we will deep dive into the Object oriented programming concept in java, the most popular programming languages"
                :btn="true"
                img_w="250px"
                img_h="200px"
            ></x-course-card>
            
            
        </div>
        <div class="analytics flex flex-col gap-y-6 px-5 shadow-md py-10 rounded-lg">
            <h1 class="text-2xl">Quick Stats</h1>
            <div class="divs flex flex-wrap justify-between gap-y-5">
                <div class="tabs min-h-32 w-[48%] rounded-md bg-gray-500/25 place-content-center">
                    <h1 class="text-6xl text-center text-primary">0</h1>
                    <h5 class="text-center
                    ">Attempted Quiz</h5>
                </div>
                <div class="tabs min-h-32 w-[48%] rounded-md bg-gray-500/25 place-content-center">
                    <h1 class="text-6xl text-center text-primary">0</h1>
                    <h5 class="text-center
                    ">Enrolled Courses</h5>
                </div>
                <div class="tabs min-h-32 w-[48%] rounded-md bg-gray-500/25 place-content-center">
                    <h1 class="text-6xl text-center text-primary">0</h1>
                    <h5 class="text-center
                    ">Total Watch Hours</h5>
                </div>
                <div class="tabs min-h-32 w-[48%] rounded-md bg-gray-500/25 place-content-center">
                    <h1 class="text-6xl text-center text-primary">0</h1>
                    <h5 class="text-center
                    ">Total Comments</h5>
                </div>
                
                
            </div>
        </div>
    </div>
    <div class="right w-[30%] box-border space-y-16">
        <div class="leaderboard  rounded-lg px-4 shadow-lg">
            <h2 class="text-2xl text-center py-7 border-b-2 border-gray-700/25 ">Leaderboard..</h2>
            <div class="board py-6 space-y-5">
                <div class="person flex justify-around">
                    <h1 class="text-xl font-bold ">1st</h1>
                    <h3 class="text-xl">Rohan Malhotra</h3>
                </div>
                <div class="person flex justify-around">
                    <h1 class="text-xl font-bold ">2nd</h1>
                    <h3 class="text-xl">Rohan Malhotra</h3>
                </div>
                <div class="person flex justify-around">
                    <h1 class="text-xl font-bold ">3rd</h1>
                    <h3 class="text-xl">Rohan Malhotra</h3>
                </div>
                <div class="person flex justify-around">
                    <h1 class="text-xl font-bold">4th</h1>
                    <h3 class="text-xl">Rohan Malhotra</h3>
                </div>
                <div class="person flex justify-around">
                    <h1 class="text-xl font-bold ">5th</h1>
                    <h3 class="text-xl">Rohan Malhotra</h3>
                </div>
            </div>
        </div>
        <div class="Recommendation  rounded-lg px-4 shadow-lg">
            <h2 class="text-2xl text-center py-7  border-gray-700/25 ">New Course Recommendation..</h2>
            <div class="board py-6 space-y-5">
                <div class="course space-y-3 px-6">
                    <div class="thumbnail bg-red-400 h-[170px]  overflow-hidden">
                        <img src="https://plus.unsplash.com/premium_photo-1661331911412-330f2e99cf53?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img" class="" >
                    </div>
                    <h4 class="text-sm font-bold ">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore nemo quibusdam facilis.
                    </h4>
                    <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, placeat illum officiis dolor exercitationem temporibus ipsum! Necessitatibus suscipit temporibus fugit explicabo omnis pariatur eum quam!</p>
                </div>
                
            </div>
        </div>
    </div>
</div>


    
@endcomponent