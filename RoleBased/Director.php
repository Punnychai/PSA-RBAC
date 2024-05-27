<?php
session_start();

if ($_SESSION['$employee_role'] != "Director") {
    header('Location: ../LogIn.php');
    exit();
}
else {
    echo "This is the director page";
}
?>
