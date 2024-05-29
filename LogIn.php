<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Log In</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700&display=swap');

            body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            }

            .login-container {
                width: 400px;
                height: 390px;
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

            
            #username, #password {
                height: 17px;
                padding: 10px;
                margin-bottom: 8px;
                border: none;
                border-radius: 6px;
                background-color: #333;
                color: #fff;
                width: 95%;
            }

            #passwordStrength, #passwordMissing {
                min-height: 20px;
                margin: 4px 0 8px 0;
            }


            .login-container select {
                
                padding: 10px;
                border: 1px solid #444;
                border-radius: 6px;
                background-color: #333;
                color: #fff;
                width: 100%;
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

            #goSignUp {
                color: white;
                text-align: center;
                text-decoration: none;
                font-size: 16px;
                font-weight: 600;
                padding: 0px 20px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
            }

            .login-container p {
                margin-top: 10px;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h2>Log In</h2>
            <form id="loginForm" action="" method="post">
                <div>
                    <label for="username"><h6>Username :</h6></label>
                    <input type="text" id="username" name="username">
                    <label for="password"><h6>Password :</h6></label>
                    <input type="password" id="password" name="password">
                </div>
                <div>
                    <p id="errorMessage"></p>
                </div>
                <input type="submit" name="LogIn" value="Log In">
                <br />
                <p style="text-align: center"> Doesn't have an account yet?</p>
                <a id="goSignUp" href="SignUp.php">Create an Account</a>
            </form>
        </div>
        
        <?php
            session_start();
            if (isset($_POST['LogIn'])) {
                include 'connect.php';
                $username = $_POST['username'];
                $password = $_POST['password'];

                $query = "SELECT employee_id, username, pwd, department_id, role_id FROM employees WHERE username = ?";
                $stmt = $mysqli->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                    //username true
                        $stmt->bind_result($employee_id, $db_usn, $db_pwd, $department_id, $role_id);
                        $stmt->fetch();

                        if(password_verify($password, $db_pwd)) {
                        // password true
                            $_SESSION['employee_id'] = $employee_id;
                            $_SESSION['username'] = $db_usn;
                            $query = "SELECT role_id FROM employees WHERE employee_id = ?";

                            $stmt = $mysqli->prepare($query);
                            $stmt->bind_param("i", $employee_id);
                            $stmt->execute();
                            $stmt->bind_result($employee_role);

                            if ($stmt->fetch()) {
                            // fetch true
                                switch ($employee_role) {
                                    case 5:
                                        $_SESSION['$employee_role'] = "Admin";
                                        header('Location: Roles/Admin.php');
                                        break;
                                    case 4:
                                        $_SESSION['$employee_role'] = "Director";
                                        header('Location: Roles/Director.php');
                                        break;
                                    case 3:
                                        $_SESSION['$employee_role'] = "Manager";
                                        header('Location: Roles/Manager.php');
                                        break;
                                    case 2:
                                        $_SESSION['$employee_role'] = "Staff";
                                        header('Location: Roles/Staff.php');
                                        break;
                                    case 1:
                                        $_SESSION['$employee_role'] = "Intern";
                                        header('Location: Roles/Intern.php');
                                        break;
                                    default:
                                        // Handle unexpected role values if necessary
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        ?>

        <script>
            document.getElementById('password').addEventListener('input', function() {
                const password = this.value;
                document.getElementById('passwordStrength').textContent = "incorrect Username or Password";
            });
        </script>
    </body>
</html>
