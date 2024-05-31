<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Manager') {
        header('Location: ../LogIn.php');
        exit();
    }

    include '../connect.php';

    if (isset($_GET['nID'])) {
        $nID = intval($_GET['nID']); // Ensure the ID is an integer for security
        $stmt = $mysqli->prepare("DELETE FROM news WHERE news_id = ?");
        $stmt->bind_param('i', $nID);

        if ($stmt->execute()) {
            header("Location: NewsManage.php");
            exit();
        } else {
            echo "DELETE failed. Error: " . $mysqli->error;
        }

        $stmt->close();
    } else {
        echo "Invalid news ID.";
    }

    $mysqli->close();
?>
