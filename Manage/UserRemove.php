<?php
    session_start();

    if ($_SESSION['$employee_role'] != 'Admin') {
        header('Location: ../LogIn.php');
        exit();
    }

    include '../connect.php';

    if (isset($_GET['uID'])) {
        $uID = intval($_GET['uID']); // Ensure the ID is an integer for security
        $stmt = $mysqli->prepare("DELETE FROM employees WHERE employee_id = ?");
        $stmt->bind_param('i', $uID);

        if ($stmt->execute()) {
            header("Location: UserManage.php");
            exit();
        } else {
            echo "DELETE failed. Error: " . $mysqli->error;
        }

        $stmt->close();
    } else {
        echo "Invalid employee ID.";
    }

    $mysqli->close();
?>
