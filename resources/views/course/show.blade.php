<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <div class="main min-h-[100vh] w-full bg-white text-black">
        <div class="content relative w-full h-80 bg-black px-52 flex items-center">
            <div class="banner text-white w-3/5 space-y-2">
                <h1 class="text-4xl text-white font-semibold">{{ $course->name }}</h1>
                <h6 class="text-lg">{{ $course->description }}</h6>
                <div class="ratings-box flex gap-4 items-center">
                    @if ($course->averageRating()!=null)
                        <x-ratings :rating="$course->averageRating()"></x-ratings>
                    @else
                        <button class="text-sm p-[1px] rounded-sm py-[1px] flex items-center gap-4 bg-white text-black justify-between">Rate Now <x-svgs.star></x-svgs.star></button>
                    @endif
                    <p class="text-gray-300">({{ $course->ratings->count()== 0 ? 'No Ratings Yet..' : '1' }})</p>
                    <div class="enrolled flex items-center gap-2 bg-white text-black text-xs px-1 rounded-md">
                        <x-svgs.group h=24 w=24></x-svgs.group>
                        {{$course->payments->count()}}{{$course->payments->count() > 1 ? ' students' : ' student'}} enrolled
                    </div>
                </div>
                <div class="about-instructor pt-6">
                    <p>Course by : <span class="underline font-semibold cursor-pointer">{{Str::ucfirst($course->user->username) }}</span>
                    </p>
                </div>
            </div>

            <div
                class="course-card absolute z-10 top-16 right-[13%] h-[35rem] w-[28rem] rounded-xl bg-white overflow-hidden shadow-xl space-y-7">
                <div class="img w-full">
                    <img class="object-cover h-56 w-full" src="{{ $course->thumbnail_url }}" alt>
                </div>
                <div class="price-btn px-6 flex flex-col gap-2">
                    
                    @if ($isPurchased)
                        <h1 class="text-2xl flex gap-4 font-bold text-gray-900">Continue Learning</h1>
                        <a href="/course/watch/{{$course->id}}" class="bg-black flex-grow text-white py-2 rounded-md text-center text-xl hover:translate-y-1 transition duration-200 ease-in">Resume Course</a>
                    @else
                    <div>
                        <span class=" rounded-full bg-yellow-400 px-2 text-center text-sm font-medium text-black">{{$course->calcDiscount($course)}}% OFF</span> 
                        <h1 class="text-4xl flex gap-4 font-bold text-gray-900">${{ $course->price }}</h1>
                        </div>
                    <form action="/create-checkout-session" method="POST" class="flex">
                        @csrf
                        <input type="hidden" value="{{ $course->id }}" name="course_id">
                        <button type="submit"
                            class="bg-black flex-grow text-white py-2 rounded-md text-center text-xl hover:translate-y-1 transition duration-200 ease-in">Enroll
                            Now</button>
                    </form>
                    <p class="underline cursor-pointer">Apply coupon</p>
                    @endif

                </div>
                <div class="course-dets px-6 font-poppins">
                    @if (session()->has('flash_notification'))
                        <div class="alert alert-success">
                            {{ session('flash_notification.message') }}
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold mb-2  ">What's In this
                        course?</h1>
                    <ol class="text-[#656565]">

                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                width="24px" fill="#4e4e4e">
                                <path
                                    d="M160-80q-33 0-56.5-23.5T80-160v-400q0-33 23.5-56.5T160-640h640q33 0 56.5 23.5T880-560v400q0 33-23.5 56.5T800-80H160Zm0-80h640v-400H160v400Zm240-40 240-160-240-160v320ZM160-680v-80h640v80H160Zm120-120v-80h400v80H280ZM160-160v-400 400Z" />
                            </svg>
                            {{$course->lectures('video')}} video lectures
                        </li>

                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                width="24px" fill="#4e4e4e">
                                <path
                                    d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 27-3 53t-10 51q-14-16-32.5-27T794-418q3-15 4.5-30.5T800-480q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93q51 0 97.5-15t85.5-42q12 17 29.5 30t37.5 20q-51 41-114.5 64T480-80Zm290-160q-21 0-35.5-14.5T720-290q0-21 14.5-35.5T770-340q21 0 35.5 14.5T820-290q0 21-14.5 35.5T770-240Zm-158-52L440-464v-216h80v184l148 148-56 56Z" />
                            </svg>
                            {{App\Helper\Helper::secondsToMinutes($course->totalCourseDuration())}}{{App\Helper\Helper::secondsToMinutes($course->totalCourseDuration()) > 60 ? ' hrs' : ' mins'}} of content
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960"
                                width="24px" fill="#4e4e4e">
                                <path
                                    d="M480-432q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM263-48v-280q-43-37-69-99t-26-125q0-130 91-221t221-91q130 0 221 91t91 221q0 64-24 125.5t-72 99.43V-48L480-96 263-48Zm217-264q100 0 170-70t70-170q0-100-70-170t-170-70q-100 0-170 70t-70 170q0 100 70 170t170 70ZM335-138l145-32 144 32v-138q-33 18-69.5 27t-74.5 9q-38 0-75-8.5T335-276v138Zm145-70Z" />
                            </svg>
                            Certificate on completion
                        </li>
                    </ol>
                </div>
            </div>

        </div>
        <div class="course-contents pt-10 w-full px-52 space-y-12">
            <div class="des w-3/5">
                <h1 class="text-3xl font-bold mb-2">About Course</h1>
                <p class="text-[19px]">{{$course->about}}</p>
            </div>

            <div class="module-container w-3/5">
                <h1 class="text-3xl font-bold mb-5">Course Structure</h1>
                <p class="mb-5 text-sm font-semibold">{{$course->lectures('l')}} lectures - {{App\Helper\Helper::secondsToMinutes($course->totalCourseDuration())}} min duration</p>
                @foreach ($course->modules->sortBy('order') as $key => $module)
                    <div class="modules w-full border border-black/15">
                        <x-model title="{{ $module->title }}" :duration="App\Helper\Helper::secondsToMinutes($module->totalDuration())" target="module1">
                            <button onclick="toggleSubModule('.sub-modules{{ $key + 1 }}')">
                                <x-svgs.downarrow></x-svgs.downarrow>
                            </button>
                        </x-model>

                        <div class="sub-modules{{ $key + 1 }} w-full border-t-2 border-black/15 pt-6 pb-4 transition-all duration-150 ease-in-out {{ $module->order === 1 ? ' ' : 'hidden' }}"
                            id="module1">
                            @foreach ($module->submodules as $submodule)
                                <x-submodel title="{{ $submodule->title }}" duration="{{$submodule->videoduration()}}"></x-submodel>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="instructor-dets w-3/5">
                <p class="text-2xl font-bold font-poppins mt-5" id="creator">Course
                    Instructor</p>
                <div class="mt-4 flex items-center gap-4">
                    <img src="https://plus.unsplash.com/premium_photo-1682089861447-7363590a8ec9?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Piyush Garg" class="w-36 h-40 object-cover rounded-md" />
                    <div class="flex flex-col text-sm text-gray-800">
                        <a class="text-primary-800 text-lg font-bold underline"
                            href="/instructor-profile/piyushgargdev">{{ $course->user->name }}</a>
                        <div class="text-gray-600 mt-1">Full-stack Developer</div>

                        <div class="instructor-dets space-y-1 mt-4">
                            <div class="flex items-center">
                                @include('components.svgs.star')
                                <span class="font-medium mr-1">4.7</span>
                                Instructor rating
                            </div>
                            <div class="flex items-center">
                                @include('components.svgs.badge')
                                <span class="font-medium mr-1">2k</span>
                                Ratings
                            </div>
                            <div class="flex items-center">
                                @include('components.svgs.group2')
                                <span class="font-medium mr-1">24.2k</span>
                                Students
                            </div>
                            <div class="flex items-center">
                                @include('components.svgs.courses')
                                <span class="font-medium mr-1 pl-1">0{{ $course->user->courses->count() }}</span>
                                Courses
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mt-4 leading-relaxed text-gray-800">
                    Hi, I am Gaonwala and I love to explore new technologies
                    and frameworks. I work as a freelancer in various
                    domains such as the Backend engineer, AWS Cloud solution
                    architect, etc.
                    Fun fact about me:
                    ...
                    <a class="ml-1 text-sm font-medium underline" href="/instructor-profile/goanwala">View profile</a>
                </p>
                <div class="social-icons flex justify-between mt-3 w-36">
                    @include('components.svgs.insta')
                    @include('components.svgs.facebook')
                    @include('components.svgs.linkedin')
                    @include('components.svgs.twitter')
                </div>

            </div>


        </div>
        <section>
            <div class="min-w-screen min-h-screen bg-gray-50 flex items-center justify-center py-5">
                <div class="w-full bg-white border-t border-b border-gray-200 px-5 py-16 md:py-24 text-gray-800">
                    <div class="w-full max-w-6xl mx-auto">
                        <div class="text-center max-w-xl mx-auto">
                            <h1 class="text-6xl md:text-7xl font-bold mb-5 text-gray-600">What people <br>are saying.</h1>
                            <h3 class="text-xl mb-5 font-light">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h3>
                            <div class="text-center mb-10">
                                <span class="inline-block w-1 h-1 rounded-full bg-indigo-500 ml-1"></span>
                                <span class="inline-block w-3 h-1 rounded-full bg-indigo-500 ml-1"></span>
                                <span class="inline-block w-40 h-1 rounded-full bg-indigo-500"></span>
                                <span class="inline-block w-3 h-1 rounded-full bg-indigo-500 ml-1"></span>
                                <span class="inline-block w-1 h-1 rounded-full bg-indigo-500 ml-1"></span>
                            </div>
                        </div>
                        <div class="-mx-3 md:flex items-start">
                            <div class="px-3 md:w-1/3">
                                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-5 text-gray-800 font-light mb-6">
                                    <div class="w-full flex mb-4 items-center">
                                        <div class="overflow-hidden rounded-full w-10 h-10 bg-gray-50 border border-gray-200">
                                            <img src="https://i.pravatar.cc/100?img=1" alt="">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-bold text-sm uppercase text-gray-600">Kenzie Edgar.</h6>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-sm leading-tight"><span class="text-lg leading-none italic font-bold text-gray-400 mr-1">"</span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos sunt ratione dolor exercitationem minima quas itaque saepe quasi architecto vel! Accusantium, vero sint recusandae cum tempora nemo commodi soluta deleniti.<span class="text-lg leading-none italic font-bold text-gray-400 ml-1">"</span></p>
                                    </div>
                                </div>
                                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-5 text-gray-800 font-light mb-6">
                                    <div class="w-full flex mb-4 items-center">
                                        <div class="overflow-hidden rounded-full w-10 h-10 bg-gray-50 border border-gray-200">
                                            <img src="https://i.pravatar.cc/100?img=2" alt="">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-bold text-sm uppercase text-gray-600">Stevie Tifft.</h6>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-sm leading-tight"><span class="text-lg leading-none italic font-bold text-gray-400 mr-1">"</span>Lorem ipsum, dolor sit amet, consectetur adipisicing elit. Dolore quod necessitatibus, labore sapiente, est, dignissimos ullam error ipsam sint quam tempora vel.<span class="text-lg leading-none italic font-bold text-gray-400 ml-1">"</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 md:w-1/3">
                                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-5 text-gray-800 font-light mb-6">
                                    <div class="w-full flex mb-4 items-center">
                                        <div class="overflow-hidden rounded-full w-10 h-10 bg-gray-50 border border-gray-200">
                                            <img src="https://i.pravatar.cc/100?img=3" alt="">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-bold text-sm uppercase text-gray-600">Tommie Ewart.</h6>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-sm leading-tight"><span class="text-lg leading-none italic font-bold text-gray-400 mr-1">"</span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae, obcaecati ullam excepturi dicta error deleniti sequi.<span class="text-lg leading-none italic font-bold text-gray-400 ml-1">"</span></p>
                                    </div>
                                </div>
                                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-5 text-gray-800 font-light mb-6">
                                    <div class="w-full flex mb-4 items-center">
                                        <div class="overflow-hidden rounded-full w-10 h-10 bg-gray-50 border border-gray-200">
                                            <img src="https://i.pravatar.cc/100?img=4" alt="">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-bold text-sm uppercase text-gray-600">Charlie Howse.</h6>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-sm leading-tight"><span class="text-lg leading-none italic font-bold text-gray-400 mr-1">"</span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto inventore voluptatum nostrum atque, corrupti, vitae esse id accusamus dignissimos neque reprehenderit natus, hic sequi itaque dicta nisi voluptatem! Culpa, iusto.<span class="text-lg leading-none italic font-bold text-gray-400 ml-1">"</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 md:w-1/3">
                                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-5 text-gray-800 font-light mb-6">
                                    <div class="w-full flex mb-4 items-center">
                                        <div class="overflow-hidden rounded-full w-10 h-10 bg-gray-50 border border-gray-200">
                                            <img src="https://i.pravatar.cc/100?img=5" alt="">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-bold text-sm uppercase text-gray-600">Nevada Herbertson.</h6>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-sm leading-tight"><span class="text-lg leading-none italic font-bold text-gray-400 mr-1">"</span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis, voluptatem porro obcaecati dicta, quibusdam sunt ipsum, laboriosam nostrum facere exercitationem pariatur deserunt tempora molestiae assumenda nesciunt alias eius? Illo, autem!<span class="text-lg leading-none italic font-bold text-gray-400 ml-1">"</span></p>
                                    </div>
                                </div>
                                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-5 text-gray-800 font-light mb-6">
                                    <div class="w-full flex mb-4 items-center">
                                        <div class="overflow-hidden rounded-full w-10 h-10 bg-gray-50 border border-gray-200">
                                            <img src="https://i.pravatar.cc/100?img=6" alt="">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-bold text-sm uppercase text-gray-600">Kris Stanton.</h6>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <p class="text-sm leading-tight"><span class="text-lg leading-none italic font-bold text-gray-400 mr-1">"</span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem iusto, explicabo, cupiditate quas totam!<span class="text-lg leading-none italic font-bold text-gray-400 ml-1">"</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
