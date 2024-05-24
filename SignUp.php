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
            <form id="signupForm" method="post" action="signup.php">
                <div>
                    <label for="email"><h6>Email :</h6></label>
                    <input type="text" id="email" name="email" required>
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
                <button type="submit">Sign Up</button>
            </form>
            <p id="message"></p>
        </div>
        
        <?php
            include 'PasswordAnalyser.php';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                list($feedback, $missList) = passwordAnalyser($password);
                
                echo "<p>Password Strength: $feedback</p>";
                if ($missList) {
                    echo "<p>Feedback: $missList</p>";
                }
                
                if ($feedback === 'Very Strong' || $feedback === 'Strong') {
                    // Call your createUser function from user_management.php to create the user
                    // createUser($username, $password);
                    echo "<p>Account created successfully.</p>";
                } else {
                    echo "<p>Password is not strong enough. Please improve your password.</p>";
                }
            }
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
