@component('layout')
    <div class="container w-full mx-auto p-4">
        <div class="main-body w-full ">
            <div class="p-4 w-full divide-y-8 divide-gray-100">
                <div class="flex flex-col pb-5 p-5 bg-white items-center text-center rounded-lg shadow">
                    <img src="{{Auth::user()->userinfo?->profile_picture}}" id="editProfilePicturePreview"
                        class="w-40 h-40 object-cover rounded-full border-2 border-purpolis" alt="avatar" >

                    <div class="mt-3">
                        <h4 class="text-lg font-semibold">{{ $user->fullname() }}</h4>
                        <p class="text-gray-500 mb-1">{{$user->userinfo?->education}}</p>
                        <p class="text-gray-400 text-sm mb-2">{{$user->userinfo?->address}}</p>
                        <p class="text-gray-400 mx-auto w-2/3 text-sm mb-2">{{$user->userinfo?->bio}}</p>
                        <div class="editbtn flex justify-end pr-10">
                            <a href="/profile/edit" class=" border border-primary text-primary py-1 px-3 rounded mt-2">Edit</a>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <script>
        document.getElementById('editbtn').addEventListener('click', function() {
            document.querySelector('.edit-profile-container').classList.toggle('hidden');
        })
    </script>
@endcomponent
