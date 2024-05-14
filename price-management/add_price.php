<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Price</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Add Price</h2>
    <form method="post" action="add_price_process.php">
        <div class="form-group">
            <label for="product">Select Product:</label>
            <select class="form-control" id="product" name="product_id">
                <?php
                include('db_connection.php');
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
                    }
                } else {
                    echo "<option>No products available</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price">
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <br>
    <a href="index.php" class="btn btn-secondary">Back to Home</a>
</div>

</body>
</html>
