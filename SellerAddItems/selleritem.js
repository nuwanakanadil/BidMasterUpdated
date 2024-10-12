document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onloadend = function() {
        document.getElementById('image').value = reader.result; // Set base64 string in hidden input
    };

    if (file) {
        reader.readAsDataURL(file);
    }
});

document.getElementById('addItemForm').addEventListener('submit', function (e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // For demonstration purposes, just log the form data
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    
    alert('Item added successfully!');
    this.reset();  // Reset the form after submission
    document.getElementById('imagePreview').innerHTML = ''; // Clear the image preview
});

function redirectToHome()
{
    window.location.href = '../home.html';
}