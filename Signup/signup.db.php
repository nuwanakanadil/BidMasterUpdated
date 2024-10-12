<?php

// Require autoload.php from Composer to autoload the PHPMailer classes to send emails.
//composer is a dependency manager for the PHP programming language that provides standard libraries.
//we have installed Composer and phpmailer library to our project.
//All the files and codes in vendor folder and all the codes in Composer.json,composer.lock  are not our own codes.
//Those files and codes are from Composer and PHPMailer installation proccess.
//PHPMailer is a php library use to send emails

require '../vendor/autoload.php';

// Use namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../config.php';
require_once '../functions.php';

if (isset($_POST["submit"])) {
    // Assign user-entered values to PHP variables
    $fname = $_POST["first-name"];
    $lname = $_POST["last-name"];
    $username = $_POST["user-name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $nic = $_POST["nic"];
    $phone_number = $_POST["phone-number"];
    $psw = $_POST["password"];
    $Reenterpsw = $_POST["re-password"];

    // Instantiation of PHPMailer
    $mail = new PHPMailer(true);

    // Calling error handling functions with parameters and assigning returned values of error handling functions to PHP variables
    $emptyInput = emptyInputSignup($fname, $lname, $username, $email, $address, $nic, $phone_number, $psw, $Reenterpsw);
    $invalidUid = invalidUid($username);
    $invalidEmail = invalidEmail($email);
    $pswmatch = pswmatch($psw, $Reenterpsw);
    $userNameExists = checkUsernameExists($username, $conn);
    $PasswordExists = checkPasswordExists($psw, $conn);

    // Error handling
    if ($emptyInput !== false) {
        echo "<script>alert('emptyinputs');
        window.location.href = './signup.html';
        </script>";
        exit();
    }
    if ($invalidUid !== false) {
        echo "<script>alert('Invalid UID');
        window.location.href = './signup.html';
        </script>";
        exit();
    }
    if ($invalidEmail !== false) {
        echo "<script>alert('Invalid Email');
        window.location.href = './signup.html';
        </script>";
        exit();
    }
    if ($pswmatch !== false) {
        echo "<script>alert('re-enter password is incorrect');
        window.location.href = './signup.html';
        </script>";
        exit();
    }
    if ($userNameExists !== false) {
        echo "<script>alert('User name is already taken. Use a different name'); 
        window.location.href = './signup.html';
        </script>";
        exit();
    }
    if ($PasswordExists !== false) {
        echo "<script>alert('Password is already taken. Use a different password');
        window.location.href = './signup.html';
        </script>";
        exit();
    }

    // Hash the password before saving it to the database
    $hashed_password = password_hash($psw, PASSWORD_DEFAULT);

    // Create SQL query and execute it using mysqli
    $sql = "INSERT INTO RegisteredBidder (F_Name, L_Name, UserName, Email, Address, NIC, Phone_No, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $fname, $lname, $username, $email, $address, $nic, $phone_number, $hashed_password);

    if (!$stmt->execute()) {
        // If there is an error in executing the SQL query, print the error
        die("Error: " . $stmt->error);
    } else {
        // Create email template and its configurations

        //These email related functions are not our own codes.
        //Those functiones are provided by PHPMailer library to access their service.
        //And we have used Brevo mail service to send mails to users.
        //Those brevo account credentials are used to connect Brevo SMTP Server. 
        // https://www.brevo.com/
        //https://app.brevo.com/settings/keys/smtp

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';  // Brevo SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = '7c3967001@smtp-brevo.com';  // Brevo username
            $mail->Password = 'LOGtfDadpWBzYjhE';  // Brevo password
            $mail->SMTPSecure = 'tls';  // Enable TLS encryption
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('wwwabcdef577@gmail.com', 'BidMaster');
            $mail->addAddress($email, $username);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to BIDMASTER - Thank You for Registering!';
            $mail->Body = "
            <!DOCTYPE html>
            <html lang=\"en\">
            <body style=\"font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;\">

                <div style=\"max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 10px;\">
                    <h2 style=\"color: #0056b3;font-size: 20px;text-align:center;\">Welcome to <b>BIDMASTER!</b></h2>
                    <p style = \"font-size: 15px;\">Hi <strong>$username</strong>,</p>
                    <p style = \"font-size: 15px;\">Thank you for joining <b>BIDMASTER</b>! We are excited to have you on board.</p>
                    <p style = \"font-size: 15px;\">You can now access your account and start exploring all the features we offer. Feel free to reach out if you have any questions or need any assistance.</p>
                    <h3 style=\"color: black;font-size: 15px;\">Here's what you can do next:</h3>
                    <ul style = \"font-size: 15px;\">
                        <li>Complete your profile</li>
                        <li>Browse through our products/services</li>
                        <li>Participate in upcoming auctions (if applicable)</li>
                    </ul>
                    <p style = \"font-size: 15px;\">We hope you enjoy your experience with us. If you have any issues, don't hesitate to contact our support team.</p>
                    <p style=\"color: #777;\">Best regards, <br> BIDMASTER</p>
                    <hr style=\"border: 1px solid #ddd;\">
                    <p style=\"font-size: 12px; color: #999;\">You are receiving this email because you recently signed up for BIDMASTER. If this was not you, please contact us.</p>
                </div>

            </body>
            </html>";

            // Send the email
            $mail->send();

        } catch (Exception $e) {
            // If there is an error in sending the email
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Give an alert to the user that registration was successful and redirect to the login page
        echo "<script>alert('Successfully Registered. Please check your email for confirmation.');
        window.location.href = '../Login/Login.html';
        </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
