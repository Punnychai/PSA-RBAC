<?php
session_start();

if ($_SESSION['$employee_role'] != "Admin") {
    header('Location: ../LogIn.php');
    exit();
}
else {
    echo "This is the admin page";
}
?>
