<?php
include 'handlers/handle_login_page.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Sign-Up Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4A90E2, #1E2A38);
            color: #333;
            margin: 0;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .container {
            flex-grow: 1;
            display: flex;
            justify-content: space-between;
            width: 80%;
            max-width: 800px;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
        }

        footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #ccc;
            background-color: #f8f8f8;
        }

        .form-box {
            width: 50%;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .form-box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-box label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            color: #555;
            font-size: 0.9em;
        }

        .form-box input,
        .form-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: border 0.3s;
        }

        .form-box input:focus,
        .form-box select:focus {
            border-color: #4A90E2;
            outline: none;
        }

        .form-box button {
            background-color: #4A90E2;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .form-box button:hover {
            background-color: #357ABD;
        }

        .message {
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 0.9em;
            text-align: center;
        }

        .error {
            background-color: #ff4c4c;
        }

        .success {
            background-color: #4CAF50;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <div class="container">
            <div class="form-box">
                <h2>Login</h2>
                <?php if ($error_login): ?>
                    <div class="message error"><?php echo htmlspecialchars($error_login); ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="hidden" name="login_form" value="1">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
            </div>

            <div class="form-box">
                <h2>Sign Up</h2>
                <?php if ($error_signup): ?>
                    <div class="message error"><?php echo htmlspecialchars($error_signup); ?></div>
                <?php elseif ($success_signup): ?>
                    <div class="message success"><?php echo htmlspecialchars($success_signup); ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="hidden" name="signup_form" value="1">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>