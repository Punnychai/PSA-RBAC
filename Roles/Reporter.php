<?php
    session_start();

    if ($_SESSION['$employee_role'] != "Reporter") {
        header('Location: ../LogIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Director</title>
        <link rel="stylesheet" href="Roles.css" />
        <link rel="stylesheet" href="../Pages/Pages.css" />
    </head>
    <body>
        <?php include '../Pages/HeadBar.php'; ?>
        <div class="main">
            <a href="../Pages/Document.php" class="manage">
                <br /><label>Documents</label>
            </a>
            <a href="../Manage/NewsManage.php" class="manage">
                <label>News Management</label>
            </a>
        </div>
    </body>
</html>
