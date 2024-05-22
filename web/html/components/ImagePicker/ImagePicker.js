const dropArea = document.getElementById("drop-area");
const inputFile = document.getElementById("input-file");
const imageView = document.getElementById("img-view");

function uploadImage() {
    const file = URL.createObjectURL(inputFile.files[0]);
    imageView.style.backgroundImage = `url(${file})`;
    imageView.textContent = "";
    dropArea.style.border = 0;
    
    const formData = new FormData();
    formData.append("image", inputFile.files[0]);
    fetch("/components/ImagePicker/upload-image.php", {
        method: "POST",
        body: formData
    })
    .then(response => console.log(response))
}

inputFile.addEventListener("change", uploadImage);

dropArea.addEventListener("dragover", event => {
    event.preventDefault();
    dropArea.classList.add("image-picker__label--active");
});

dropArea.addEventListener("dragleave", event => {
    event.preventDefault();
    dropArea.classList.remove("image-picker__label--active");
});

dropArea.addEventListener("drop", event => {
    event.preventDefault();
    inputFile.files = event.dataTransfer.files;
    uploadImage();
});