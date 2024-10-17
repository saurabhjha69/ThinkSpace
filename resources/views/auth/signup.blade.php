@component('auth')
    @slot('title')
        Signup
    @endslot

    @slot('content')
        <div class="">
            <form action="/signup" method="POST">
                @csrf

                <div class="w-[30%] m-auto bg-white shadow-lg rounded-lg p-8 flex flex-col">
                    <h2 class="text-2xl font-semibold text-center mb-6">SIGN UP</h2>
                    <div class="text-center mb-6">
                        <p class="text-sm text-gray-500">Connect with Your Social Accounts</p>
                        <div class="flex justify-center space-x-4 mt-4">
                            <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-full">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white py-2 px-4 rounded-full">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-full">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="relative text-center mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative text-sm bg-white px-4">OR</div>
                    </div>
                    <span class="text-red">
                        @if (Session::has('fail'))
                            {{Session()->get('fail')}}
                        @endif
                    </span>
                    <div class="mb-4">
                        <input type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Username" name="username" :value="old()">
                        <x-validationError error_name="username"></x-validationError>
                    </div>
                    <div class="mb-4">
                        <input type="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Email" name="email">
                            <x-validationError error_name="email"></x-validationError>
                    </div>
                    <div class="mb-4">
                        <input type="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Password" name="password"> 
                            <x-validationError error_name="password"></x-validationError>
                    </div>
                    <div class="mb-4">
                        <input type="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Confrim Password" name="password_confirmation"> 
                            <x-validationError error_name="password_confirmation"></x-validationError>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-md">Sign Up</button>
                    </div>
                    <div class="text-center">
                        <a href="/login" class="text-sm text-blue-500 hover:underline">Login With Email</a>
                    </div>
                </div>
            </form>
        </div>
    @endslot
@endcomponent
