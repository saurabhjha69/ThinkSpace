const rateCourseBtn = document.getElementById("rateCourseBtn");
const ratingModal = document.getElementById("ratingModal");
const closeModal = document.getElementById("closeModal");
const stars = document.querySelectorAll(".star");
const submitReview = document.getElementById("submitReview");
let selectedRating = 0;

// Open modal when Rate Course button is clicked
window.rateCourse = function () {
    ratingModal.classList.remove("hidden");
};

window.closeRateCourse = function () {
    ratingModal.classList.add("hidden");
};

// Handle star rating
stars.forEach((star) => {
    star.addEventListener("click", () => {
        selectedRating = star.getAttribute("data-value");
        // Reset all stars
        stars.forEach((s) => s.classList.remove("selected"));
        // Highlight selected stars
        for (let i = 0; i < selectedRating; i++) {
            stars[i].classList.add("selected");
        }
    });
});

// Handle review submission
// submitReview.addEventListener("click", () => {
//     const reviewContent = document.getElementById("reviewContent").value;
//     console.log("Rating:", selectedRating);
//     console.log("Review Content:", reviewContent);

//     // Here you would send the data to your backend for processing

//     // Close the modal after submission
//     ratingModal.classList.add("hidden");
// });

window.submitReview = function(course_id,user_id) {
    
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.getAttribute('content') : null;

    if (!csrfToken) {
        console.error("CSRF token not found. Cannot send request.");
        return;
    }
    const reviewContent = document.getElementById("reviewContent").value;
    console.log("Rating:", selectedRating);
    console.log("Review Content:", reviewContent);

    fetch(`/rate-course/${course_id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ rating: selectedRating, review: reviewContent, user_id : user_id})
    });
    ratingModal.classList.add("hidden");
    setInterval(() => {
        location.reload();
    }, 1000);
}

window.markAsComplete = function(course_id,module_id,submodule_id,user_id){
    console.log('checked')
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.getAttribute('content') : null;
    if (!csrfToken) {
        console.error("CSRF token not found. Cannot send request.");
        return;
    }
    fetch('/mark-submodule-complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ course_id: course_id, module_id: module_id,submodule_id: submodule_id, user_id : user_id})
    });
    setInterval(() => {
        location.reload();
    }, 1000);
}