<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Director' && $_SESSION['$employee_role'] != 'Manager') {
        header('Location: ../LogIn.php');      // this page can only be viewed by Admin, Director, and Manager
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="Manage.css" />
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
                echo "<h2 style='position: absolute; top: 22px; left: 100px;'> " . "<span style='color: lightgreen'>$username</span>" . " is on Documents Management Page</h2><br>";
            ?>
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

                    $doc = "SELECT document_name, department_id, confidentiality FROM documents";
                    $result = $mysqli->query($doc);

                    if ($result) {
                        echo "<table>";

                        while ($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>".$row["document_name"]."</td>";
                            echo "<td>".$row["department_id"]."</td>";
                            echo "<td>".$row["confidentiality"]."</td>";
                            echo "<td>manage</td>";     // placeholder
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
