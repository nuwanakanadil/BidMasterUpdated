// Ensure DOM elements are loaded before executing script
document.addEventListener("DOMContentLoaded", function() {
    const password = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    togglePassword.addEventListener("change", function() {
        // Toggle password visibility
        if (togglePassword.checked) {
            password.type = "text";
        } else {
            password.type = "password";
        }
    });
});


//function to load signup page
function RedirectToSignup()
{
    window.location.href = '../Signup/signup.html';
    
}
//function to load signin page
function RedirectToSignin()
{
    window.location.href = 'Login.html';
    
}

