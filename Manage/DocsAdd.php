<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Director' && $_SESSION['$employee_role'] != 'Manager') {
        header('Location: ../LogIn.php');
        exit();
    } else {
        $department = $_SESSION['$department'];
    }

    include '../connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $doc_name = htmlspecialchars($_POST['document_name']);
        $dept_id = htmlspecialchars($_POST['department_id']);
        $conf_val = htmlspecialchars($_POST['confidentiality']);
        
        $stmt = $mysqli->prepare("INSERT INTO documents (document_name, department_id, confidentiality) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $doc_name, $dept_id, $conf_val);
    
        if ($stmt->execute()) {
            if ($_SESSION['$employee_role'] == 'Director') {
                header("Location: ../Pages/Document.php");    // Director do not have access to DocsManage.php
            } else {
                header("Location: DocsManage.php");
            }
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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Document</title>
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
                height: 410px;
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
        <?php   $pageName = "Add Document";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 200px;"></div> <!-- break -->

        <!-- the fix start here, and then php on the top -->
        <div class="login-container">
            <form method="post">
                <label for="document_name"><h6>Document Name :</h6></label>
                <input type="text" id="document_name" name="document_name" value="<?php echo htmlspecialchars($document_name); ?>" required><br>
                
            

                <?php
                    if  ($_SESSION['$employee_role'] == 'Manager') {     // Manager can't select document's department
                        echo '<label for="department_id"><h6>Department :</h6></label>';
                        echo '<select id="department_id" name="department_id" style="height: 37px; width: 100%;">';
                        switch ($department)  {
                            case 'CSC':
                                $fullDept = "CyberSecurity";
                            case 'ICT';
                                $fullDept = "Information and Communications Technology";
                            case 'NIS':
                                $fullDept = "Network Infrastructure";
                            case 'RND';
                                $fullDept = "Research and Development";
                        }
                        echo '<option value="' . $department . '">' . $fullDept . '</option></select><br>';
                    }
                    else {      // Admin $ Director
                        echo '<label for="department_id"><h6>Department :</h6></label>';
                        echo '<select id="department_id" name="department_id" style="height: 37px; width: 100%;">
                                <option value="CSC" ' . ($department_id == 'CSC' ? 'selected' : '') . '>CyberSecurity</option>
                                <option value="ICT" ' . ($department_id == 'ICT' ? 'selected' : '') . '>Information and Communications Technology</option>
                                <option value="NIS" ' . ($department_id == 'NIS' ? 'selected' : '') . '>Network Infrastructure</option>
                                <option value="RND" ' . ($department_id == 'RND' ? 'selected' : '') . '>Research and Development</option>
                              </select><br>';
                    }
                ?>


                <label for="confidentiality"><h6>Confidentiality :</h6></label>
                <select id="confidentiality" name="confidentiality" required style="height: 37px; width: 100%;">
                    <?php
                        if ($_SESSION['$employee_role'] != 'Manager') {       // Manager cannot see this
                            echo '<option value=5>5</option>';
                        }
                    ?>
                    <option value=4>4</option>
                    <option value=3>3</option>
                    <option value=2>2</option>
                    <option value=1>1</option>
                </select><br>

                <input type="submit" value="Add Document">
                <br style="height: 100px;" />
                <?php
                    if ($_SESSION['$employee_role'] == 'Director') {        // redirect Director to allowed page
                        echo '<a href="../Pages/Document.php" class="button cancel">Cancel</a>';
                    }
                    else {
                        echo '<a href="DocsManage.php" class="button cancel">Cancel</a>';
                    }
                ?>
            </form>
        </div>
    </body>
</html>
