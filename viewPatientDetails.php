<?php

/**
 * This file fetches the patient details from the database
 */
session_start();
include 'dbFunctions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Display an alert and redirect
    echo "<script>
        alert('Access Restricted. You must be logged in as a admin to access this page.');
        history.back();

    </script>";
    exit(); // Ensure no further code is executed
}


if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id']; // Retrieve the user_id from the URL
} else {
    $user_id = null; // Default value if user_id is not set
}

try {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $link->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $link->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data (assuming single row for the user)
        $row = $result->fetch_assoc();

        // Extract specific fields
        $username = htmlspecialchars($row['username'] ?? '');
        $gender = htmlspecialchars($row['gender'] ?? '');
        $phonenumber = htmlspecialchars($row['phonenumber'] ?? '');
        $email = htmlspecialchars($row['email'] ?? '');
        $password = htmlspecialchars($row['password'] ?? '');
    } else {
        echo "<p>No user found with ID: $user_id</p>";
        $username = ''; // Default empty value
    }
} catch (Exception $e) {
    echo "<p>Unable to fetch user details: " . $e->getMessage() . "</p>";
}

if (isset($_POST['toggle_role'])) {
    $user_id = $_POST['user_id'];
    $current_role = $_POST['current_role'];
    $new_role = ($current_role === 'patient') ? 'doctor' : 'patient';

    $update_role_sql = "UPDATE users SET role = ? WHERE user_id = ?";
    $stmt = $link->prepare($update_role_sql);
    $stmt->bind_param("si", $new_role, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Role updated successfully!'); window.location.href = 'viewAllPatients.php';</script>";
    } else {
        echo "<p>Error updating role: " . $link->error . "</p>";
    }

    $stmt->close();
}


// Close the statement and connection
$stmt->close();
$link->close();





?>
<!DOCTYPE html>
<html lang="en">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    header .logo {
        font-size: 24px;
        font-weight: bold;
    }

    header nav {
        display: flex;
        gap: 20px;
    }

    header nav a {
        color: #fff;
        text-decoration: none;
        font-size: 18px;
    }

    header nav a:hover {
        text-decoration: underline;
    }

    .container {
        padding: 20px;
    }

    .search-bar {
        margin-bottom: 20px;
    }

    .search-bar input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
<div class="navbar">
    <div class="logo">LOGO</div>
    <div class="nav-links">
        <a href="dashboard.php">Home</a>
        <div class="separator"></div>
        <a href="appointment.php">Appointments</a>
        <div class="separator"></div>
        <a href="medication.php">Medication</a>
    </div>
    <a href="bookAppt.php" class="button">
        <i class="icon">📅</i> Book Appointment
    </a>
    <a href="settings.php">
        <i class="settings">⚙️</i>
    </a>
</div>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<link rel="stylesheet" href="style.css">

<body>
    <h2 class="text-center pt-4">Edit Patient Details</h2>
    <div class="container">
        <form method="POST" class="btn-toggle-role">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="current_role" value="<?php echo $role; ?>">
            <button type="submit" name="toggle_role" class="btn btn-primary">
                <?php echo ($role === 'patient') ? 'Switch to Doctor' : 'Switch to Patient'; ?>
            </button>
        </form>
        <form id="patientForm">
            <input type="hidden" id="user_id" value="1"> <!-- Change dynamically or pass via URL -->

            <!--Username-->
            <div class="mb-3">
                <label for="username" class="form-label">Username*</label>
                <input type="text" class="form-control text-border" id="username" name="username" value="<?php echo $username; ?>" required>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label">Gender*</label>
                <div>
                    <input type="radio" id="male" name="gender" value="Male" <?php if ($gender == "Male") echo "checked"; ?>>
                    <label for="male">Male</label>

                    <input type="radio" id="female" name="gender" value="Female" <?php if ($gender == "Female") echo "checked"; ?>>
                    <label for="female">Female</label>
                </div>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number*</label>
                <input type="text" class="form-control text-border" id="phoneNumber" name="phoneNumber" value="<?php echo $phonenumber; ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email*</label>
                <input type="text" class="form-control text-border" id="email" name="email" value="<?php echo $email ?>" required>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="viewAllPatients.php" class="btn btn-danger ms-2">Cancel</a>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userId = document.getElementById("user_id").value;

            // Fetch patient details
            fetch(`fetchPatient.php?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("username").value = data.username;
                    document.getElementById("gender").value = data.gender;
                    document.getElementById("phoneNumber").value = data.phone_number;
                    document.getElementById("email").value = data.email;
                })
                .catch(error => console.error("Error fetching data:", error));
        });

        // Handle form submission
        document.getElementById("patientForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append("user_id", document.getElementById("user_id").value);

            fetch("updatePatient.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert("Patient details updated successfully!");
                    window.location.href = "viewAllPatients.php";
                })
                .catch(error => console.error("Error updating patient:", error));
        });
    </script>

</body>

</html>