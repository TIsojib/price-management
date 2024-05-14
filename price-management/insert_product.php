<?php 
include('db_connection.php');

$name = $_POST['name'];
$description = $_POST['description'];

$sql = "INSERT INTO products (name, description) VALUES ('$name', '$description')";

if ($conn->query($sql) === TRUE) {
    echo "Product added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
