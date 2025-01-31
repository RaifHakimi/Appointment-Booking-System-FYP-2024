<!DOCTYPE html>
<?php
/** Used to display the doctor's schedule for the day.
 * 
 */
session_start();
include("dbFunctions.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    // Display an alert and redirect
    echo "<script>
        alert('Access Restricted. You must be logged in as a doctor to access this page.');
        window.location.href = 'index.php';
    </script>";
    exit(); // Ensure no further code is executed
}


// Fetch today's appointments using MySQLi
$date = date("Y-m-d"); // Get today's date
$query = "SELECT * FROM appointment WHERE appt_date = '$date'";
$result = mysqli_query($link, $query);

if ($result) {
    $appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // Do something with the appointments
} else {
    die("Query failed: " . mysqli_error($link));
}
// only viewable if doctor role yet to be coded
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doc Schedule</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .appointment-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      background-color: #fff;
    }

    .date-section {
      font-weight: bold;
      color: black;
    }

    .day-sect {
      font-weight: bold;
      color: red;
      
    }

    .btn-custom {
      border: 1px solid red;
      color: red;
    }

    .btn-custom:hover {
      background-color: red;
      color: white;
    }

    .nav-link.active {
      font-weight: bold;
      color: red !important;
    }
  </style>
</head>

<body>

  <!-- Navigation -->
  <div class="navbar">
    <div class="logo">LOGO</div>
    <div class="nav-links">
      <a href="#">Patients</a>
      <div class="separator"></div>
      <a href="#" class="active">Appointments</a>
      <div class="separator"></div>
      <a href="#">Medication</a>
    </div>
    
    <a href="settings.php" class="button">
        <i class="settings">⚙️</i>Settings
    </a>
    </div>
    <div class="container mt-5">
    <h3>Appointments for Today</h3>
    <div id="appointments-list">
        <?php
        // Dummy users table




$appointments_today = array_filter($appointments, function($app) {
    return $app['appt_date'] === date("Y-m-d");
});

if (empty($appointments_today)) {
    echo "<p>No appointments for today.</p>";
} else {
    foreach ($appointments_today as $app) {
                if (!isset($link)) {
    include("dbFunctions.php"); // Ensure this file sets up $link properly
}

// Query to fetch user data
$user_id = 1; // Example user ID
$query = "SELECT username FROM users WHERE user_id = $user_id";
$result = mysqli_query($link, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result); // Fetch a single row
    $username = $user['username']; // Bind the username to the variable
} else {
    die("Query failed: " . mysqli_error($link));
}

                
        
        
                echo "
    </div>
    <div class='container mt-4'>
        <!-- Appointment Cards -->
        <div class='appointment-card d-flex border rounded p-3 mb-3'>
            <div class='date-section text-center me-3'>
                <div>" . date("m", strtotime($app['appt_date'])) . "<br>" . date("Y", strtotime($app['appt_date'])) . "</div>
                <div class='fs-1'>" . date("d", strtotime($app['appt_date'])) . "</div>
                <div>" . strtoupper(date("D", strtotime($app['appt_date']))) . "</div>
            </div>
            <div class='flex-grow-1'>
                <h5>Doctor Consult</h5>
                <p>Booked for <span class='text-muted'>{$username}</span></p>
                <p class='text-danger'>{$app['appt_time']}</p>
            </div>
            <div class='d-flex flex-column'>
                <a href='details.php?appt_id={$app['appt_id']}&user_id={$app['user_id']}' class='btn btn-custom mb-3'>Details</a>
                <a href='markComplete2.php?appt_id={$app['appt_id']}' class='btn btn-custom'>Medicine/Mark as Completed</a>
            </div>
        </div>
    </div>
";
            }
        }
        
        ?>
    </div>
</div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
