<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Manager') {
        header('Location: ../LogIn.php');      // this page can only be viewed by Admin and Manager
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document Management</title>
        <link rel="stylesheet" href="../Pages/Pages.css" />
        <link rel="stylesheet" href="Manage.css" />
    </head>
    <body>
        <?php   $pageName = "Document Management";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 100px;"></div> <!-- break -->
        </div>
        <div class="book-panel">
            <table> 
                <tr class="no-hover">
                    <th>Document</th> 
                    <th>Origin Department</th>
                    <th>Confidentiality</th>
                    <th>Manage</th>
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
                        case 'Reporter':
                            $condition = " WHERE d.confidentiality = 1";
                            break;
                    }
                    
                    $doc = "SELECT d.document_id, d.document_name, d.department_id, d.confidentiality FROM documents d ". $condition;

                    $result = $mysqli->query($doc);

                    if ($result) {
                        echo "<table>";

                        while ($row = $result->fetch_array()) {
                            $dID = $row["document_id"];
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["document_name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["department_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["confidentiality"]) . "</td>";
                            echo "<td>
                                    <a href='DocsEdit.php?dID=$dID' style='color: #028A0F;'>
                                        <p>Edit</p>
                                    </a>
                                    <a href='DocsRemove.php?dID=$dID' style='color: #D71609;'>
                                        <p>Remove</p>
                                    </a>
                                </td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "Error: " . $mysqli->error;
                    }
                ?>
            </table>
        </div>
        <a href="DocsAdd.php" class="add-button">
            <label>Add New Document</label>
        </a>
    </body>
</html>
