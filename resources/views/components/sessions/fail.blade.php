@if (session('fail'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('ratingfail') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <path
                    d="M14.348 14.849a1 1 0 01-1.414 0L10 11.415l-2.935 2.934a1 1 0 11-1.414-1.414L8.586 10 5.651 7.065a1 1 0 011.414-1.414L10 8.586l2.934-2.935a1 1 0 111.414 1.414L11.415 10l2.933 2.934a1 1 0 010 1.415z" />
            </svg>
        </span>
    </div>
@endif
