
//function to load signin page
function RedirectToSignin()
{
    window.location.href = '../Login/Login.html';
    
}
//function to load signup page
function RedirectToSignup()
{
    window.location.href = '../Signup/signup.html';
    
}


//this function use to check password length
function CheckPswLeng(event)
{
    //assign password value into a variable
    let psw = document.getElementById('new-password').value;

    //check length
    if(psw.length < 8)
    {
        //if length is less than 8,prevent submitting the form and display error.

        event.preventDefault();
        alert("Please enter valid Password");
        document.getElementById('ErrorMsg').innerHTML = "Password must have at least 8 characters"; 
    }
    else
    {
        document.getElementById('ErrorMsg').innerHTML = ""; 

    }
}
