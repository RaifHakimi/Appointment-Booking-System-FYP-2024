<!DOCTYPE html>
<?php

session_start();
$msg = "";

echo "<pre>";
print_r($_POST);  // This will show the data received from the form
echo "</pre>";
if (isset($_POST['phonenumber'])) {

    // Retrieve form data
    $entered_username = $_POST['phonenumber'];
    $entered_password = $_POST['password'];

    // Connect to the database
    include "dbFunctions.php";

    // Match the username and retrieve the hashed password from the database
    $query = "SELECT user_id, username, role, password FROM users WHERE phonenumber = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $entered_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];
        

        // Verify the entered password against the stored hashed password
        if (password_verify($entered_password, $stored_hashed_password)) {
            // Password is correct; store user info in session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']
            $msg = "Login is successful!";

            if($row['role'] == 'admin') {
                echo "<script>
                    alert('$msg');
                    window.open('newpage.php', '_blank');  // Opens new tab with newpage.php
                    window.location.href = 'testrey.php';  // Redirects to welcome.php in the same tab
                  </script>";
            }

            elseif($row['role'] == 'doctor') {
                echo "<script>
                    alert('$msg');
                    window.open('newpage.php', '_blank');  // Opens new tab with newpage.php
                    window.location.href = 'testisaac.php';  // Redirects to welcome.php in the same tab
                  </script>";
            }

            elseif($row['role'] == 'patient') {

            echo "<script>
                    alert('$msg');
                    window.open('newpage.php', '_blank');  // Opens new tab with newpage.php
                    window.location.href = 'dashboard.php';  // Redirects to welcome.php in the same tab
                  </script>";
        } 
    }
        else {
            $msg = "Incorrect password! Redirecting to login page.";
            echo "<script>
                    alert('$msg');
                    window.location.href = 'login.php';  // Redirect to login page
                  </script>";
        }
    } 
    else {
        // Username not found
        $msg = "User not found! Redirecting to login page.";
        echo "<script>
                alert('$msg');
                window.location.href = 'login.php';  // Redirect to login page
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($link);
}

?>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <h1><?php
        echo $msg;
        ?></h1>
</body>

</html>