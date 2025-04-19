document.querySelectorAll(".cam").forEach(button => {
    button.addEventListener("click", function() {
        document.getElementById("cameraInput").click();
    });
});

document.getElementById("imageInput").addEventListener("change", function(event) {
    const file = event.target.files[0]; // Get uploaded file
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById("imagePreview");
            img.src = e.target.result; // Set image source
            img.style.display = "block"; // Show image
        };
        reader.readAsDataURL(file); // Convert file to base64
    }
});


document.querySelectorAll(".expandableText").forEach(element => {
    element.addEventListener("click", function() {
        this.classList.toggle("expanded");
    });
});
