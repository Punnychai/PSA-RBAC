<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin') {
        header('Location: ../LogIn.php');
        exit();
    }

    include '../connect.php';

    if (isset($_GET['uID'])) {
        $uID = intval($_GET['uID']); // Ensure the ID is an integer for security
        $stmt = $mysqli->prepare("SELECT email, fullname, department_id, role_id FROM employees WHERE employee_id = ?");
        $stmt->bind_param('i', $uID);
        $stmt->execute();
        $stmt->bind_result($email, $fullname, $department_id, $role);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Invalid employee ID.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = htmlspecialchars($_POST['email']);
        $fullname = htmlspecialchars($_POST['fullname']);
        $department_id = htmlspecialchars($_POST['department_id']);
        $role = intval($_POST['role']);

        $stmt = $mysqli->prepare("UPDATE employees SET email = ?, fullname = ?, department_id = ?, role_id = ? WHERE employee_id = ?");
        $stmt->bind_param('sssii', $email, $fullname, $department_id, $role, $uID);
        
        if ($stmt->execute()) {
            header("Location: UserManage.php");
            exit();
        } else {
            echo "UPDATE failed. Error: " . $mysqli->error;
        }

        $stmt->close();
    }

    $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Employee</title>
        <link rel="stylesheet" href="../Pages/Pages.css" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700&display=swap');

            body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            }
            .login-container {
                width: 400px;
                height: 510px;
                margin: 50px auto; /* Center horizontally with auto margin */
                padding: 20px;
                border-radius: 8px;
                background-color: #222;
                color: #fff;
                text-align: left;
                box-shadow: 0px 10px 50px 0px rgba(0, 0, 0, 0.5); /* Add box shadow for depth */
            }
            .login-container h2 {
                margin-bottom: 20px;
                font-size: 30px;
                font-weight: 500; /* Apply font weight */
            }
            .login-container form {
                display: flex;
                flex-direction: column;
            }
            .login-container h6 {
                font-size: 18px;
                font-weight: 500;
                margin: 4px 0 10px 0;
            }            
            #email, #fullname, #department_id, #role {
                height: 17px;
                padding: 10px;
                margin-bottom: 8px;
                border: none;
                border-radius: 6px;
                background-color: #333;
                color: #fff;
                width: 95%;
            }
            input[type="submit"] {
                background-color: green;
                color: white;
                font-size: 16px;
                font-weight: 600;
                padding: 12px 20px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
            }
            input[type="submit"]:hover {
                background-color: darkgreen;
            }
            .cancel {
                background-color: #D71609;
                text-align: center;
                text-decoration: none;
                color: white;
                font-size: 16px;
                font-weight: 600;
                padding: 12px 20px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
            }
            .cancel:hover {
                background-color: darkred;
            }
            .login-container p {
                margin-top: 10px;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <?php   $pageName = "Employees Management";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 200px;"></div> <!-- break -->
        <div class="login-container">
            <form method="post">
                <label for="email"><h6>Email :</h6></label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
                <label for="fullname"><h6>Full Name :</h6></label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required><br>
                
                <label for="department_id"><h6>Department :</h6></label>
                <select id="department_id" name="department_id" required style="height: 37px; width: 100%;">
                    <option value="CSC" <?php if($department_id == 'CSC') echo 'selected'; ?>>CyberSecurity</option>
                    <option value="ICT" <?php if($department_id == 'ICT') echo 'selected'; ?>>Information and Communications Technology</option>
                    <option value="NIS" <?php if($department_id == 'NIS') echo 'selected'; ?>>Network Infrastructure</option>
                    <option value="RND" <?php if($department_id == 'RND') echo 'selected'; ?>>Research and Development</option>
                </select><br>
                
                <label for="role"><h6>Role :</h6></label>
                <select id="role" name="role" required style="height: 37px; width: 100%;">
                    <option value="5" <?php if($role == 5) echo 'selected'; ?>>Admin</option>
                    <option value="4" <?php if($role == 4) echo 'selected'; ?>>Director</option>
                    <option value="3" <?php if($role == 3) echo 'selected'; ?>>Manager</option>
                    <option value="2" <?php if($role == 2) echo 'selected'; ?>>Staff</option>
                    <option value="1" <?php if($role == 1) echo 'selected'; ?>>Reporter</option>
                </select><br>
                <input type="submit" value="Update">
                <br style="height: 100px;" />
                <a href="NewsManage.php" class="button cancel">Cancel</a>
            </form>
        </div>
    </body>
</html>
