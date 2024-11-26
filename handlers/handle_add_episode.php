<?php
include 'db_connection.php';
include 'auth.php';

$campaignQuery = "SELECT campaign_id, name FROM Campaigns";
$campaignResult = $conn->query($campaignQuery);

$characterQuery = "SELECT character_id, name FROM Characters";
$characterResult = $conn->query($characterQuery);

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campaign_id = $_POST['campaign_id'];
    $episode_name = $_POST['episode_name'];
    $episode_description = $_POST['episode_description'];
    $episode_date = $_POST['episode_date'];
    $characters = isset($_POST['characters']) ? $_POST['characters'] : [];

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

        $successMessage = "Episode successfully added!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>