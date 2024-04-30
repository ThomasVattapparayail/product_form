<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }
    $name = $_POST["name"];
    $price = $_POST["price"];

    include("conn.php");

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO products (name, price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit();
}
?>
