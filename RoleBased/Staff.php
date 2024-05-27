<?php
session_start();

if ($_SESSION['$employee_role'] != "Staff") {
    header('Location: ../LogIn.php');
    exit();
}
else {
    echo "This is the staff page";
}
?>
