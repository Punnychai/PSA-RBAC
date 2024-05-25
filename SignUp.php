<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sign Up</title>
        <link rel="stylesheet" href="SignUp.css" />
    </head>
    <body>
        <div class="signup-container">
            <h2>Sign Up</h2>
            <form id="signupForm" action="" method="post">
                <div>
                    <label for="email"><h6>Email :</h6></label>
                    <input type="text" id="email" name="email" required>
                    <label for ="fullname"><h6>Full Name :</h6></label>
                    <input type="text" id="fullname" name="fullname" required>
                    <label for="username"><h6>Username :</h6></label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="password"><h6>Password :</h6></label>
                    <div style="display: flex;">
                        <input type="password" id="password" name="password" required>
                        <button type="button" onclick="togglePasswordVisibility()">Show</button>
                    </div>
                </div>
                <div>
                    <p>Password Strength : <span id="passwordFeedback"></span></p>
                </div>
                <input type="submit" name="SignUp" value="Sign Up">
            </form>
            <p id="message"></p>
        </div>
        
        <?php
            include 'PasswordAnalyser.php';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST['email'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                list($feedback, $missList) = passwordAnalyser($password);
                
                echo "<p>Password Strength: $feedback</p>";
                if ($missList) {
                    echo "<p>Feedback: $missList</p>";
                }
                
                // if ($feedback === 'Very Strong' || $feedback === 'Strong') {
                    session_start();
                    if (isset($_POST['SignUp'])) {
                        include 'connect.php';
                        
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
                        
                            $sql = "INSERT INTO employees (email, fullname, username, pwd) VALUES (?, ?, ?, ?)";
                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param("ssss", $email, $fullname, $username, $hashedPwd);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                    $mysqli->close();
                    session_destroy();
                    header('location: Landing.php');
                    echo "<p>Account created successfully.</p>";
                } else {
                    echo "<p>Password is not strong enough. Please improve your password.</p>";
                }
            // } this is for password condition
        ?>

        <script>
            function togglePasswordVisibility() {
                const passwordField = document.getElementById('password');
                const passwordFieldType = passwordField.getAttribute('type');
                passwordField.setAttribute('type', passwordFieldType === 'password' ? 'text' : 'password');
            }

            document.getElementById('password').addEventListener('input', function() {
                const password = this.value;
                const feedback = passwordAnalyser(password);
                document.getElementById('passwordFeedback').textContent = feedback.join('');
            });
        </script>
    </body>
</html>
