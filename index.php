

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
<!-- STARTING PAGE -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sin Nam Medical Hall</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Center the box with increased size */
    .center-box {
      max-width: 500px; /* Increased width */
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
  </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

  <div class="center-box text-center">
    <!-- Full-Width Banner -->
    <div class="banner">
      SIN NAM MEDICAL HALL
    </div>
    
    <!-- Content inside the box with added padding -->
    <div class="p-5"> <!-- Increased padding -->
      <h3 class="mt-2">Welcome to Sin Nam Medical Hall Online</h3>
      
      <!-- Buttons -->
      <div class="mt-4 d-grid gap-3">
        <button type="button" class="btn btn-signup" onclick="location.href='signup.php'">Sign Up</button>
        <button type="button" class="btn btn-login" onclick="location.href='login.php'">Log In</button>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
