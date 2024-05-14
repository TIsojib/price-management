<?php
session_start();

if (isset($_SESSION['username'])) {
            header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db_connection.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch user details based on username
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User exists, verify password
        $user = $result->fetch_assoc();
        if ($result>0) {
            // Password is correct, set session and redirect to welcome page
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            // Password is incorrect, display error
            $error = "Invalid username or password";
        }
    } else {
        // User does not exist, display error
        $error = "Invalid username or password";
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <?php
    if (isset($error)) {
        echo '<div class="alert alert-danger mt-3">' . $error . '</div>';
    }
    ?>
</div>

</body>
</html>
