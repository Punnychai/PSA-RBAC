<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>News</title>
        <link rel="stylesheet" href="Pages.css" />
    </head>
    <body>
        <?php   $pageName = "News";
                include '../Pages/HeadBar.php'; ?>
        <div style="height: 100px;"></div> <!-- break -->
        <div class="book-panel">
            <table>
                <tr class="no-hover">
                    <th>Title</th> 
                    <th>Description</th>
                    <th>Category</th>
                </tr>
            </table>
        </div>
        <div class="book-panel">
            <table>
                <?php
                    include '../connect.php';
                    $condition = isset($_GET['condition']) ? $_GET['condition'] : '';

                    // Sanitize the condition to prevent SQL injection
                    $allowed_conditions = ["'int'", "'pub'", "'org'", "('int' OR 'pub' OR 'org')"];

                    if (in_array($condition, $allowed_conditions)) {
                        $news = "SELECT n.title, n.description, n.category FROM news n WHERE n.category = $condition";

                        $result = $mysqli->query($news);
                        if ($result) {
                            echo "<table>";
                            while ($row = $result->fetch_array()) {
                                echo "<tr>";
                                echo "<td>".$row["title"]."</td>";
                                echo "<td>".$row["description"]."</td>";
                                echo "<td>".$row["category"]."</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "Error: ".$mysqli->error;
                        }
                    } else {
                        echo "Invalid condition.";
                    }

                    $mysqli->close();
                ?>
            </table>
        </div>
    </body>
</html>
