const dropArea = document.getElementById("drop-area");
const inputFile = document.getElementById("input-file");
const imageView = document.getElementById("img-view");
const imageName = document.getElementsByName("file-name")[0];

// Function to set default image
function setDefaultImage(src) {
    imageView.style.backgroundImage = `url(${src})`;
    imageView.textContent = "";
    dropArea.style.border = 0;
}

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
        .then(response => response.json())
        .then(data => {
            imageName.textContent = data.file_name;
        });
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
    // check if the file is an image
    if (event.dataTransfer.files[0].type.indexOf("image") === -1) {
        return;
    }
    inputFile.files = event.dataTransfer.files;
    uploadImage();
});

// Add click event to open file dialog
dropArea.addEventListener("click", () => {
    inputFile.click();
});

// Set default image if provided
document.addEventListener("DOMContentLoaded", () => {
    const defaultImage = imageView.dataset.defaultImage;
    if (defaultImage) {
        setDefaultImage(defaultImage);
    }
});
