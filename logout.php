<?php
session_start();
session_unset();
session_destroy();
header("Location: loginPage.php"); // Redirect to login page
exit();