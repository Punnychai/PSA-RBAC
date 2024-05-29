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
        <?php   $pageName = "Documents";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 100px;"></div> <!-- break -->
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
                    
                    switch ($_SESSION['$employee_role']) {
                        case 'Admin':
                        case 'Director':
                            $condition = " ";
                            break;
                        case 'Manager':
                            $condition = "WHERE d.confidentiality < 5";
                            break;
                        case 'Staff':
                            $condition = "JOIN employees e ON e.department_id = d.department_id AND e.role_id = 2 AND d.confidentiality <= 3
                            WHERE e.role_id = 2 AND e.employee_id = " . $_SESSION['employee_id'] .
                            " UNION
                            SELECT d.document_id, d.document_name, d.department_id, d.confidentiality FROM employees e
                            JOIN documents d ON e.role_id = 2 AND d.confidentiality <= 2
                            WHERE e.role_id = 2 AND e.department_id != d.department_id AND e.employee_id =" . $_SESSION['employee_id'];
                            break;
                        case 'Intern':
                            $condition = " WHERE d.confidentiality = 1";
                            break;
                    }
                    
                    $doc = "SELECT d.document_id, d.document_name, d.department_id, d.confidentiality FROM documents d ". $condition;

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
