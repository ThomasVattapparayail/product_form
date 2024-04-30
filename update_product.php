<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    echo($id);
    include("conn.php");

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE products SET name = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $name, $price, $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        header("Location: dashboard.php");
    } else {
        "' onclick='return confirm(\"No Product Updated?\")'";
    }

    $stmt->close();
    $conn->close();
}
?>
