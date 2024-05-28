<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Home</title>
        <link rel="stylesheet" href="Pages.css" />
    </head>
    <body>
        <nav>
            <ul>
                <li style="margin-left: 100px;"><a href="Home.php">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">News ▼</a>
                    <div class="dropdown-content">
                        <a href="#">International Situations</a>
                        <a href="#">Public Announcements</a>
                        <a href="#">Organisational Events</a>
                    </div>
                </li>
                <li><a href="Document.php">Documents</a></li> <!-- use RBAC to navigate -->
                <li style="margin-left: 1000px;"><a href="../LogIn.php">Log In</a></li>
                <li><a href="About.php">About</a></li>
            </ul>
        </nav>

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
        <img src="../Images/ElGato.jpg" alt="Logo" style="width: 70px; height: 70px; border-radius: 50%; position: absolute; top: 37px; left:50px;">
    
        <div>
            <!-- related contents -->
        </div>

        <div>
            <!-- another related contents -->
        </div>
    </body>
</html>

