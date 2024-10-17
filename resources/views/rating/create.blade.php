<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rating & Review</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .star {
      cursor: pointer;
      transition: color 0.2s;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Rate this product</h2>

    <!-- Rating Stars -->
    <div class="flex justify-center mb-4">
      <span id="star1" class="star text-3xl text-gray-400" data-value="1">&#9733;</span>
      <span id="star2" class="star text-3xl text-gray-400" data-value="2">&#9733;</span>
      <span id="star3" class="star text-3xl text-gray-400" data-value="3">&#9733;</span>
      <span id="star4" class="star text-3xl text-gray-400" data-value="4">&#9733;</span>
      <span id="star5" class="star text-3xl text-gray-400" data-value="5">&#9733;</span>
    </div>



    <!-- Review Form -->
    <form id="reviewForm" class="space-y-4" action="/rating" method="POST">
      @csrf
      <input type="hidden" id="rating" name="rating" value="0">
      @error('rating')
          <p class="text-red-500 text-sm">{{$message}}</p>
      @enderror

      <textarea id="review" name="review" rows="4" placeholder="Write your review (optional)" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      @error('review')
          <p class="text-red-500 text-sm">{{$message}}</p>
      @enderror
      <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
        Submit Review
      </button>
    </form>

    <div id="successMessage" class="hidden mt-4 text-green-600 text-center">
      Thank you for your review!
    </div>
  </div>

  <script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    let selectedRating = 0;

    stars.forEach(star => {
      star.addEventListener('mouseover', function () {
        const value = this.getAttribute('data-value');
        highlightStars(value);
      });

      star.addEventListener('mouseout', function () {
        highlightStars(selectedRating);
      });

      star.addEventListener('click', function () {
        selectedRating = this.getAttribute('data-value');
        ratingInput.value = selectedRating;
      });
    });

    function highlightStars(rating) {
      stars.forEach(star => {
        if (star.getAttribute('data-value') <= rating) {
          star.classList.add('text-yellow-500');
          star.classList.remove('text-gray-400');
        } else {
          star.classList.add('text-gray-400');
          star.classList.remove('text-yellow-500');
        }
      });
    }

    document.getElementById('reviewForm').addEventListener('submit', function (e) {
      e.preventDefault(); 
      
      const ratingValue = ratingInput.value;
      const reviewText = document.getElementById('review').value;

      if (ratingValue === "0") {
        alert("Please select a rating.");
        return;
      }

      // Placeholder for handling the form submission (e.g., AJAX call)
      console.log(`Rating: ${ratingValue}, Review: ${reviewText}`);

      // Display success message
      document.getElementById('reviewForm').submit();
    });
  </script>
</body>
</html>
