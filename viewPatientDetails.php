/**
 * File created by Isaac
 */
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
        <form id="patientForm">
            <input type="hidden" id="user_id" value="1"> <!-- Change dynamically or pass via URL -->

            <!-- First Name -->
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name*</label>
                <input type="text" class="form-control text-border" id="firstName" name="firstName" required>
            </div>

            <!-- Last Name -->
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name*</label>
                <input type="text" class="form-control text-border" id="lastName" name="lastName" required>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Gender*</label>
                <input type="text" class="form-control text-border" id="gender" name="gender" readonly>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number*</label>
                <input type="text" class="form-control text-border" id="phoneNumber" name="phoneNumber" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email*</label>
                <input type="text" class="form-control text-border" id="email" name="email" required>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="viewAllPatients.php" class="btn btn-danger ms-2">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const userId = document.getElementById("user_id").value;

            // Fetch patient details
            fetch(`fetchPatient.php?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("firstName").value = data.first_name;
                    document.getElementById("lastName").value = data.last_name;
                    document.getElementById("gender").value = data.gender;
                    document.getElementById("phoneNumber").value = data.phone_number;
                    document.getElementById("email").value = data.email;
                })
                .catch(error => console.error("Error fetching data:", error));
        });

        // Handle form submission
        document.getElementById("patientForm").addEventListener("submit", function (e) {
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
