<?php
// Database connection
include 'db_connection.php';

// Fetch campaigns for the dropdown
$campaignQuery = "SELECT campaign_id, name FROM Campaigns";
$campaignResult = $conn->query($campaignQuery);

// Fetch characters for checkboxes
$characterQuery = "SELECT character_id, name FROM Characters";
$characterResult = $conn->query($characterQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campaign_id = $_POST['campaign_id'];
    $episode_name = $_POST['episode_name'];
    $episode_description = $_POST['episode_description'];
    $episode_date = $_POST['episode_date'];
    $characters = isset($_POST['characters']) ? $_POST['characters'] : [];

    // Insert episode into Episodes table
    $stmt = $conn->prepare("INSERT INTO Episodes (campaign_id, episode_name, episode_description, episode_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $campaign_id, $episode_name, $episode_description, $episode_date);

    if ($stmt->execute()) {
        $episode_id = $stmt->insert_id;

        // Insert selected characters into EpisodeParticipations
        if (!empty($characters)) {
            $stmtCharacter = $conn->prepare("INSERT INTO EpisodeParticipations (episode_id, character_id) VALUES (?, ?)");
            foreach ($characters as $character_id) {
                $stmtCharacter->bind_param("ii", $episode_id, $character_id);
                $stmtCharacter->execute();
            }
            $stmtCharacter->close();
        }

        echo "Episode successfully added!";
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
    <title>Add a New Episode</title>
</head>

<body>

    <h1>Add a New Episode</h1>

    <form method="POST" action="addEpisode.php">
        <label for="campaign">Campaign:</label>
        <select name="campaign_id" id="campaign" required>
            <option value="">--Select Campaign--</option>
            <?php
            if ($campaignResult->num_rows > 0) {
                while ($row = $campaignResult->fetch_assoc()) {
                    echo "<option value='{$row['campaign_id']}'>{$row['name']}</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="episode_name">Episode Name:</label>
        <input type="text" name="episode_name" id="episode_name" required><br><br>
        <label for="episode_description">Episode Summary:</label><br>
        <textarea name="episode_description" id="episode_description" rows="4" cols="50" required></textarea><br><br>

        <label for="episode_date">Date of Episode:</label>
        <input type="date" name="episode_date" id="episode_date" required><br><br>

        <label for="characters">Characters in Episode:</label><br>
        <?php
        if ($characterResult->num_rows > 0) {
            while ($row = $characterResult->fetch_assoc()) {
                echo "<input type='checkbox' name='characters[]' value='{$row['character_id']}'> {$row['name']}<br>";
            }
        }
        ?><br>

        <input type="submit" value="Add Episode">
    </form>
    <br><?php include 'footer.php'; ?>

</body>

</html>