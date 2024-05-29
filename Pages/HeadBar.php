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
        echo '
            <nav>
            <ul>
                <li><img src="../Images/ElGato.jpg" alt="Logo" id="logo"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">News ▼</a>
                    <div class="dropdown-content">
                        <a href="#">International Situations</a>
                        <a href="#">Public Announcements</a>
                        <a href="#">Organisational Events</a>
                    </div>
                </li>
                <li><a href="../Pages/Document.php">Documents</a></li> <!-- use RBAC to navigate -->
                <li style="position: fixed; right: 185px; color: lightgreen;">' . $fullName . '</li>
                <li style="position: fixed; right: 63px;"><a href="../Pages/About.php">About</a></li>
            </ul>
        </nav>';
        
        
        $stmt->close();
    } else {
        // If the query fails, echo a default welcome message
        echo "<h2 style='position: absolute; top: 22px; left: 100px;'>Welcome!</h2>";
    }
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(function(dropdown) {
            var toggle = dropdown.querySelector('.dropdown-toggle');
            var content = dropdown.querySelector('.dropdown-content');

            toggle.addEventListener('click', function(event) {
                event.preventDefault();
                // Hide other open dropdowns
                document.querySelectorAll('.dropdown-content').forEach(function(item) {
                    if (item !== content) item.style.display = 'none';
                });
                // Toggle the clicked dropdown
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', function(event) {
            var isClickInside = Array.from(dropdowns).some(function(dropdown) {
                return dropdown.contains(event.target);
            });

            if (!isClickInside) {
                document.querySelectorAll('.dropdown-content').forEach(function(content) {
                    content.style.display = 'none';
                });
            }
        });
    });
</script>