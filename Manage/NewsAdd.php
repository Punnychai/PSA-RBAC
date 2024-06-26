<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Reporter') {
        header('Location: ../LogIn.php');
        exit();
    }

    include '../connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $category = htmlspecialchars($_POST['category']);
        $filename = htmlspecialchars($_POST['filename']);
    
        $stmt = $mysqli->prepare("INSERT INTO news (title, description, category, filename) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $title, $description, $category, $filename);
    
        if ($stmt->execute()) {
            header("Location: NewsManage.php");
            exit();
        } else {
            echo "INSERT failed. Error: " . $mysqli->error;
        }
    
        $stmt->close();
    }
    
    $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Add News</title>
        <link rel="stylesheet" href="../Pages/Pages.css" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700&display=swap');

            body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            }
            .login-container {
                width: 400px;
                height: 510px;
                margin: 50px auto; /* Center horizontally with auto margin */
                padding: 20px;
                border-radius: 8px;
                background-color: #222;
                color: #fff;
                text-align: left;
                box-shadow: 0px 10px 50px 0px rgba(0, 0, 0, 0.5); /* Add box shadow for depth */
            }
            .login-container h2 {
                margin-bottom: 20px;
                font-size: 30px;
                font-weight: 500; /* Apply font weight */
            }
            .login-container form {
                display: flex;
                flex-direction: column;
            }
            .login-container h6 {
                font-size: 18px;
                font-weight: 500;
                margin: 4px 0 10px 0;
            }            
            #title, #description, #category, #filename {
                height: 17px;
                padding: 10px;
                margin-bottom: 8px;
                border: none;
                border-radius: 6px;
                background-color: #333;
                color: #fff;
                width: 95%;
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
            .cancel {
                background-color: #D71609;
                text-align: center;
                text-decoration: none;
                color: white;
                font-size: 16px;
                font-weight: 600;
                padding: 12px 20px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
            }
            .cancel:hover {
                background-color: darkred;
            }
            .login-container p {
                margin-top: 10px;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <?php   $pageName = "Add News";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 200px;"></div> <!-- break -->
        <div class="login-container">
            <form method="post">
                <label for="title"><h6>News Title :</h6></label>
                <input type="text" id="title" name="title" required><br>
                <label for="description"><h6>Description :</h6></label>
                <textarea id="description" name="description" rows="4" required style="font-family: 'Inter', sans-serif;"></textarea><br>
                <label for="category"><h6>Category :</h6></label>
                <select id="category" name="category" required style="height: 37px; width: 100%;">
                    <option value="INT">International Situations</option>
                    <option value="PUB">Public Announcements</option>
                    <option value="ORG">Organisational Events</option>
                </select><br>
                <label for="filename"><h6>File :</h6></label>
                <input type="text" id="filename" name="filename" required><br>
                <input type="submit" value="Add News">
                <br style="height: 100px;" />
                <a href="NewsManage.php" class="button cancel">Cancel</a>
            </form>
        </div>
    </body>
</html>
