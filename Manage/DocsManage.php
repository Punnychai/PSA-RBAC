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
                width:25%;
            }
        </style>
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

                    $doc = "SELECT document_id, document_name, department_id, confidentiality FROM documents";
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
    </body>
</html>
