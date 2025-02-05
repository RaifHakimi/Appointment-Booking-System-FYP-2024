<?php
session_start();

 // If no session role is set, stay on the index.php page (login/signup page)
if(isset($_SESSION['role']) === false) {
    
    
} else {
  if ($_SESSION['role'] === 'patient') {
    echo "<script>
        setTimeout(function() {
            window.location.href = 'dashboard.php'; // Redirect to patient dashboard
        }, 2000); // Redirect after 2 seconds
    </script>";
    exit();
} elseif ($_SESSION['role'] === 'admin') {
    echo "<script>
        setTimeout(function() {
            window.location.href = 'adminApptView.php'; // Redirect to admin appointments view
        }, 2000);
    </script>";
    exit();
} elseif ($_SESSION['role'] === 'doctor') {
    echo "<script>
        setTimeout(function() {
            window.location.href = 'docSchedule.php'; // Redirect to doctor schedule
        }, 2000);
    </script>";
    exit();
} else {
    echo "<script>
        setTimeout(function() {
            window.location.href = 'index.php'; // Redirect to staff schedule
        }, 2000);
    </script>";
    exit();
}
}


?>

<!DOCTYPE html>
<html lang="en">
<!-- This is the login page for the Sin Nam Medical Hall application. -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sin Nam Medical Hall</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the box with increased size */
        .center-box {
            max-width: 600px;
            /* Increased width */
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Full-width red banner */
        .banner {
            background-color: #8A3C3C;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            width: 100%;
        }

        /* Custom button styling */
        .btn-signup {
            background-color: #8A3C3C;
            color: white;
            border-radius: 20px;
        }

        .btn-login {
            color: #8A3C3C;
            border: 1px solid #8A3C3C;
            border-radius: 20px;
        }

        .f-pass {
            color: #8A3C3C;
            font-size: small;
        }

        .go-back {
            color: #8A3C3C;
            font-size: medium;
        }
        /* Style for gender buttons */
        .btn-gender {
            flex: 1;
            /* Equal width */
            margin: 5px;
            /* Space between buttons */
            color: #8A3C3C;
            border: 1px solid #8A3C3C;

        }

        .btn-gender.selected {
            background-color: #8A3C3C;
            color: white;
        }

        .gender-buttons {
            display: flex;
            /* Flexbox for equal size */
        }

        .text-border {
            border: 1px solid #8A3C3C;
        }

        .form-container {
            display: none;
            /* Hide forms initially */
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container.active {
            display: block;
            /* Only the active form is displayed */
        }
    </style>
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">


<div>
    <div class="center-box text-center ">
        
        <!-- Full-Width Banner -->
        <div class="banner">
            
            SIN NAM MEDICAL HALL
        </div>

        <!-- Content inside the box with added padding -->
        <div class="p-5 form-container active"  id="login-form" > <!-- Increased padding -->
            <h1 class="mb-3">Log In</h1>

            <!-- Input fields -->


            <form method="POST" action="doLogin.php">
                <div class="col mb-2">
                    <div class="d-flex justify-content-start">
                        <label for="name1" class="form-label">Phone Number</label>
                    </div>
                    <input type="text" class="form-control text-border" id="PhoneNumber" name="phonenumber"
                        placeholder="Enter phone number" required>
                </div>

                <div class="col mb-3">
                    <div class="d-flex justify-content-start">
                        <label for="name1" class="form-label">Password</label>
                    </div>
                    <input type="text" class="form-control text-border" id="password" placeholder="Enter password" name="password"
                        required>
                    <div class="d-flex justify-content-start">
                        <a href="#" class="f-pass" onclick="toggleForms()">Forgot password?</a>
                    </div>
                </div>

                <div class="mt-4 d-grid gap-3">
                    <button class="btn-signup" type="submit">
                        Log In
                    </button>
                </div>

            </form>
            <div class="d-flex justify-content-center mt-4">
                <a href="index.php" class="go-back" >Go back</a>
            </div>

        </div>
    </div>



    <div id="forgot-pass" class="form-container ">
        <form>
            <div class="col mb-3">
                <div class="d-flex justify-content-start">
                    <label for="name1" class="form-label">Phone Number</label>
                </div>
                <input type="text" class="form-control text-border" id="password" placeholder="Enter phone number"
                    required>
                
            </div>

            <div class="mt-4 d-grid gap-3">
                <button class="btn-signup" type="submit">
                    Change Password
                </button>
            </div>
            <p><a href="#" class="f-pass" onclick="toggleForms()">Back to Login</a></p>
        </form>

    </div>


    <script>
        function toggleForms() {
            const loginForm = document.getElementById('login-form');
            const forgotPasswordForm = document.getElementById('forgot-pass');

            loginForm.classList.toggle('active');
            forgotPasswordForm.classList.toggle('active');
        }
    </script>


    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




</div>
</body>

</html>