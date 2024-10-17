import cloudinary from 'cloudinary-video-player/all';
import "cloudinary-video-player/cld-video-player.min.css";

let currentPublicId = null;
let watchDuration = 0;
let watchStartTime = null;
let isPlaying = false;
let submodule_id = document.getElementById('modules_container').getAttribute('default-module');
let isCompleted = document.getElementById('modules_container').getAttribute('is_completed');
console.log("SubModule = "+submodule_id);

// Initialize the Cloudinary video player
const videoPlayer = document.getElementById('video-player');
currentPublicId = videoPlayer.getAttribute('publicid');
const demoplayer = cloudinary.videoPlayer(videoPlayer, {
    cloudName: "de2fnaud6",
    controls: true,
    playbackRates: [0.5, 1.0, 1.5, 2.0],
    showQualitySelector: true,
    playedEventTimes: [60, 120, 180]
});
demoplayer.source(currentPublicId);

// Mark submodule as complete
window.markAsComplete = function(submodule_id) {
    console.log('checked');
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
        body: JSON.stringify({ submodule_id})
    }).then(() => {
        setTimeout(() => {
            location.reload();
        }, 1000);
    });
};

// Load a new video with public ID
window.loadNewVideo = function(param) {
    const [public_id, submodule] = param;
    submodule_id = submodule;
    console.log("after video load: "+submodule_id);
    document.getElementById('submodule_comment').value = submodule_id;
    // document.getElementById('loadcomment').setAttribute('href','/comment/'+submodule_id);



    // console.log(demoplayer.video.currentTime);


    if (currentPublicId !== public_id) {
        currentPublicId = public_id;
        watchDuration = 0;
        isPlaying = false;
        console.log(`Loading new video: ${currentPublicId}`);
        demoplayer.source(public_id);
    }
};



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
        body: JSON.stringify({ public_id, duration })
    });
}

demoplayer.on('play', () => {
    if (!isPlaying) {
        watchStartTime = Date.now();
        isPlaying = true;
        console.log('Video is playing');
    }
});

demoplayer.on('pause', () => {
    if (isPlaying) {
        watchDuration += (Date.now() - watchStartTime) / 1000;
        isPlaying = false;
        console.log(`Total watch duration for ${currentPublicId} is : ${watchDuration} seconds`);
        updateWatchHours(currentPublicId, watchDuration);
        watchDuration = 0;

    }
});

demoplayer.on('ended', () => {

        watchDuration += (Date.now() - watchStartTime) / 1000;
        console.log(`Video has ended. Total watch duration for ${currentPublicId}: ${watchDuration} seconds`);
        updateWatchHours(currentPublicId, watchDuration);
        console.log(isCompleted)
        if(isCompleted == "false"){
            markAsComplete(submodule_id)
        }
        isPlaying = false;
        console.log('Video has ended');
});


demoplayer.on('seeked', () => {
    console.log('User performed seek operation.');
});

window.toggleHidden = function(elem) {
    document.querySelector("." + elem).classList.toggle("hidden");
};


function toggle(idname,id) {
    var comment = document.getElementById(idname+id);
    var saveBtn = document.getElementById('saveEditedCommentBtn'+id);
    var editBtn = document.getElementById('editCommentBtn'+id);



    if (comment.disabled) {
        // Enable the comment field
        comment.disabled = false;
        saveBtn.classList.remove("hidden");
        editBtn.innerHTML = "Cancel";
        comment.style.border = "1px solid white";
        comment.style.borderRadius = "5px";
        comment.style.padding = "5px";
        comment.focus();


    } else {
        // Disable the comment field
        comment.disabled = true;
        saveBtn.classList.add("hidden");
        editBtn.innerHTML = "Edit";
        comment.style.border = ""; // Remove the styles when disabled
        comment.style.padding = ""; // Reset padding
    }
}


window.editComment = function(idname,id) {
    // this.innerHTML = "";
    toggle(idname,id);
}
