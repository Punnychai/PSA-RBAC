<?php       // this file is currently unused
    include 'connect.php';
    if(isset($_SESSION['signup'])){
            unset($_SESSION['signup']);
            $email = $_SESSION['email'];
            $fullname = $_SESSION['fullname'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            global $mysqli;
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $username, $hashedPassword);
            $stmt->execute();
            $stmt->close();
    }
?>
