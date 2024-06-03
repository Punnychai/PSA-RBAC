<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Manager') {
        header('Location: ../LogIn.php');
        exit();
    }

    include '../connect.php';

    if (isset($_GET['dID'])) {
        $dID = intval($_GET['dID']); // Ensure the ID is an integer for security
        $stmt = $mysqli->prepare("SELECT document_name, department_id, confidentiality FROM documents WHERE document_id = ?");
        $stmt->bind_param('i', $dID);
        $stmt->execute();
        $stmt->bind_result($document_name, $department_id, $confidentiality);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Invalid document ID.";
        exit();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $document_name = htmlspecialchars($_POST['document_name']);
        $confidentiality = htmlspecialchars($_POST['confidentiality']);
    
        $stmt = $mysqli->prepare("UPDATE documents SET document_name = ?, confidentiality = ? WHERE document_id = ?");
        $stmt->bind_param('ssi', $document_name, $confidentiality, $dID);
    
        if ($stmt->execute()) {
            header("Location: DocsManage.php");
            exit();
        } else {
            echo "UPDATE failed. Error: " . $mysqli->error;
        }
    
        $stmt->close();
    }
    
    $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Document</title>
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
                height: 310px;
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
            #document_name, #department_id, #confidentiality {
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
        <?php   $pageName = "Edit Document";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 200px;"></div> <!-- break -->
        <div class="login-container">
            <form method="post">
                <label for="document_name"><h6>Document Name :</h6></label>
                <input type="text" id="document_name" name="document_name" value="<?php echo htmlspecialchars($document_name); ?>" required><br>
                <label for="confidentiality"><h6>Confidentiality :</h6></label>
                <select id="confidentiality" name="confidentiality" required style="height: 37px; width: 100%;">
                    <?php
                        if ($_SESSION['$employee_role'] == 'Admin') {       // Manager cannot see this
                            echo '<option value=5>5</option>';
                        }
                    ?>
                    <option value=4>4</option>
                    <option value=3>3</option>
                    <option value=2>2</option>
                    <option value=1>1</option>
                </select><br>

                <input type="submit" value="Update">
                <br style="height: 100px;" />
                <a href="DocsManage.php" class="button cancel">Cancel</a>
            </form>
        </div>
    </body>
</html>
