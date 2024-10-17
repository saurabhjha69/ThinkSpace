window.previewPhoto = function (input, imageid) {
    const file = input.files;
    if (file) {
        const fileReader = new FileReader();
        const preview = document.getElementById(imageid);
        fileReader.onload = function (event) {
            preview.setAttribute("src", event.target.result);
        };
        fileReader.readAsDataURL(file[0]);
    }
};
