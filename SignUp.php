<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sign Up</title>
        <link rel="stylesheet" href="Public.css" />
    </head>
    <body>
        <div class="signup-container">
            <h2>Sign Up</h2>
            <form id="signupForm" action="" method="post">
                <div>
                    <label for ="fullname"><h6>Full Name :</h6></label>
                    <input type="text" id="fullname" name="fullname" required>
                    <label for="email"><h6>Email Address :</h6></label>
                    <input type="text" id="email" name="email" required>
                    <label for="username"><h6>Username :</h6></label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="password"><h6>Password :</h6></label>
                    <div style="display: flex;">
                        <input type="password" id="password" name="password" required>
                        <button type="button" id="passwordVis" onclick="togglePasswordVisibility()">S/H</button>
                    </div>
                </div>
                <div>
                    <p id="passwordStrength"></p>
                    <p id="passwordMissing"></p>
                </div>
                <input type="submit" name="SignUp" value="Sign Up">
                <br />
                <p style="text-align: center">Already a Member?<a id="goLogIn" href="LogIn.php">Log In</a></p>
            </form>
        </div>
        
        <?php
            include 'PasswordAnalyser.php';     // SERVER SIDE CONDITION
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                list($feedback, $missList) = passwordAnalyser($_POST['password']);
                /*
                echo '<h3 class="pwd-error">Password Strength:' . $feedback . '</h3>';
                if ($missList) {
                    echo '<h3 class="pwd-error>Feedback:' . $missList . '</h3>';
                } */
                
                if ($feedback === 'Very Strong' || $feedback === 'Strong') {
                    session_start();
                    if (isset($_POST['SignUp'])) {
                        include 'connect.php';
                        if ($_POST['password'] == "9h,-jkwdjsPhks;ko") {       // ต้มข่าไก่หญ้าหวาน
                            modalOne();
                        }
                        else {
                            // Store user data in $_SESSION
                            $_SESSION['email'] = $_POST['email'];
                            $_SESSION['fullname'] = $_POST['fullname'];
                            $_SESSION['username'] = $_POST['username'];
                            $_SESSION['password'] = $_POST['password'];
                            $_SESSION['signup'] = true;

                            if(isset($_SESSION['signup'])){
                                unset($_SESSION['signup']);
                                $email = $_SESSION['email'];
                                $fullname = $_SESSION['fullname'];
                                $username = $_SESSION['username'];
                                $pwd = $_SESSION['password'];
                                $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);
                                
                                // Prepared Statement & Parameter Binding (Prevent Injection)
                                $sql = "INSERT INTO employees (email, fullname, username, pwd) VALUES (?, ?, ?, ?)";
                                $stmt = $mysqli->prepare($sql);
                                $stmt->bind_param("ssss", $email, $fullname, $username, $hashedPwd);
                                $stmt->execute();
                                $stmt->close();
                            }
                            
                            modalTwo();
                        }
                    }
                    $mysqli->close();
                    session_destroy();
                } else {
                    echo '<h3 class="pwd-error" id="error">Please make sure your password comply with our regulations.</h3>';
                }
            }

            function modalOne() {
                echo '<div id="ModalOne" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h3 id="modalText" style="margin:  100px 0 70px 14px;">Your Password can\'t contain Name / Mobile Number / Citizen ID / Birthdate / Address</h3>
                            <input type="submit" name="Retry" value="Retry" style="width: 80%;" onclick="Retry()">
                        </div>
                    </div>';
            };

            function modalTwo() {
                echo '<div id="ModalTwo" class="modal">
                            <div class="modal-content">
                            <span class="close">&times;</span>
                            <h3 id="modalText" style="margin:  60px 0 0 14px;">Add Biometrics for Authentication?</h3>
                            <button id="proceed">Proceed</button>
                            <button id="later" onclick="Later()">Later</button>
                        </div>
                    </div>';
            };
        ?>

        <script src="PasswordAnalyser.js"></script>     <!-- CLIENT SIDE FEEDBACK -->
        <script>
            function togglePasswordVisibility() {
                const passwordField = document.getElementById('password');
                const passwordFieldType = passwordField.getAttribute('type');
                passwordField.setAttribute('type', passwordFieldType === 'password' ? 'text' : 'password');
            }

            document.getElementById('password').addEventListener('input', function() {
                const password = this.value;
                const feedback = passwordAnalyser(password);
                document.getElementById('passwordStrength').textContent = feedback[0];
                document.getElementById('passwordMissing').textContent = feedback[1];
            });

            var modal1 = document.getElementById("ModalOne");
            if (modal1) {
                modal1.style.display = "block";
            }

            var modal2 = document.getElementById("ModalTwo");
            if (modal2) {
                modal2.style.display = "block";
            }

            function Retry() {
                window.location.href = './SignUp.php';
            }
            function Later() {
                window.location.href = 'Home.php';
            }
        </script>
    </body>
</html>
