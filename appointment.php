<?php
include 'dbFunctions.php';
session_start();



$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM appointment WHERE user_id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if appointments exist

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .appointment-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
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

  <!-- Main Content -->
  <div class="container mt-4">
    <h3 class="text-center">Appointment</h3>

    <?php 
    if ($result->num_rows > 0) {
      $appointments = [];
  
      // Fetch all appointments into an array
      while ($row = $result->fetch_assoc()) {
          $appointments[] = $row;
      }
  
      // Sort appointments chronologically by date and time
      usort($appointments, function ($a, $b) {
          $dateTimeA = strtotime($a['appt_date'] . ' ' . $a['appt_time']);
          $dateTimeB = strtotime($b['appt_date'] . ' ' . $b['appt_time']);
          return $dateTimeA <=> $dateTimeB; // Ascending order
      });
  
      // Loop through sorted appointments and display them
      foreach ($appointments as $row) {
          $date = new DateTime($row['appt_date']);
          $day = $date->format('d'); // Day with leading zero (01-31)
          $shortDay = strtoupper($date->format('D')); // Short day name in uppercase
          $month = strtoupper($date->format('M')); // Short month name in uppercase
          $year = $date->format('Y'); // Four-digit year (e.g., 2024)
  
          $time = $row['appt_time'];
          $filterTime = strtotime($time);
          $time12h = date('h:i A', $filterTime); // 12-hour format with AM/PM
  
          echo "
          </div>
              <div class='container mt-4'>
                <!-- Appointment Cards -->
                <div class='appointment-card d-flex'>
                  <div class='date-section text-center me-3'>
                    <div>" . htmlspecialchars($month) . "<br> " . htmlspecialchars($year) . " </div>
                    <div class='fs-1 day-sect'>" . htmlspecialchars($day) . "</div>
                    <div> " . htmlspecialchars($shortDay) . " </div>
                  </div>
                  <div class='flex-grow-1'>
                    <h5>Doctor Consult</h5>
                    <p>Booked for <span class='text-muted'>[Name]</span></p>
                    <p class='text-danger'>" . htmlspecialchars($time12h) . "</p>
                    <p>Dr. Ty </p>
                </div>
                <div class='d-flex flex-column'>
                  <button class='btn btn-custom mb-2'>Reschedule</button>
                  <button class='btn btn-custom'>Cancel</button>
                </div>
              </div>
          ";
      }
  } else {
      echo "<p>No appointments found.</p>";
  }
    
    // Close the connection
    $link->close();
    
    ?>
    <!-- Appointment Cards 
    <div class="appointment-card d-flex">
      <div class="date-section text-center me-3">
        <div>OCT<br>2024</div>
        <div class="fs-1">18</div>
        <div>FRI</div>
      </div>
      <div class="flex-grow-1">
        <h5>Doctor Consult</h5>
        <p>Booked for <span class="text-muted">[Name]</span></p>
        <p class="text-danger">5:58 PM</p>
        <p>Dr. Heisenberg</p>
      </div>
      <div class="d-flex flex-column">
        <button class="btn btn-custom mb-2">Reschedule</button>
        <button class="btn btn-custom">Cancel</button>
      </div>
    </div> -->

    
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>