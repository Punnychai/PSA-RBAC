<?php
session_start();

if ($_SESSION['$employee_role'] != "Manager") {
    header('Location: ../LogIn.php');
    exit();
}
else {
    echo "This is the manager page";
}
?>
