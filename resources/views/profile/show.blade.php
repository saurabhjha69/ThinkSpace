@component('layout')
    <div class="container w-full mx-auto p-4">
        <div class="main-body w-full">
            <div class="p-4 w-full">
                <div class="flex flex-col items-center text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Admin"
                        class="rounded-full p-1 bg-primary-500 h-40 w-40">
                    <div class="mt-3">
                        <h4 class="text-lg font-semibold">{{ $user->username }}</h4>
                        <p class="text-gray-500 mb-1">Full Stack Developer</p>
                        <p class="text-gray-400 text-sm">Bay Area, San Francisco, CA</p>
                        <button class="bg-primary text-white py-1 px-3 rounded mt-2">Follow</button>
                        <a href="/profile/edit" class=" border border-primary text-primary py-1 px-3 rounded mt-2">Edit</a>
                    </div>
                </div>
                <div class="bg-white shadow rounded-lg">
                    <div class="p-4">
                        <div class="mb-4">
                            <div class="flex">
                                <div class="w-1/3">
                                    <h6 class="font-semibold">Full Name</h6>
                                </div>
                                <div class="w-2/3">
                                    <input type="text" class="form-input border border-gray-300 rounded p-2 w-full"
                                        value="John Doe">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex">
                                <div class="w-1/3">
                                    <h6 class="font-semibold">Email</h6>
                                </div>
                                <div class="w-2/3">
                                    <input type="text" class="form-input border border-gray-300 rounded p-2 w-full"
                                        value="john@example.com">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex">
                                <div class="w-1/3">
                                    <h6 class="font-semibold">Phone</h6>
                                </div>
                                <div class="w-2/3">
                                    <input type="text" class="form-input border border-gray-300 rounded p-2 w-full"
                                        value="(239) 816-9029">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex">
                                <div class="w-1/3">
                                    <h6 class="font-semibold">Mobile</h6>
                                </div>
                                <div class="w-2/3">
                                    <input type="text" class="form-input border border-gray-300 rounded p-2 w-full"
                                        value="(320) 380-4539">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex">
                                <div class="w-1/3">
                                    <h6 class="font-semibold">Address</h6>
                                </div>
                                <div class="w-2/3">
                                    <input type="text" class="form-input border border-gray-300 rounded p-2 w-full"
                                        value="Bay Area, San Francisco, CA">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="edit-profile-container mx-auto p-4">
            <h1 class="text-2xl font-bold text-primary">Edit Profile</h1>
            <hr class="my-4">
            <div class="flex flex-wrap">
                <!-- left column -->
                <div class="w-full md:w-1/3 flex flex-col p-5 justify-center items-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png"
                        class="w-40 h-40 rounded-full border border-gray-300" alt="avatar">
                    <h6 class="mt-2 text-gray-600">Upload a different photo...</h6>
                    <input type="file" class="mt-2 border border-gray-300 rounded px-2 py-1">
                </div>

                <!-- edit form column -->
                <div class="w-full md:w-2/3">
                    <div class="bg-primary/15 border border-primary/25 rounded p-4 mb-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-primary">This is an <strong>important alert</strong>. Use this to show
                                important messages to the user.</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Personal info</h3>
                    <form class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">First name:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" value="dey-dey">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Last name:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" value="bootdey">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Company:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" value="">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Email:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text"
                                value="janesemail@gmail.com">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Time Zone:</label>
                            <div class="w-2/3">
                                <select id="user_time_zone" class="border border-gray-300 rounded px-3 py-2 w-full">
                                    <option value="Hawaii">(GMT-10:00) Hawaii</option>
                                    <option value="Alaska">(GMT-09:00) Alaska</option>
                                    <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp;
                                        Canada)</option>
                                    <option value="Arizona">(GMT-07:00) Arizona</option>
                                    <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp;
                                        Canada)</option>
                                    <option value="Central Time (US &amp; Canada)" selected>(GMT-06:00) Central Time (US
                                        &amp; Canada)</option>
                                    <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp;
                                        Canada)</option>
                                    <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                                </select>
                            </div>
                        </div>
                        <div class="submit-btn flex">
                            <input type="submit" value="UPDATE" class="bg-primary text-white w-full py-1 rounded ">
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4">
        </div>
    </div>

    <script>
        document.getElementById('editbtn').addEventListener('click', function() {
            document.querySelector('.edit-profile-container').classList.toggle('hidden');
        })
    </script>
@endcomponent
