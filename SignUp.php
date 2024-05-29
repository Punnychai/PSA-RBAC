<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sign Up</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700&display=swap');

            body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            }

            .signup-container {
            width: 400px;
            height: 560px;
            margin: 50px auto; /* Center horizontally with auto margin */
            padding: 20px;
            border-radius: 8px;
            background-color: #222;
            color: #fff;
            text-align: left;
            box-shadow: 0px 10px 50px 0px rgba(0, 0, 0, 0.5); /* Add box shadow for depth */
            }

            .signup-container h2 {
            margin-bottom: 20px;
            font-size: 30px;
            font-weight: 500; /* Apply font weight */
            }

            .signup-container form {
            display: flex;
            flex-direction: column;
            }

            .signup-container h6 {
            font-size: 18px;
            font-weight: 500;
            margin: 4px 0 10px 0;
            }
            
            #email, #fullname, #username, #password {
            height: 17px;
            padding: 10px;
            margin-bottom: 8px;
            border: none;
            border-radius: 6px;
            background-color: #333;
            color: #fff;
            width: 95%;
            }

            #password {
            border-radius: 6px 0 0 6px;
            }

            #passwordStrength, #passwordMissing {
            min-height: 20px;
            margin: 4px 0 8px 0;
            }


            .signup-container select {
            padding: 10px;
            border: 1px solid #444;
            border-radius: 6px;
            background-color: #333;
            color: #fff;
            width: 100%;
            }

            #passwordVis {
            width: 10%;
            height: 37px;
            border: none;
            border-radius: 0 6px 6px 0;

            }

            #passwordVis:hover {
            background-color: #AAA;
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

            #goLogIn {
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            padding: 0px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            }

            .signup-container p {
            margin-top: 10px;
            font-size: 14px;
            }
        </style>
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
                
                echo "<p>Password Strength: $feedback</p>";
                if ($missList) {
                    echo "<p>Feedback: $missList</p>";
                }
                
                if ($feedback === 'Very Strong' || $feedback === 'Strong') {
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
                            
                            // Prepared Statement & Parameter Binding (Prevent Injection)
                            $sql = "INSERT INTO employees (email, fullname, username, pwd) VALUES (?, ?, ?, ?)";
                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param("ssss", $email, $fullname, $username, $hashedPwd);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                    $mysqli->close();
                    session_destroy();
                    header('location: Home.php');
                } else {
                    echo "<p>Password is not strong enough. Please improve your password.</p>";
                }
            }
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
        </script>
    </body>
</html>
