<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Log In</title>
        <link rel="stylesheet" href="Public.css" />
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

                            // IP Logging
                            $log_query = "INSERT INTO iplog (employee_id, ip_address, timestamp) VALUES (?, ?, ?)";
                            $log_stmt = $mysqli->prepare($log_query);

                            // modalOTP();

                            function get_client_ip() {
                                $ip_address = '';
                            
                                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                                    // Shared Internet
                                    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
                                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                                    // Proxy-Passed
                                    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                } else {
                                    // Remote Address
                                    $ip_address = $_SERVER['REMOTE_ADDR'];
                                }

                                // IPv6 LocalHost handler
                                if ($ip_address == '::1') {
                                    $ip_address = '127.0.0.1';
                                }
                            
                                return $ip_address;
                            }
                            
                            $ip_address = get_client_ip();
                            $timestamp = date('Y-m-d H:i:s');

                            $log_stmt->bind_param("iss", $_SESSION['employee_id'], $ip_address, $timestamp);
                            $log_stmt->execute();

                            // LogIn Function
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
                                        $_SESSION['$employee_role'] = "Reporter";
                                        header('Location: Roles/Reporter.php');
                                        break;
                                    default:       // unset & unexpected roles
                                        $_SESSION['$employee_role'] = "Guest";
                                        header('Location: Home.php');
                                        break;
                                }
                            }
                        } else {
                            echo '<h3 class="pwd-error">Incorrect Username or Password</h3>';
                        }
                    } else {
                        echo '<h3 class="pwd-error">Incorrect Username or Password</h3>';
                    }
                }
            }

            function modalOTP() {
                echo '<div id="ModalOTP" class="modal">
                            <div class="modal-content">
                            <span class="close">&times;</span>
                            <br />
                            <h3 id="modalText" style="margin: 20px 0 0 14px;">LogIn detected from New Location</h3>
                            <h3 id="modalText" style="margin: 20px 0 0 14px;">Enter OTP to verify your identify </h3>
                            <form method="POST" id="otpForm">
                                <input type="text" name="otp" id="OTP" style="margin: 30px 0 10px 0;" required>
                                <button type="submit" name="verify" id="verify" onclick="Verify()">Verify</button>
                            </form>
                        </div>
                    </div>';
            };
        ?>

        <script>
            var modalOTP = document.getElementById("ModalOTP");
            if (modalOTP) {
                modalOTP.style.display = "block";
            }

            function Verify() {
                window.location.href = './SignUp.php';
            }
        </script>
    </body>
</html>
