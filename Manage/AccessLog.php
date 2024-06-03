<?php
    session_start();

    if ($_SESSION['$employee_role'] != "Admin") {
        header('Location: ../LogIn.php');       // this page can only be viewed by admin
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Access Log</title>
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
                width:20%;
            }
        </style>
    </head>
    <body>
        <?php   $pageName = "Access Log";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 100px;"></div> <!-- break -->
        <div class="book-panel">
            <table>
                <tr class="no-hover">
                    <th>Log ID</th> 
                    <th>Employee ID</th>
                    <th>IP Address</th>
                    <th>Timestamp</th>
                    <th>Files Accessed</th>
                </tr>
            </table>
        </div>
        <div class="book-panel">
            <table>
                <?php
                    include '../connect.php';
                    
                    $logQuery = "SELECT log_id, employee_id, ip_address, timestamp, document_id FROM iplog";

                    $result = $mysqli->query($logQuery);

                    if ($result) {
                        echo "<table>";

                        while ($row = $result->fetch_array()) {
                            $uID = $row["employee_id"];
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["log_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["employee_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["ip_address"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["timestamp"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["document_id"]) . "</td>";
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
