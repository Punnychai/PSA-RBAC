<?php
    session_start();

    if ($_SESSION['$employee_role'] != "Manager") {   // manager   9h,-jkwdj.ljsPhk (ต้มข่าไก่ใส่หญ้า)
        header('Location: ../LogIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Manager</title>
        <link rel="stylesheet" href="Roles.css" />
    </head>
    <body>
        <a href="../Pages/News.php" class="manage">
            <br /><label>News</label>
        </a>
        <a href="../Manage/DocsManage.php" class="manage">
            <br /><label>Documents</label>
        </a>
    </body>
</html>
