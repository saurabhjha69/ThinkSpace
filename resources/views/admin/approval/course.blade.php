<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Approval Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="container mx-auto max-w-xl bg-white shadow-lg rounded-lg p-6">
        <!-- Course Thumbnail -->
        <div class="">
            <img src="{{ $course->thumbnail_url }}" alt="Course Thumbnail" class="w-full h-56 object-cover rounded-md">
            <div class="ml-4">
                <!-- Course Title -->
                <h1 class="text-2xl font-bold text-gray-800">{{ $course->name }}</h1>
                <!-- Course Description -->
                <p class="text-gray-600 mt-2">{{ $course->description }}</p>
                <h1 class="text-sm font-bold text-gray-800">Start Date: {{ App\Helper\Helper::formatDateTime($course->start_date) }}</h1>
                <h1 class="text-sm font-bold text-gray-800">End Date: {{ App\Helper\Helper::formatDateTime($course->start_date) }}</h1>
                
            </div>
        </div>

        <!-- Course Details -->
        <div class="mt-6 grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Number of Modules</h3>
                <p class="text-gray-600 mt-1">{{ $course->modules->count() }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Number of Tests</h3>
                <p class="text-gray-600 mt-1">{{ $course->quizzes->count() }}</p>
            </div>
        </div>
        <!-- Past Approval Requests  -->
        @if ($course->approvalLogs()->count() > 0)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700">Past Approval Requests</h3>
                @foreach ($course->approvalLogs() as $logs)

                    <div class="{{ $logs->user_id ? 'pl-10' : 'mt-2 bg-blue-200' }} ">
                        <div class=" p-4 rounded-lg shadow-md mb-4">
                            <p class="text-gray-600">Request ID: {{ $logs->id }}</p>
                            <p class="text-gray-600">Status: {{ $logs->status }}</p>
                            @if ($logs->reason)

                            <p class="text-gray-600">Reason: {{ $logs->reason }}</p>
                            @endif
                            <p class="text-gray-600">Created At: {{ $logs->created_at }}</p>
                            <p class="text-gray-600">{{ $logs->user_id  ? 'Reviewed By Admin' : 'Request By Instructor'}}</p>
                        </div>

                    </div>
                @endforeach
                <!-- End of Past Approval Requests -->
            </div>
        @endif

        <!-- Reason for Approval/Reject -->
        <form action="/approve-course/{{ $course->id }}" method="POST" class="">
            @csrf
            <div class="mt-6">
                <label for="reason" class="block text-lg font-semibold text-gray-700">Reason for Approval/Rejection</label>
                <textarea id="reason" name="reason" rows="4" class="mt-2 w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter your reason..."></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-end space-x-4">

                <input type="submit" name="status" value="Approve"
                    class="bg-green-500 cursor-pointer text-white px-4 py-2 rounded-md">
                <input type="submit" name="status" value="Reject"
                    class="bg-red-500 cursor-pointer text-white px-4 py-2 rounded-md">
            </div>
        </form>
    </div>


</body>

</html>
