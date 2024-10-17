import cloudinary from 'cloudinary-video-player/all';
import "cloudinary-video-player/cld-video-player.min.css";

let currentPublicId = null;
let watchDuration = 0;
let watchStartTime = null;
let isPlaying = false;

// Initialize the Cloudinary video player
const videoPlayer = document.getElementById('video-player');
const demoplayer = cloudinary.videoPlayer(videoPlayer, {
    cloudName: "de2fnaud6",
    controls: true, // Enable player controls
    playbackRates: [0.5, 1.0, 1.5, 2.0], // Add speed options
    showQualitySelector: true,
});

// Function to load video with public ID
window.loadNewVideo = function(public_id) {
    
    if (currentPublicId !== public_id) {
        // If the public_id changes, reset tracking
        currentPublicId = public_id;
        watchDuration = 0; // Reset watch duration
        isPlaying = false; // Reset play status
        console.log(`Loading new video: ${currentPublicId}`);
        
        // Load the video using Cloudinary Video Player
        demoplayer.source(public_id);
        console.log(videoPlayer.duration)
    }
}
function updateWatchHours(public_id, duration) {
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.getAttribute('content') : null;

    if (!csrfToken) {
        console.error("CSRF token not found. Cannot send request.");
        return;
    }

    fetch('/update-watch-hours', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ public_id: public_id, duration: duration })
    });
}

demoplayer.on('play', () => {
    if (!isPlaying) {
        watchStartTime = Date.now();
        isPlaying = true; // Set to playing
        console.log('Video is playing');
    }
});
demoplayer.on('pause', () => {
    if (isPlaying) {
        watchDuration += (Date.now() - watchStartTime) / 1000; // Add to watch duration in seconds
        isPlaying = false; // Set to paused
        console.log(`Total watch duration for ${currentPublicId}: ${watchDuration} seconds`);
        
        // Optionally send total watch duration to your backend here
        updateWatchHours(currentPublicId, watchDuration);
        watchDuration= 0;
    }
});


demoplayer.on('ended', () => {
    if (isPlaying) {
        watchDuration += (Date.now() - watchStartTime) / 1000; // Add to watch duration in seconds
        console.log(`Video has ended. Total watch duration for ${currentPublicId}: ${watchDuration} seconds`);
        
        // Send total watch duration to your backend
        updateWatchHours(currentPublicId, watchDuration);
        watchDuration= 0;
    }
});

demoplayer.on('seeked', (event) => {
    console.log('User performed seek operation.');
    // previousTime = event.target.currentTime; // Update previous time after seek
});

// Toggle visibility of elements (for hiding/showing elements dynamically)
window.toggleHidden = function(elem) {
    var element = document.querySelector("." + elem);
    element.classList.toggle("hidden");
}

