<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin') {
        header('Location: ../LogIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Employee Management</title>
        <link rel="stylesheet" href="../Pages/Pages.css" />
        <style>
            .book-panel {
                width: 90%;
                margin-left: 100px;
            }
            td {
                font-size: 20px;
                font-weight: 400px;
                margin: 0;
                padding: 0;
            }
            td a {
                font-family: 'Inter';
                text-decoration: none;
                font-weight: 600;
            }
            tr th, tr td {
                width:16.6%;
            }
        </style>
    </head>
    <body>
        <?php   $pageName = "Employee Management";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 100px;"></div> <!-- break -->
        </div>
        <div class="book-panel">
            <table> 
                <tr class="no-hover">
                    <th>Employee ID</th> 
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Manage</th>
                </tr>
            </table>
        </div>
        <div class="book-panel">
            <table>
                <?php
                    include '../connect.php';
                    
                    $empList = "SELECT e.employee_id, e.email, e.fullname, e.username, e.department_id, r.role_name FROM employees e
                             LEFT JOIN roles r ON e.role_id = r.role_id";

                    $result = $mysqli->query($empList);

                    if ($result) {
                        echo "<table>";

                        while ($row = $result->fetch_array()) {
                            $uID = $row["employee_id"];
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["employee_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["fullname"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["department_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["role_name"]) . "</td>";
                            echo "<td>
                                    <a href='UserEdit.php?uID=$uID' style='color: #028A0F;'>
                                        <p>Edit</p>
                                    </a>
                                    <a href='UserRemove.php?uID=$uID' style='color: #D71609;'>
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
    </body>
</html>
