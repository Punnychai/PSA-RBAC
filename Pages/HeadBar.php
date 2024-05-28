<div style="background-color: #3F3F3F;
        color: #fff;
        margin: 30px 40px;
        border-radius: 36px;
        height: 85px;
        font-size: 24px;
        font-weight: 500;">

    <?php
        include '../connect.php';
        session_start();

        // Use a prepared statement to prevent SQL injection
        $getName = "SELECT fullname FROM employees WHERE username = ? LIMIT 1";
        $stmt = $mysqli->prepare($getName);

        if ($stmt) {
            // Bind the session username as a parameter
            $stmt->bind_param("s", $_SESSION['username']);

            // Execute the query & Bind the result to variables
            $stmt->execute();
            $stmt->bind_result($fullName);

            // Fetch the result
            $stmt->fetch();

            if ($username) {
                // If the user's name is retrieved, display the welcome message
                echo "<h2 style='position: absolute; top: 22px; left: 100px;'>Welcome, " . "<span style='color: lightgreen'>$fullName</span>" . "!</h2><br>";

            } else {
                // If the query returns an empty result set, display a default welcome message
                echo "<p>Welcome!</p><br>";
            }
            
            $stmt->close();
        } else {
            // If the query fails, echo a default welcome message
            echo "<h2 style='position: absolute; top: 22px; left: 100px;'>Welcome!</h2>";
        }
    ?>
</div>