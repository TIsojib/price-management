<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];

    $sql = "INSERT INTO prices (product_id, price) VALUES ('$product_id', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "Price added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Redirect back to add_price.php after processing
header("Location: add_price.php");
exit();
?>
