<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    include("conn.php");

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // var_dump($row);
        // exit;
        $product_id = $row["id"];
        $product_name = $row["name"];
        $product_price = $row["price"];
    } else {
        echo "Product not found.";
        exit();
    }

    $stmt->close();
    $conn->close();
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   
    <form action="update_product.php" method="post">
        <input type="hidden" name="id" value="<?php echo $product_id; ?>">
        <label for="name">Name:</label><br>
        <input type="text"  name="name" value="<?php echo $product_name; ?>" required><br>
        <label for="price">Price:</label><br>
        <input type="number"  name="price" value="<?php echo $product_price; ?>" min="0.01" step="0.01" required><br>
        <input type="submit" value="Update Product">
    </form>
</body>
</html>
