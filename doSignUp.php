<!DOCTYPE html>
<?php
/** Sign up Functionality/ Assign role of Patient
 * 
 */
session_start();
$msg = "";

// Connect to the database
include "dbFunctions.php";

echo "<pre>";
print_r($_POST);  // This will show the data received from the form
echo "</pre>";

if (!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['gender']) && !empty($_POST['phoneNumber']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['day']) && !empty($_POST['month']) && !empty($_POST['year'])) {
    //username
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $userName = $firstName . ' ' . $lastName;

    //gender
    $gender = $_POST['gender'];

    //phone number
    $phoneNumber = htmlspecialchars($_POST['phoneNumber']);

    //email
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    //password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);          // Changed from $name to $phoneNumber

    //dob
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    $role = "Patient";



    // Validate and format the date
    if (checkdate($month, $day, $year)) {
        $birthDate = "$year-$month-$day";  // Format: YYYY-MM-DD
    } else {
        echo "Invalid date selected.";
    }










    if ($email) {
        $stmt = $link->prepare("INSERT INTO users ( username, gender, phonenumber, email, password, dob, role) VALUES (?, ?, ?, ?, ?, ? , ?)");  // Changed 'name' to 'phoneNumber'
        $stmt->bind_param("sssssss", $userName, $gender, $phoneNumber, $email, $password, $birthDate, $role);  // Changed '$name' to '$phoneNumber'

        $status = $stmt->execute();

        if ($status) {
            $lastInsertedId = $stmt->insert_id;
            $msg = "Registered successfully.";

            $query = "SELECT * FROM users WHERE user_id = ?";
            $fetchStmt = $link->prepare($query);
            $fetchStmt->bind_param("i", $lastInsertedId);
            $fetchStmt->execute();
            $result = $fetchStmt->get_result();
            $user = $result->fetch_assoc();

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            echo "<script>
                    alert('$msg');
                    window.open('newpage.php', '_blank');  // Opens new tab with newpage.php
                    window.location.href = 'dashboard.php';  // Redirects to welcome.php in the same tab
                  </script>";
        } else {
            $msg = "Registration failed.";
        }

        $stmt->close();
    } else {
        $msg = "Invalid email format.";
    }
} else {
    $msg = "All details have to be provided.";
}

mysqli_close($link);
?>

<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <?php
    // put your code here
    echo $msg;
    echo $firstName;
    echo $lastName;

    echo $gender;
    echo $password;
    echo $email;
    echo $birthDate;
    ?>
</body>

</html>