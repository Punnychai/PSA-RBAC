<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Log In</title>
        <link rel="stylesheet" href="LogIn.css" />
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
        session_start();        // test     8;pritg0hkFv
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
                            $query = "SELECT role_ID FROM employees WHERE employee_id = ?";

                            $stmt = $mysqli->prepare($query);
                            $stmt->bind_param("i", $employee_id);
                            $stmt->execute();
                            $stmt->bind_result($employee_role);

                            if ($stmt->fetch()) {
                            // fetch true
                                $_SESSION['username'] = $username;

                                switch ($employee_role) {
                                    case 5:
                                        $_SESSION['$employee_role'] = "Admin";
                                        header('Location: RoleBased/Admin.php');
                                        break;
                                    case 4:
                                        $_SESSION['$employee_role'] = "Director";
                                        header('Location: RoleBased/Director.php');
                                        break;
                                    case 3:
                                        $_SESSION['$employee_role'] = "Manager";
                                        header('Location: RoleBased/Manager.php');
                                        break;
                                    case 2:
                                        $_SESSION['$employee_role'] = "Staff";
                                        header('Location: RoleBased/Staff.php');
                                        break;
                                    case 1:
                                        $_SESSION['$employee_role'] = "Intern";
                                        header('Location: RoleBased/Intern.php');
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
