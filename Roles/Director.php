<?php
    session_start();

    if ($_SESSION['$employee_role'] != "Director") {
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
    </head>
    <body>
        <?php include '../Pages/HeadBar.php'; ?>
        <div class="main">
            <a href="../Pages/News.php" class="manage">
                <br /><label>News</label>
            </a>
            <a href="../Pages/Document.php" class="manage">
                <br /><label>Documents</label>
            </a>
            <a href="../Manage/DocsManage.php" class="manage">
                <label>Documents Management</label>
            </a>
        </div>
    </body>
</html>
