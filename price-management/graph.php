<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Graph</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
    <h2>Product Graph</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
        <button type="submit" class="btn btn-primary">Generate Graph</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selected_product_id = $_POST['product_id'];

        // Fetch product name based on selected product ID
        $sql = "SELECT name FROM products WHERE id = $selected_product_id";
        $result = $conn->query($sql);
        $product_name = "";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_name = $row['name'];
        }

        // Fetch price history for the selected product
        $price_history = array();
        $sql = "SELECT price, date_added FROM prices WHERE product_id = $selected_product_id ORDER BY date_added";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $price_history[$row['date_added']] = $row['price'];
            }
        }

        // Prepare data for the graph
        $labels = array_keys($price_history);
        $prices = array_values($price_history);
    ?>

    <h3>Product: <?php echo $product_name; ?></h3>

    <canvas id="myChart"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Price History',
                    data: <?php echo json_encode($prices); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <?php
    }
    ?>

</div>

</body>
</html>
