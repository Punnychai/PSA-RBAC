<?php
    session_start();

    if (!isset($_SESSION['$employee_role'])) {
        header('Location: ../LogIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Documents</title>
        <link rel="stylesheet" href="Pages.css" />
    </head>
    <body>
        <div style="background-color: #3F3F3F;
            color: #fff;
            margin: 30px 40px;
            border-radius: 36px;
            height: 85px;
            font-size: 24px;
            font-weight: 500;">

            <?php
                $username = $_SESSION['username'];
                echo "<h2 style='position: absolute; top: 22px; left: 100px;'> " . "<span style='color: lightgreen'>$username</span>" . " is on Documents Page</h2><br>";
            ?>
        </div>
        <div class="book-panel">
            <table>
                <tr class="no-hover">
                    <th>Document</th> 
                    <th>Origin Department</th>
                    <th>Confidentiality</th>
                </tr>
            </table>
        </div>
        <div class="book-panel">
            <table>
                <?php
                    include '../connect.php';
                    
                    if ($_SESSION['$employee_role'] == 'Admin' || $_SESSION['$employee_role'] == 'Director') {
                    // view everything
                        $doc = "SELECT document_name, department_id, confidentiality FROM documents";
                    }
                    else if ($_SESSION['$employee_role'] == 'Manager') {
                    // view everything up to level 4
                        $doc = "SELECT document_name, department_id, confidentiality FROM documents WHERE documents.confidentiality < 5";
                    }
                    else if ($_SESSION['$employee_role'] == 'Staff') {
                    // view everything in level 1,2 and level 3 in same department
                        $doc = "SELECT d.document_id, d.document_name, d.department_id, d.confidentiality 
                                FROM employees e
                                JOIN documents d ON e.department_id = d.department_id AND e.role_id = 2 AND d.confidentiality <= 3
                                WHERE e.role_id = 2 AND e.employee_id = " . $_SESSION['employee_id'] .
                                " UNION
                                SELECT d.document_id, d.document_name, d.department_id, d.confidentiality 
                                FROM employees e
                                JOIN documents d ON e.role_id = 2 AND d.confidentiality <= 2
                                WHERE e.role_id = 2 AND e.department_id != d.department_id AND e.employee_id =" . $_SESSION['employee_id'];
                    }
                    else if ($_SESSION['$employee_role'] == 'Intern') {
                    // view level 1
                        $doc = "SELECT document_name, department_id, confidentiality FROM documents WHERE documents.confidentiality = 1";
                    }

                    $result = $mysqli->query($doc);

                    if ($result) {
                        echo "<table>";

                        while ($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>".$row["document_name"]."</td>";
                            echo "<td>".$row["department_id"]."</td>";
                            echo "<td>".$row["confidentiality"]."</td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "Error: ".$mysqli->error;
                    }

                    $mysqli->close();
                ?>
            </table>
        </div>
    </body>
</html>
