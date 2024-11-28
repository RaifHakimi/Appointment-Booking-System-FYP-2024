<!DOCTYPE html>
<?php
session_start();
include ("dbFunctions.php");

//retrieve value from form

$userId = $_SESSION['user_id'];

$query = "SELECT userId, username, password, phoneNumber, dob, email
          FROM users
          WHERE userId = $userId";

$result = mysqli_query($link, $query);

$row = mysqli_fetch_assoc($result);
$username = $row['username'];
$password = $row['password'];
$phoneNumber = $row['phoneNumber'];
$dob = $row['dob'];
$email = $row['email'];


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="doUpdate.php">
        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
        <label>Username:</label>
        <br/>
        <textarea rows="1" cols="15" name="username"><?php echo $username ?></textarea>
        <br/><br/>
        <label>password:</label>
        <br/>
        <textarea rows="1" cols="15" name="password"><?php echo $password ?></textarea>
        <br/><br/>
        <label>Name:</label>
        <br/>
        <textarea rows="1" cols="15" name="phoneNumber"><?php echo $phoneNumber ?></textarea>
        <br/><br/>
        <label>Date of birth:</label>
        <br/>
        <textarea rows="1" cols="15" name="dob"><?php echo $dob ?></textarea>
        <br/><br/>

        <label>Email Address:</label>
        <br/>
        <textarea rows="1" cols="30" name="email"><?php echo $email ?></textarea>
        <br/>

        <input type="submit" value="Update"/>
        </form>
    </body>
</html>
