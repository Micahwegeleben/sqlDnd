<?php
include 'db_connection.php';

$error_login = '';
$error_signup = '';
$success_signup = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login_form'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            $error_login = "Please enter both username and password.";
        } else {
            // Verify user
            $sql = "SELECT * FROM Users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Check password using correct column name for hashed password
                if (password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role_id'] = $user['role_id'];

                    header("Location: index.php"); // Redirect to a dashboard page
                    exit();
                } else {
                    $error_login = "Invalid password.";
                }
            } else {
                $error_login = "User not found.";
            }
            $stmt->close();
        }
    } elseif (isset($_POST['signup_form'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $role = trim($_POST['role']);
        $dateJoined = date("Y-m-d");

        if (empty($username) || empty($email) || empty($password) || empty($role)) {
            $error_signup = "All fields are required!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_signup = "Invalid email format.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Users (username, email, password_hash, created_at, role_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $username, $email, $hashed_password, $dateJoined, $role);

            if ($stmt->execute()) {
                $success_signup = "Account created successfully! You can now log in.";
            } else {
                $error_signup = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$conn->close();