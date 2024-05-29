<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Reporter') {
        header('Location: ../LogIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>News Management</title>
        <link rel="stylesheet" href="Manage.css" />
    </head>
    <body>

    </body>
</html>
