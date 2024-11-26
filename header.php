<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Application</title>
    <link rel="stylesheet" type="text/css" href="/styles_header.css">
    <link rel="stylesheet" type="text/css" href="/styles.css">
</head>

<body>
    <header>
        <div class="header-container" style="display: flex; align-items: center;">
            <div class="site-name">
                <a href="index.php">My Application</a>
            </div>
            <div class="user-info" style="margin-left: auto;">
                <?php if (isset($_SESSION['username']) && isset($_SESSION['role_id'])): ?>
                    <?php
                    $role = $_SESSION['role_id'] === 'admin' ? 'Administrator' : 'User';
                    ?>
                    <span style="margin-right: 20px;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        (<?php echo htmlspecialchars($role); ?>)</span>
                    <a href="logout.php" class="button">Logout</a>
                <?php else: ?>
                    <a href="loginPage.php" class="button">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
</body>

</html>