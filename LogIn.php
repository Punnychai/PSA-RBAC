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
        
        ?>

        <script>
            document.getElementById('password').addEventListener('input', function() {
                const password = this.value;
                document.getElementById('passwordStrength').textContent = "incorrect Username or Password";
            });
        </script>
    </body>
</html>
