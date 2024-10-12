document.addEventListener('DOMContentLoaded', function() {
    const fName = document.getElementById('fName');
    const lName = document.getElementById('lName');
    const uName = document.getElementById('uName');
    const email = document.getElementById('email');

    const darkBg = document.getElementById('dark_bg');
    const popupForm = document.getElementById('popup_form');
    const submitBtn = document.querySelector('.submitBtn');
    const modalTitle = document.querySelector('.modalTitle');

    const formInputFields = [fName, lName, uName, email];

    // Regular expressions for validation
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    // Function to open the popup form
    window.openPopup = function() {
        darkBg.classList.add('active');
        popupForm.classList.add('active');
    }

    // Function to close the popup form
    window.closePopup = function() {
        darkBg.classList.remove('active');
        popupForm.classList.remove('active');
        formInputFields.forEach(input => {
            input.value = ''; // Clear input fields on close
            input.disabled = false; // Enable them for new entry
        });
        document.getElementById('adminId').value = ''; // Reset adminId
        submitBtn.innerHTML = "Submit"; // Reset submit button text
        modalTitle.innerHTML = "Fill the Form"; // Reset modal title
    }

   

    window.readInfo = function(fname, lname, uname, emailValue) {
        fName.value = fname;
        lName.value = lname;
        uName.value = uname;
        email.value = emailValue;

        darkBg.classList.add('active');
        popupForm.classList.add('active');
        modalTitle.innerHTML = "Profile";
        submitBtn.style.display = 'none';
        formInputFields.forEach(input => {
            input.disabled = true; // Disable fields for profile view
        });
    }

    window.editInfo = function(adminId, fname, lname, uname, emailValue) {
        fName.value = fname;
        lName.value = lname;
        uName.value = uname;
        email.value = emailValue;

        // Store the userId in the hidden fields
        document.getElementById('adminId').value = adminId;

        darkBg.classList.add('active');
        popupForm.classList.add('active');
        submitBtn.innerHTML = "Update"; // Change button text
        submitBtn.style.display = 'block';
        modalTitle.innerHTML = "Edit Admin";
    }

    window.deleteUser = function(adminId) {
        if (confirm("Are you sure you want to delete this admin?")) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_admin.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                location.reload(); // Reload the page to reflect changes
            };
            xhr.send('admin_id=' + adminId);
        }
    }

    window.searchUser = function() {
        var searchQuery = document.getElementById('search').value;
        if (searchQuery.trim() === '') {
            alert('Please enter a search term');
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'search_admin.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            document.getElementById('eventsTableBody').innerHTML = this.responseText;
        };
        xhr.send('searchQuery=' + encodeURIComponent(searchQuery));
    }
});

 // Function to set error message
 function setError(element, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.style.color = 'red';
    errorDiv.textContent = message;
    element.parentElement.appendChild(errorDiv);
}

// Clear previous error messages
function clearErrors() {
    const errors = document.querySelectorAll('.error');
    errors.forEach(error => error.remove());
}

// Form validation function
function validateForm() {
    let isValid = true;

    // Clear previous error messages
    clearErrors();

    formInputFields.forEach(input => {
        if (input.value.trim() === '') {
            setError(input, `${input.name} is required.`);
            isValid = false;
        }
    });

    if (!emailPattern.test(email.value.trim())) {
        setError(email, "Please enter a valid email address.");
        isValid = false;
    }

    return isValid;
}

// Submit form with validation
document.getElementById('myForm').addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
