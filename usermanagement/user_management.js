document.addEventListener('DOMContentLoaded', function() {
    const fName = document.getElementById('fName');
    const lName = document.getElementById('lName');
    const uName = document.getElementById('uName');
    const position = document.getElementById('position');
    const email = document.getElementById('email');
    const address = document.getElementById('address');
    const nic = document.getElementById('nic');
    const phone = document.getElementById('phone');

    const darkBg = document.getElementById('dark_bg');
    const popupForm = document.getElementById('popup_form');
    const submitBtn = document.querySelector('.submitBtn');
    const modalTitle = document.querySelector('.modalTitle');

    const formInputFields = [fName, lName, uName, position, email, address, nic, phone];

    // Regular expressions for validation
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    const nicPattern = /^[0-9]{9}[vVxX]$/; // Example for a NIC format
    const phonePattern = /^[0-9]{10}$/;

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
        document.getElementById('userId').value = ''; // Reset userId
        submitBtn.innerHTML = "Submit"; // Reset submit button text
        modalTitle.innerHTML = "Fill the Form"; // Reset modal title
    }

   

    window.readInfo = function(fname, lname, uname, positionValue, emailValue, addressValue, nicValue, phoneValue) {
        fName.value = fname;
        lName.value = lname;
        uName.value = uname;
        position.value = positionValue;
        email.value = emailValue;
        address.value = addressValue;
        nic.value = nicValue;
        phone.value = phoneValue;

        darkBg.classList.add('active');
        popupForm.classList.add('active');
        modalTitle.innerHTML = "Profile";
        submitBtn.style.display = 'none';
        formInputFields.forEach(input => {
            input.disabled = true; // Disable fields for profile view
        });
    }

    window.editInfo = function(userId, fname, lname, uname, positionValue, emailValue, addressValue, nicValue, phoneValue) {
        fName.value = fname;
        lName.value = lname;
        uName.value = uname;
        position.value = positionValue;
        email.value = emailValue;
        address.value = addressValue;
        nic.value = nicValue;
        phone.value = phoneValue;

        // Store the userId in the hidden fields
        document.getElementById('userId').value = userId;

        darkBg.classList.add('active');
        popupForm.classList.add('active');
        submitBtn.innerHTML = "Update"; // Change button text
        submitBtn.style.display = 'block';
        modalTitle.innerHTML = "Edit User";
    }

    window.deleteUser = function(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_user.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                location.reload(); // Reload the page to reflect changes
            };
            xhr.send('Bidder_Id=' + userId);
        }
    }

    window.searchUser = function() {
        var searchQuery = document.getElementById('search').value;
        if (searchQuery.trim() === '') {
            alert('Please enter a search term');
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'search_user.php', true);
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

    if (!nicPattern.test(nic.value.trim())) {
        setError(nic, "Please enter a valid NIC.");
        isValid = false;
    }

    if (!phonePattern.test(phone.value.trim())) {
        setError(phone, "Phone number must be 10 digits.");
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
