@component('auth')
    @slot('title')
        Login
    @endslot

    @slot('content')
        <div class="">
            <form action="/login" method="POST">
                @csrf
                <div class="w-[30%] m-auto bg-white shadow-lg rounded-lg p-8 flex flex-col">
                    <h2 class="text-2xl font-semibold text-center mb-6">LOG IN</h2>
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
                    <div class="mb-4">
                        <input type="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Email" name="email">
                            @error('email')
                                <p class="text-red-500 text-sm">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="mb-4">
                        <input type="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Password" name="password">
                            @error('password')
                                <p class="text-red-500 text-sm">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="mb-6 text-right">
                        <a href="#" class="text-sm text-blue-500 hover:underline">Forgot Password?</a>
                    </div>
                    <div class="mb-4">
                        <button type="submit"  class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-md">Login</button>
                    </div>
                    <div class="text-center">
                        <a href="/signup" class="text-sm text-blue-500 hover:underline">Sign Up With Email</a>
                    </div>
                </div>
            </form>
        </div>
    @endslot
@endcomponent