-->

<link href="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.css" rel="stylesheet" />

<script type="module">
  import KeenSlider from 'https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm'

  const keenSlider = new KeenSlider(
    '#keen-slider',
    {
      loop: true,
      slides: {
        origin: 'center',
        perView: 1.25,
        spacing: 16,
      },
      breakpoints: {
        '(min-width: 1024px)': {
          slides: {
            origin: 'auto',
            perView: 1.5,
            spacing: 32,
          },
        },
      },
    },
    []
  )

  const keenSliderPrevious = document.getElementById('keen-slider-previous')
  const keenSliderNext = document.getElementById('keen-slider-next')

  const keenSliderPreviousDesktop = document.getElementById('keen-slider-previous-desktop')
  const keenSliderNextDesktop = document.getElementById('keen-slider-next-desktop')

  keenSliderPrevious.addEventListener('click', () => keenSlider.prev())
  keenSliderNext.addEventListener('click', () => keenSlider.next())

  keenSliderPreviousDesktop.addEventListener('click', () => keenSlider.prev())
  keenSliderNextDesktop.addEventListener('click', () => keenSlider.next())
</script>

<section class="bg-gray-50">
  <div class="mx-auto max-w-[1340px] px-4 py-12 sm:px-6 lg:me-0 lg:py-16 lg:pe-0 lg:ps-8 xl:py-24">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:items-center lg:gap-16">
      <div class="max-w-xl text-center ltr:sm:text-left rtl:sm:text-right">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          Don't just take our word for it...
        </h2>

        <p class="mt-4 text-gray-700">
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas veritatis illo placeat
          harum porro optio fugit a culpa sunt id!
        </p>

        <div class="hidden lg:mt-8 lg:flex lg:gap-4">
          <button
            aria-label="Previous slide"
            id="keen-slider-previous-desktop"
            class="rounded-full border border-rose-600 p-3 text-rose-600 transition hover:bg-rose-600 hover:text-white"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-5 rtl:rotate-180"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15.75 19.5L8.25 12l7.5-7.5"
              />
            </svg>
          </button>

          <button
            aria-label="Next slide"
            id="keen-slider-next-desktop"
            class="rounded-full border border-rose-600 p-3 text-rose-600 transition hover:bg-rose-600 hover:text-white"
          >
            <svg
              class="size-5 rtl:rotate-180"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M9 5l7 7-7 7"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
              />
            </svg>
          </button>
        </div>
      </div>

      <div class="-mx-6 lg:col-span-2 lg:mx-0">
        <div id="keen-slider" class="keen-slider">
          <div class="keen-slider__slide">
            <blockquote
              class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12"
            >
              <div>
                <div class="flex gap-0.5 text-green-500">
                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                </div>

                <div class="mt-4">
                  <p class="text-2xl font-bold text-rose-600 sm:text-3xl">Stayin' Alive</p>

                  <p class="mt-4 leading-relaxed text-gray-700">
                    No, Rose, they are not breathing. And they have no arms or legs … Where are
                    they? You know what? If we come across somebody with no arms or legs, do we
                    bother resuscitating them? I mean, what quality of life do we have there?
                  </p>
                </div>
              </div>

              <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
                &mdash; Michael Scott
              </footer>
            </blockquote>
          </div>

          <div class="keen-slider__slide">
            <blockquote
              class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12"
            >
              <div>
                <div class="flex gap-0.5 text-green-500">
                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                </div>

                <div class="mt-4">
                  <p class="text-2xl font-bold text-rose-600 sm:text-3xl">Stayin' Alive</p>

                  <p class="mt-4 leading-relaxed text-gray-700">
                    No, Rose, they are not breathing. And they have no arms or legs … Where are
                    they? You know what? If we come across somebody with no arms or legs, do we
                    bother resuscitating them? I mean, what quality of life do we have there?
                  </p>
                </div>
              </div>

              <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
                &mdash; Michael Scott
              </footer>
            </blockquote>
          </div>

          <div class="keen-slider__slide">
            <blockquote
              class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12"
            >
              <div>
                <div class="flex gap-0.5 text-green-500">
                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>

                  <svg
                    class="size-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                    />
                  </svg>
                </div>

                <div class="mt-4">
                  <p class="text-2xl font-bold text-rose-600 sm:text-3xl">Stayin' Alive</p>

                  <p class="mt-4 leading-relaxed text-gray-700">
                    No, Rose, they are not breathing. And they have no arms or legs … Where are
                    they? You know what? If we come across somebody with no arms or legs, do we
                    bother resuscitating them? I mean, what quality of life do we have there?
                  </p>
                </div>
              </div>

              <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
                &mdash; Michael Scott
              </footer>
            </blockquote>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-8 flex justify-center gap-4 lg:hidden">
      <button
        aria-label="Previous slide"
        id="keen-slider-previous"
        class="rounded-full border border-rose-600 p-4 text-rose-600 transition hover:bg-rose-600 hover:text-white"
      >
        <svg
          class="size-5 -rotate-180 transform"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
        </svg>
      </button>

      <button
        aria-label="Next slide"
        id="keen-slider-next"
        class="rounded-full border border-rose-600 p-4 text-rose-600 transition hover:bg-rose-600 hover:text-white"
      >
        <svg
          class="size-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
        </svg>
      </button>
    </div>
  </div>
</section>
        <footer class="bg-black h-40 w-full mt-16
">

        </footer>
    </div>
    <script>
        function toggleSubModule(selector) {
            const submodule = document.querySelector(selector);
            submodule.classList.toggle('hidden');
        }
    </script>

</body>

</html>
