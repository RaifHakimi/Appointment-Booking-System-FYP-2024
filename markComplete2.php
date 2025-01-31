<!DOCTYPE html>
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

$appointment_id = $_GET['appt_id'] ?? null; // Get the appointment ID from the query string
if (!$appointment_id) {
    die("Invalid appointment ID.");
}

$stmt = $link->prepare("SELECT * FROM appointment WHERE appt_id = ?");
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$appointment = $stmt->get_result()->fetch_assoc();

if (!$appointment) {
    die("Appointment not found.");
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
        <div class="container mt-5">
    <h2>Complete Appointment</h2>
    <p>Appointment ID: <strong><?php echo htmlspecialchars($appointment['appt_id']); ?></strong></p>
    <p>Reason for Appointment: <strong><?php echo htmlspecialchars($appointment['appt_type']); ?></strong></p>
    
    <!-- Medicine Prescription Form -->
    <form action="confirmCompletion.php" method="POST">
        <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appt_id']); ?>">
        
        <div class="mb-3">
            <label for="medicine" class="form-label">Prescribe Medicine:</label>
            <textarea id="medicine" name="medicine" class="form-control" rows="4" placeholder="Enter prescribed medicine here..." required></textarea>
        </div>
        
        <!-- Complete Appointment Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-success">Complete Appointment</button>
        </div>
    </form>
</div>
        
    </body>
</html>
