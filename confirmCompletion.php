<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $appointment_id = intval($_POST['appointment_id']);
    $medicine = htmlspecialchars($_POST['medicine'], ENT_QUOTES, 'UTF-8'); // Sanitize input

    // Update the database with the prescribed medicine
    $updateQuery = "UPDATE appointment SET medicine = ?, status = 'completed' WHERE appt_id = ?";
    $stmt = $link->prepare($updateQuery);
    $stmt->bind_param("si", $medicine, $appointment_id);

    $updateSuccess = $stmt->execute();

    // Fetch the updated appointment details
    $appointment = null;
    if ($updateSuccess) {
        $fetchQuery = "SELECT appt_id, appt_type, medicine FROM appointment WHERE appt_id = ?";
        $stmtFetch = $link->prepare($fetchQuery);
        $stmtFetch->bind_param("i", $appointment_id);
        $stmtFetch->execute();
        $result = $stmtFetch->get_result();
        $appointment = $result->fetch_assoc();
    }
}
?>

<html>
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
        
        <div class="container mt-5 text-center">
        <?php if (isset($appointment)): ?>
            <h2>Appointment Completed</h2>
            <p><strong>Appointment ID:</strong> <?php echo htmlspecialchars($appointment['appt_id']); ?></p>
            <p><strong>Reason for Appointment:</strong> <?php echo htmlspecialchars($appointment['appt_type']); ?></p>
            <p><strong>Prescribed Medicine:</strong> <?php echo htmlspecialchars($appointment['medicine']); ?></p>
            <a href="docSchedule.php" class="btn btn-primary mt-4">Back to Schedule</a>
        <?php else: ?>
            <div class="alert alert-danger">
                <?php if ($updateSuccess === false): ?>
                    Error updating appointment. Please try again later.
                <?php else: ?>
                    Appointment not found.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    </body>
</html>
