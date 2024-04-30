<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();

    

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
    <a href="logout.php">Logout</a>
    
    <h2>Add Product</h2>
      
    
    <form action="add_product.php" method="post">
        <input type='hidden' name='csrf_token' value='<?php echo $_SESSION["csrf_token"]; ?>'>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" min="0.01" step="0.01" required><br>
        <input type="submit" value="Add Product">
    </form>


    <?php

        include("conn.php");

        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, name, price FROM products";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>$" . $row["price"] . "</td>";
                echo "<td><a href='edit_product.php?id=" . $row["id"] . "'>Edit</a> ";
                echo "<a href='delete_product.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No products found.";
        }
    

    $conn->close();

    ?>

</body>
</html>
