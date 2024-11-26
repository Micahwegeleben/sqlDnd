<?php
include 'db_connection.php';
include 'auth.php';

$userQuery = "SELECT user_id, username FROM Users";
$userResult = $conn->query($userQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campaign_name = $_POST['campaign_name'];
    $description = $_POST['description'];
    $user_id = $_POST['user_id'];

    $stmt = $conn->prepare("INSERT INTO Campaigns (name, description, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $campaign_name, $description, $user_id);

    if ($stmt->execute()) {
        echo "Campaign successfully added!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$campaignQuery = "SELECT c.campaign_id, c.name, c.description, u.username, c.created_at
                  FROM Campaigns c
                  JOIN Users u ON c.user_id = u.user_id
                  ORDER BY c.created_at DESC";
$campaignResult = $conn->query($campaignQuery);

$conn->close();
?>