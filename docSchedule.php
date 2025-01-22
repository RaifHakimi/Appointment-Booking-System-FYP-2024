<!DOCTYPE html>
<?php
session_start();
//include("dbFunctions.php");

// Fetch today's appointments
$date = date("Y-m-d"); // Get today's date
//$stmt = $conn->prepare("SELECT * FROM appointments WHERE date = :date");
//$stmt->bindParam(':date', $date);
//$stmt->execute();
//$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h3>Appointments for Today</h3>
    <div id="appointments-list">
        <?php
        // Dummy users table
$users = [
    ["id" => 1, "username" => "johndoe"],
    ["id" => 2, "username" => "janesmith"],
    ["id" => 3, "username" => "emilydavis"],
    ["id" => 4, "username" => "michaelbrown"],
    ["id" => 5, "username" => "sarahwilson"]
];

// Dummy appointments table
$appointments = [
    ["id" => 1, "date" => date("Y-m-d"), "time" => "09:00:00", "user_id" => 1, "reason" => "Routine checkup"],
    ["id" => 2, "date" => date("Y-m-d"), "time" => "10:30:00", "user_id" => 2, "reason" => "Flu symptoms"],
    ["id" => 3, "date" => date("Y-m-d"), "time" => "11:45:00", "user_id" => 3, "reason" => "Back pain"],
    ["id" => 4, "date" => date("Y-m-d"), "time" => "14:00:00", "user_id" => 4, "reason" => "Follow-up consultation"],
    ["id" => 5, "date" => date("Y-m-d"), "time" => "16:30:00", "user_id" => 5, "reason" => "Headache evaluation"]
];

function getUsernameById($users, $user_id) {
    foreach ($users as $user) {
        if ($user['id'] === $user_id) {
            return $user['username'];
        }
    }
    return "Unknown"; // Return "Unknown" if user_id is not found
}

        if (empty($appointments)) {
            echo "<p>No appointments for today.</p>";
        } else {
            foreach ($appointments as $app) {
                // Fetch the patient's username based on the user_id
                //$stmt = $conn->prepare("SELECT username FROM users WHERE id = :user_id");
                //$stmt->bindParam(':user_id', $app['user_id']);
                //$stmt->execute();
                //$user = $stmt->fetch(PDO::FETCH_ASSOC);
                //$username = $user['username'];

                // Filter by today's date
    if ($app['date'] === date("Y-m-d")) {
        $username = getUsernameById($users, $app['user_id']);
        
                echo "
                </div>
              <div class='container mt-4'>
                <!-- Appointment Cards -->
                <div class='appointment-card d-flex border rounded p-3 mb-3'>
                  <div class='date-section text-center me-3'>
                            <div>" . date("m", strtotime($app['date'])) . "<br>" . date("Y", strtotime($app['date'])) . "</div>
                            <div class='fs-1'>" . date("d", strtotime($app['date'])) . "</div>
                            <div>" . strtoupper(date("D", strtotime($app['date']))) . "</div>
                        </div>
                        <div class='flex-grow-1'>
                            <h5>Doctor Consult</h5>
                            <p>Booked for <span class='text-muted'>{$username}</span></p>
                            <p class='text-danger'>{$app['time']}</p>
                        </div>
                        <div class='d-flex justify-content-center align-items-center'>
                            
                            <a href='markComplete2.php?appointment_id={$app['id']}' class='btn btn-custom'>Medicine/Mark as Completed</a>
                        </div>
                    </div>
                </div>
                ";
            }
        }
        }
        ?>
    </div>
</div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
