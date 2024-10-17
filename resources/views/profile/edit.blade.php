@component('layout')

<div class="edit-profile-container mx-auto p-4">
    <h1 class="text-2xl font-bold text-primary">Edit Profile</h1>
    <hr class="my-4">
    
    <form class="" action="/profile/edit" method="POST" enctype="multipart/form-data">
    <div class="flex flex-wrap">
        <!-- left column -->
        <div class="w-full md:w-1/3 flex flex-col p-5 justify-center items-center">
            <img src="https://bootdey.com/img/Content/avatar/avatar7.png"
                class="w-40 h-40 rounded-full border border-gray-300" alt="avatar">
            <h6 class="mt-2 text-gray-600">Upload a different photo...</h6>
            <input type="file" class="mt-2 border border-gray-300 rounded px-2 py-1" accept="image/*" name="profile_picture">
        </div>

        <!-- edit form column -->
        <div class="w-full md:w-2/3 space-y-3">
            <div class="bg-primary/15 border border-primary/25 rounded p-4 mb-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    @if($errors->any())
                        {{ implode('', $errors->all('<span class="text-primary ">:message</span>')) }}
                    @endif
                    
                </div>
            </div>
            <h3 class="text-xl font-semibold mb-4">Personal info</h3>
                @csrf
                <div class="flex items-center space-x-4">
                    <label class="w-1/3 font-semibold text-gray-700">First name:</label>
                    <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="firstname">
                </div>
                <div class="flex items-center space-x-4">
                    <label class="w-1/3 font-semibold text-gray-700">Last name:</label>
                    <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="lastname">
                </div>
                <div class="flex items-center space-x-4">
                    <label class="w-1/3 font-semibold text-gray-700">Phone:</label>
                    <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text"
                        name="phone_no">
                </div>
                <div class="flex items-center space-x-4">
                    <label class="w-1/3 font-semibold text-gray-700">Address:</label>
                    <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="address"
                        placeholder="Chicago, US">
                </div>
                <div class="flex items-center space-x-4">
                    <label class="w-1/3 font-semibold text-gray-700">Education:</label>
                    <select class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="education" value="">
                        <option value="High School">High School</option>
                        <option value="Bachelors">Bachelors</option>
                        <option value="Masters">Masters</option>
                        <option value="Phds">Phds</option>
                    </select>
                </div>
                <div class="flex items-center space-x-4">
                    <label class="w-1/3 font-semibold text-gray-700">Work Experience:</label>
                    <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="work_experience" placeholder="5 years" value="">
                </div>
                <div class="flex items-center space-x-4">
                    <label class="w-1/3 font-semibold text-gray-700">Social Links:</label>
                    <input class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="social_links" placeholder="google.com" value="">
                </div>
                <div class="flex items-center space-x-4">
                    <label class="w-1/3 font-semibold text-gray-700">Bio:</label>
                    <textarea class="w-2/3 border border-gray-300 rounded px-3 py-2" type="text" name="bio" placeholder="IT professional from IIT.."></textarea>
                </div>
                <div class="submit-btn flex">
                    <input type="submit" value="UPDATE" class="bg-primary text-white w-full py-1 rounded ">
                </div>
            </div>
        </div>
    </form>
    <hr class="my-4">
</div>
    
@endcomponent