<?php
    session_start();

    if ($_SESSION['$employee_role'] != "Manager") {
        header('Location: ../LogIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Employees</title>
        <link rel="stylesheet" href="Roles.css" />
        <link rel="stylesheet" href="../Pages/Pages.css" />
    </head>
    <body>
        <?php include '../Pages/HeadBar.php'; ?>
        <div class="main">
            <a href="../Pages/News.php?condition=('int' OR 'pub' OR 'org')" class="manage">
                <br /><label>News</label>
            </a>
            <a href="../Pages/Document.php" class="manage">
                <br /><label>Documents</label>
            </a>
        </div>
        <div class="main" style="margin-top: -300px;">
            <a href="../Pages/Employees.php" class="manage">
                <label>View<br />Employees</label>
            </a>
            <a href="../Manage/DocsManage.php" class="manage">
                <label>Documents Management</label>
            </a>
        </div>
    </body>
</html>
