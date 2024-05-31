<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Reporter') {
        header('Location: ../LogIn.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>News Management</title>
        <link rel="stylesheet" href="../Pages/Pages.css" />
        <link rel="stylesheet" href="Manage.css" />
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
        <?php   $pageName = "News Management";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 100px;"></div> <!-- break -->
        </div>
        <div class="book-panel">
            <table> 
                <tr class="no-hover">
                    <th>News Title</th> 
                    <th>Category</th>
                    <th>File</th>
                    <th>Manage</th>
                </tr>
            </table>
        </div>
        <div class="book-panel">
            <table>
                <?php
                    include '../connect.php';
                    
                    $news = "SELECT n.news_id, n.title, n.category, n.filename FROM news n";

                    $result = $mysqli->query($news);

                    if ($result) {
                        echo "<table>";

                        while ($row = $result->fetch_array()) {
                            $nID = $row["news_id"];
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["category"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["filename"]) . "</td>";
                            echo "<td>
                                    <a href='NewsEdit.php?nID=$nID' style='color: #028A0F;'>
                                        <p>Edit</p>
                                    </a>
                                    <a href='NewsRemove.php?nID=$nID' style='color: #D71609;'>
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
        <a href="NewsAdd.php" class="add-button">
            <label>Add New News</label>
        </a>    
    </body>
</html>
