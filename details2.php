<?php
/**
 * ?
 */
// Start the session and include database connection
session_start();
include("dbFunctions.php");

// Get the user_id and appt_id from the query string
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$appt_id = isset($_GET['appt_id']) ? $_GET['appt_id'] : null;

// Validate the inputs
if ($user_id === null || $appt_id === null) {
    echo "Invalid request. Please go back and try again.";
    exit;
}

try {
    // Fetch user details from the 'users' table
    $stmtUser = mysqli_prepare($link, "SELECT username, gender, phonenumber, email, dob, user_notes FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmtUser, "i", $user_id);
    mysqli_stmt_execute($stmtUser);
    $resultUser = mysqli_stmt_get_result($stmtUser);
    $user = mysqli_fetch_assoc($resultUser);

    // Fetch appointment details including medicine
    $stmtApp = mysqli_prepare($link, "SELECT appt_type, medicine FROM appointment WHERE appt_id = ?");
    mysqli_stmt_bind_param($stmtApp, "i", $appt_id);
    mysqli_stmt_execute($stmtApp);
    $resultApp = mysqli_stmt_get_result($stmtApp);
    $appointment = mysqli_fetch_assoc($resultApp);

    if (!$user || !$appointment) {
        echo "Details not found. Please go back and try again.";
        exit;
    }

} catch (mysqli_sql_exception $e) {
    echo "Error fetching details: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .appointment-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            
            background-color: white;
        }

        .date-section {
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

        .btn-custom {
      border: 1px solid red;
      color: red;
    }
    .btn-custom:hover {
      background-color: red;
      color: white;
    }

        .color-bar-wrapper {
            background: linear-gradient(to right, grey, grey);
            /* Left-to-right color gradient */
            padding: 5px;
            /* Spacing to show the color bar around the card */
            border-radius: 12px;
            /* Rounded corners for the color bar */
            position: relative;
        }
        
        
    </style>
</head>
<body>
    <!-- Navigation -->
  <div class="navbar">
    <div class="logo">LOGO</div>
    <div class="nav-links">
      <a href="dashboard.php">Home</a>
      <div class="separator"></div>
      <a href="#" class="active">Appointments</a>
      <div class="separator"></div>
      <a href="#">Medication</a>
    </div>
    <a href="bookAppt.php" class="button">
      <i class="icon">📅</i> Book Appointment
    </a>
    <i class="settings">⚙️</i>
  </div>
        <div class="container mt-5">
    <h2>Appointment Details</h2>

    <div class="row">
        <!-- User Information -->
        <div class="col-md-6">
            <h4>User Information</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></li>
                <li class="list-group-item"><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></li>
                <li class="list-group-item"><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phonenumber']); ?></li>
                <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
                <li class="list-group-item"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></li>
            </ul>
        </div>

        <!-- Appointment Information -->
        <div class="col-md-6">
            <h4>Appointment Information</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Reason for Appointment:</strong> <?php echo htmlspecialchars($appointment['appt_type']); ?></li>
                <li class="list-group-item"><strong>Patient Notes:</strong> 
                    <?php echo htmlspecialchars($user['user_notes'] ?? 'No notes available.'); ?>
                </li>
                <li class="list-group-item"><strong>Prescribed Medicine:</strong> 
                    <?php echo htmlspecialchars($appointment['medicine'] ?? 'No medicine prescribed.'); ?>
                </li>
            </ul>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="showMeds.php" class="btn btn-secondary">Back to Completed Appointments</a>
    </div>
</div>

    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
