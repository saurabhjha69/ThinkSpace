@component('layout')
    <div class="edit-profile-container mx-auto  p-4">
        <h1 class="text-2xl font-bold text-purpolis">Edit Profile</h1>
        <hr class="my-4">
        <div class="nav mb-10">
            <nav class="space-x-2">
                <a href="/profile/edit"
                    class=" {{ request()->is('profile/edit') ? 'border-b-[1px] border-gray-500' : 'text-gray-300' }} px-1">Profile</a>
                <a href="photo"
                    class="{{ request()->is('profile/photo') ? 'border-b-[1px] border-gray-500' : 'text-gray-300' }} px-1">Photo</a>
                <a href="settings"
                    class=" {{ request()->is('profile/settings') ? 'border-b-[1px] border-gray-500' : 'text-gray-300' }} px-1">Account
                    Security</a>
            </nav>
        </div>
        @if (request()->is('profile/photo'))
            <form action="/profile/photo" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="w-full md:w-2/3 mx-auto  flex flex-col p-5 justify-center items-center">
                    <img src="{{Auth::user()->userinfo->profile_picture ? Auth::user()->userinfo?->profile_picture : 'https://bootdey.com/img/Content/avatar/avatar7.png'}}" id="editProfilePicturePreview"
                        class="w-40 h-40 object-cover rounded-full border border-gray-300" alt="avatar">
                    <h6 class="mt-2 text-gray-600">Upload a different photo...</h6>
                    <input type="file" class="mt-5 border border-gray-300 rounded px-2 py-1" accept="image/*"
                        name="profile_picture" onchange="previewPhoto(this,'editProfilePicturePreview')">
                    <div class="savebtn mt-10 bg-green-200">
                        <input type="submit" class="bg-purpolis px-10 py-2 rounded-md text-white cursor-pointer"
                            value="Save">
                    </div>
                </div>
            </form>
        @endif
        @if (request()->is('profile/edit'))
            @csrf

            <form class="" action="/profile/edit" method="POST" enctype="multipart/form-data">

                <div class="flex justify-center items-center">

                    <div class="w-full md:w-2/3 space-y-3">
                        @if (session()->has('fail'))
                            <div class="bg-primary/15 border border-primary/25 rounded p-4 mb-4">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-primary ">:message</span>

                                </div>
                            </div>
                        @endif
                        <h3 class="text-xl font-semibold mb-4">Personal info</h3>
                        @csrf
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">First name:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="firstname"
                                value="{{ $user?->userinfo?->firstname }}" placeholder="john">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Last name:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="lastname"
                                value="{{ $user?->userinfo?->lastname }}" placeholder="doe">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Phone:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="phone_no"
                                value="{{ $user->userinfo?->phone_no }}" placeholder="98971.....">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Address:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="address"
                                value="{{ $user->userinfo?->address }}" placeholder="Chicago, US">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">DOB:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="date" min='1970-01-01'
                                max='2005-01-01' name="dob" value="{{ $user->userinfo?->date_of_birth }}">

                        </div>

                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Gender:</label>
                            <div class="gender flex gap-2 w-2/3 py-2">

                                <input class="border border-gray-300 rounded px-3 py-2" type="radio" name="gender"
                                    placeholder="Chicago, US" value="Male"
                                    {{ $user->userinfo?->gender == 'Male' ? 'checked' : '' }}>Male
                                <input class="border border-gray-300 rounded px-3 py-2 ml-3" type="radio" name="gender"
                                    value="Female" placeholder="Chicago, US"
                                    {{ $user->userinfo?->gender == 'Female' ? 'checked' : '' }}>Female
                                <input class=" border border-gray-300 rounded px-3 py-2 ml-3" type="radio" name="gender"
                                    value="Other" placeholder="Chicago, US"
                                    {{ $user->userinfo?->gender == 'Other' ? 'checked' : '' }}>Other
                            </div>

                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Education:</label>
                            <select class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text"
                                name="education" value="">
                                <option value="High School"
                                    {{ $user->userinfo?->education == 'High School' ? 'selected' : '' }}>High School
                                </option>
                                <option value="Bachelors"
                                    {{ $user->userinfo?->education == 'Bachelors' ? 'selected' : '' }}>Bachelors</option>
                                <option value="Masters" {{ $user->userinfo?->education == 'Masters' ? 'selected' : '' }}>
                                    Masters</option>
                                <option value="Phds" {{ $user->userinfo?->education == 'Phd' ? 'selected' : '' }}>Phd
                                </option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Work Experience:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text"
                                name="work_experience" placeholder="Ex. 5 years"
                                value="{{ $user->userinfo?->work_experience }}">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Specialization:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text"
                                name="specialization" placeholder="Ex. Web dev, AI ML, Java, etc"
                                value="{{ $user->userinfo?->specialization }}">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Twitter Link:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="url" name="social[]"
                                placeholder="twitter.com" value="">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">LinkedIn Link:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="url" name="social[]"
                                placeholder="linked.in" value="">
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Bio:</label>
                            <textarea class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="bio"
                                placeholder="IT professional from IIT..">{{ $user->userinfo?->bio }}</textarea>
                        </div>
                        <div class="submit-btn flex">
                            <input type="submit" value="UPDATE" class="bg-purpolis text-white w-full py-1 rounded ">
                        </div>
                    </div>
                </div>
            </form>
        @endif
        @if (request()->is('profile/settings'))
            <div class="flex flex-col justify-center items-center">
                <div class="w-full md:w-2/3 space-y-3 mb-10">
                    <h3 class="text-xl font-semibold mb-4">Change Email</h3>
                    <form action="/profile/settings" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center mb-5">

                            <input class="w-full border border-gray-300 rounded px-3 py-2" type="email"
                                name="email" value="{{$user->email}}">
                        </div>

                        <div class="submit-btn flex">
                            <input type="submit" name="update_email" value="Update Email" class="bg-purpolis text-white w-full py-1 rounded ">

                        </div>
                </div>
                @if (session()->has('fail'))
                    <p class="text-red-500 bg-red-300 rounded-md p-2 border border-r-red-500">{{session('fail')}}</p>
                @endif
                <div class="w-full md:w-2/3 space-y-3">
                    <h3 class="text-xl font-semibold mb-4">Change Password</h3>
                    <form action="/profile/settings" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Current Password:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="password"
                                name="current_password">
                            </div>
                            <x-validationError error_name="current_password"></x-validationError>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">New Password:</label>
                            <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="password"
                                name="password">
                            </div>
                            <x-validationError error_name="password"></x-validationError>
                        <div class="flex items-center space-x-4">
                            <label class="w-1/3 font-semibold text-gray-700">Confirm Password:</label>
                            <input class="w-2/3
                        border border-gray-300 rounded px-3 py-2"
                                type="password" name="password_confirmation">
                        </div>
                        <div class="submit-btn flex">
                            <input type="submit" name="update_password" value="Update Password" class="bg-primary text-white w-full py-1 rounded ">

                        </div>
                </div>
            </div>
        @endif



    @endcomponent
