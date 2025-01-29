<!DOCTYPE html>
<?php
session_start();
include("dbFunctions.php");

$query = "SELECT a.appt_id, a.appt_date, a.appt_time, a.medicine, a.user_id, u.username 
          FROM appointment a
          INNER JOIN users u ON a.user_id = u.user_id
          WHERE a.status = 'Completed' AND a.visible = 1";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Error fetching completed appointments: " . mysqli_error($link));
}

// Fetch appointments into an array
$completed_appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $completed_appointments[] = $row;
}

// Close the database connection
mysqli_close($link);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ShowMeds</title>
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
        
       <div class="container mt-4">
        <h2>Completed Appointments</h2>
        
        <?php if (empty($completed_appointments)): ?>
            <p>No completed appointments found.</p>
        <?php else: ?>
            <?php foreach ($completed_appointments as $app): ?>
                <div class="container mt-4">
                    <!-- Appointment Cards -->
<div class="appointment-card d-flex border rounded p-3 mb-3">
    <div class="date-section text-center me-3">
        <div><?php echo date("m", strtotime($app['appt_date'])); ?><br><?php echo date("Y", strtotime($app['appt_date'])); ?></div>
        <div class="fs-1"><?php echo date("d", strtotime($app['appt_date'])); ?></div>
        <div><?php echo strtoupper(date("D", strtotime($app['appt_date']))); ?></div>
    </div>
    <div class="flex-grow-1">
        <h5>Doctor Consult</h5>
        <p>Booked for <span class="text-muted"><?php echo htmlspecialchars($app['username']); ?></span></p>
        <p class="text-danger"><?php echo htmlspecialchars($app['appt_time']); ?></p>
        <p><strong>Medicine:</strong> <?php echo htmlspecialchars($app['medicine'] ?? 'No medicine prescribed.'); ?></p>
    </div>
    <div class="d-flex flex-column">
        <a href="details2.php?appt_id=<?php echo $app['appt_id']; ?>&user_id=<?php echo $app['user_id']; ?>" class="btn btn-custom mb-3">Details</a>
        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $app['appt_id']; ?>)" class="btn btn-danger">Delete</a>
    </div>
</div>

<?php endforeach; ?>
<?php endif; ?>

<script>
    function confirmDelete(appt_id) {
        if (confirm("Are you sure you want to delete this appointment?")) {
            window.location.href = "delete.php?appt_id=" + appt_id;
        }
    }
</script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        
    </body>
</html>
