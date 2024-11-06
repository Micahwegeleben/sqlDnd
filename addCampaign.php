<?php
// Database connection
include 'db_connection.php';

// Fetch users for the dropdown
$userQuery = "SELECT user_id, username FROM Users";
$userResult = $conn->query($userQuery);

// Handle form submission for adding a new campaign
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campaign_name = $_POST['campaign_name'];
    $description = $_POST['description'];
    $user_id = $_POST['user_id'];

    // Insert campaign into Campaigns table
    $stmt = $conn->prepare("INSERT INTO Campaigns (name, description, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $campaign_name, $description, $user_id);

    if ($stmt->execute()) {
        echo "Campaign successfully added!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch existing campaigns for display
$campaignQuery = "SELECT c.campaign_id, c.name, c.description, u.username, c.created_at
                  FROM Campaigns c
                  JOIN Users u ON c.user_id = u.user_id
                  ORDER BY c.created_at DESC";
$campaignResult = $conn->query($campaignQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add and View Campaigns</title>
</head>

<body>

    <h1>Add a New Campaign</h1>

    <form method="POST" action="addCampaign.php">
        <label for="campaign_name">Campaign Name:</label>
        <input type="text" name="campaign_name" id="campaign_name" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" rows="4" cols="50" required></textarea><br><br>

        <label for="user_id">Campaign Owner:</label>
        <select name="user_id" id="user_id" required>
            <option value="">--Select User--</option>
            <?php
            if ($userResult->num_rows > 0) {
                while ($row = $userResult->fetch_assoc()) {
                    echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                }
            }
            ?>
        </select><br><br>

        <input type="submit" value="Add Campaign">
    </form>

    <h2>Existing Campaigns</h2>
    <table border="1">
        <tr>
            <th>Campaign Name</th>
            <th>Description</th>
            <th>Owner</th>
            <th>Created At</th>
        </tr>
        <?php
        if ($campaignResult->num_rows > 0) {
            while ($row = $campaignResult->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No campaigns found.</td></tr>";
        }
        ?>
    </table><?php include 'footer.php'; ?>

</body>

</html>