<!DOCTYPE html>
<?php
include("dbFunctions.php");

if (isset($_GET['appt_id'])) {
    $appt_id = intval($_GET['appt_id']);

    // Set visible to 0 instead of deleting the record
    $query = "UPDATE appointment SET visible = 0 WHERE appt_id = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $appt_id);
    mysqli_stmt_execute($stmt);

    // Redirect back to the appointments page
    header("Location: showMeds.php");
    exit();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
