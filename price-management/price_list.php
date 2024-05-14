// <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price List</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Price List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Current Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('db_connection.php');

            // Subquery to get the latest price for each product
            $latest_price_query = "(SELECT price
                                    FROM prices
                                    WHERE product_id = p.id
                                    ORDER BY date_added DESC
                                    LIMIT 1)";

            $sql = "SELECT p.name AS product_name, p.description AS product_description, $latest_price_query AS current_price
                    FROM products p";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["product_description"] . "</td>";
                    echo "<td>" . $row["current_price"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No products available</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <br>
    <a href="index.php" class="btn btn-secondary">Back to Home</a>
</div>

</body>
</html>
