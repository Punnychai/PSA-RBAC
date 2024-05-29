<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin' && $_SESSION['$employee_role'] != 'Manager') {
        header('Location: ../LogIn.php');
        exit();
    }

    include '../connect.php';

    if (isset($_GET['dID'])) {
        $dID = intval($_GET['dID']); // Ensure the ID is an integer for security
        $stmt = $mysqli->prepare("DELETE FROM documents WHERE document_id = ?");
        $stmt->bind_param('i', $dID);

        if ($stmt->execute()) {
            header("Location: DocsManage.php");
            exit();
        } else {
            echo "DELETE failed. Error: " . $mysqli->error;
        }

        $stmt->close();
    } else {
        echo "Invalid document ID.";
    }

    $mysqli->close();
?>
