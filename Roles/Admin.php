<?php
    session_start();

    if ($_SESSION['$employee_role'] != "Admin") {   // admin   9h,-jkwdj.ljsPhk (ต้มข่าไก่ใส่หญ้า)
        header('Location: ../LogIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin</title>
        <link rel="stylesheet" href="Roles.css" />
        <link rel="stylesheet" href="../Pages/Pages.css" />
    </head>
    <body>  
        <?php include '../Pages/HeadBar.php'; ?>
        <div class="main">
            <a href="../Manage/UserManage.php" class="manage">
                <label>Users Management</label>
            </a>
            <a href="../Manage/NewsManage.php" class="manage">
                <label>News Management</label>
            </a>
            <a href="../Manage/DocsManage.php" class="manage">
                <label>Documents Management</label>
            </a>
        </div>
    </body>
</html>
