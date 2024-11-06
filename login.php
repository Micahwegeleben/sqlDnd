<?php
// Database connection
include 'db_connection.php';

// Handle form submission for adding a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password for security
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into Users table
    $stmt = $conn->prepare("INSERT INTO Users (username, password_hash, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password_hash, $email);

    if ($stmt->execute()) {
        echo "User successfully created!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
</head>

<body>

    <h1>Create a New User</h1>

    <form method="POST" action="addUser.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <input type="submit" value="Create User">
    </form><?php include 'footer.php'; ?>

</body>

</html>