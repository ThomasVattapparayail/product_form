<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    include('conn.php');

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "Registration successful!";
    header("Location: index2.php");
    exit();
}
?>
