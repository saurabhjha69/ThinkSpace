<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Rating</title>
  <script src="https://cdn.tailwindcss.com"></script>
  
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Rate Course Button -->
  <button id="rateCourseBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Rate Course</button>

  <!-- Rating Modal (Hidden by default) -->
  <div id="ratingModal" class="fixed inset-0 z-10 bg-gray-800 bg-opacity-75 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-lg">
      <h2 class="text-lg font-bold mb-4">Rate this Course</h2>
      
      <!-- Star Rating -->
      <div class="flex mb-4">
        <span class="star text-gray-400 text-3xl" data-value="1">&#9733;</span>
        <span class="star text-gray-400 text-3xl" data-value="2">&#9733;</span>
        <span class="star text-gray-400 text-3xl" data-value="3">&#9733;</span>
        <span class="star text-gray-400 text-3xl" data-value="4">&#9733;</span>
        <span class="star text-gray-400 text-3xl" data-value="5">&#9733;</span>
      </div>

      <!-- Content (Optional) -->
      <textarea id="reviewContent" class="w-full p-2 border border-gray-300 rounded-lg mb-4" rows="4" placeholder="Leave your review (optional)"></textarea>

      <!-- Submit Button -->
      <button id="submitReview" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Submit Review</button>

      <!-- Close Button -->
      <button id="closeModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
    </div>
  </div>


</body>
</html>
