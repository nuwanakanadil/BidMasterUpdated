
//JavaScript event listener that waits for the entire HTML document to be fully loaded and parsed.
document.addEventListener('DOMContentLoaded',function()
{
    //add event listener to detect form submit event

    document.getElementById('form').addEventListener('submit', function (event) {

        // Get form values and assign thos values into variables.

        const firstName = document.getElementById('first-name').value.trim();
        const lastName = document.getElementById('last-name').value.trim();
        const userName = document.getElementById('user-name').value.trim();
        const email = document.getElementById('email').value.trim();
        const address = document.getElementById('address').value.trim();
        const nic = document.getElementById('nic').value.trim();
        const phoneNumber = document.getElementById('phone-number').value.trim();
        const password = document.getElementById('password').value.trim();
        const rePassword = document.getElementById('re-password').value.trim();
        const termsAccepted = document.getElementById('terms').checked;

         //call CheckPswLenght() fucntion
            CheckPswLenght(event);


        // Regular expressions for Email and phone number validation

        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const phonePattern = /^[0-9]{10}$/;

        //declare error message variable.

        let errorMessage = '';

        // Validate first name
        if (firstName === '') {
            errorMessage += 'First name is required.\n';
        }

        // Validate last name
        if (lastName === '') {
            errorMessage += 'Last name is required.\n';
        }

        // Validate user name
        if (userName === '') {
            errorMessage += 'User name is required.\n';
        }

        // Validate email
        if (!emailPattern.test(email)) {
            errorMessage += 'Please enter a valid email address.\n';
        }

        // Validate address
        if (address === '') {
            errorMessage += 'Address is required.\n';
        }

        // Validate NIC
        if (nic === '') {
            errorMessage += 'NIC is required.\n';
        }

        // Validate phone number
        if (!phonePattern.test(phoneNumber)) {
            errorMessage += 'Please enter a valid 10-digit phone number.\n';
        }
        //Check password and Re-enter password
        
        if (password !== rePassword) {
            // Display error message
            errorMessage += 'Password and re-entered password are not.\n';
        } 

        // Validate terms and conditions
        if (!termsAccepted) {
            errorMessage += 'You must accept the Terms & Conditions.\n';
        }

        if(CheckPswLenght())
        {
            errorMessage += "Invalid psw.";
        }

        // Display error messages and prevent form submission if validation fails
        if (errorMessage !== '') {
            alert(errorMessage);
            event.preventDefault(); // Prevent form from submitting
        }

        else
        {
  
            let username = document.getElementById('user-name').value;

            //give an alert to user
            alert(`Hello ${username}! You Already there.Click ok to continue`);

        }
    });

    
})



//this function use to check password length

function CheckPswLenght(event)
{
    //assign password value into a variable

    let psw = document.getElementById('password').value;

    //check length

    if(psw.length < 8)
    {
        //if length is less than 8,prevent submitting the form and display error.

        event.preventDefault();
        alert("Please enter valid Passwrod");
        document.getElementById('ErrorMsg').innerHTML = "Password must have at least 8 characters"; 
    }
    else
    {
        document.getElementById('ErrorMsg').innerHTML = ""; 

    }
}


//function to load signup page
function RedirectToSignup()
{
    window.location.href = 'signup.html';
    
}
//function to load signin page
function RedirectToSignin()
{
    window.location.href = '../Login/Login.html';
}