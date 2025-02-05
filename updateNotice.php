<?php
session_start();
include("dbFunctions.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  // Display an alert and redirect
  echo "<script>
      alert('Access Restricted. You must be logged in as an admin to access this page.');
      window.location.href = 'index.php';
  </script>";
  exit(); // Ensure no further code is executed
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notice'])) {
    $notice = mysqli_real_escape_string($link, $_POST['notice']);

    // Check if there is an existing notice
    $checkQuery = "SELECT COUNT(*) as count FROM noticeboard";
    $result = mysqli_query($link, $checkQuery);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        // Update existing notice
        $query = "UPDATE noticeboard SET notice = ? LIMIT 1";
    } else {
        // Insert a new notice if none exists
        $query = "INSERT INTO noticeboard (notice) VALUES (?)";
    }

    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $notice);

    if (mysqli_stmt_execute($stmt)) {
         $_SESSION['message'] = "Notice updated successfully.";
    } else {
         $_SESSION['message'] = "Error updating notice.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Notice</title>
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
        <h2>Update Notice Board</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
    <label for="notice" class="form-label">Notice:</label>
    <textarea id="notice" name="notice" class="form-control" rows="4" placeholder="Enter the latest notice here..."></textarea>
</div>
            <button type="submit" class="btn btn-primary">Update Notice</button>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
