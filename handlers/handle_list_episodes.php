<?php
include 'db_connection.php';

$campaignQuery = "
    SELECT c.campaign_id, c.name AS campaign_name, e.episode_id, e.episode_name, e.episode_description, e.episode_date 
    FROM Campaigns c
    LEFT JOIN Episodes e ON c.campaign_id = e.campaign_id
    ORDER BY c.name, e.episode_date
";
$campaignResult = $conn->query($campaignQuery);

$campaigns = [];

if ($campaignResult->num_rows > 0) {
    while ($row = $campaignResult->fetch_assoc()) {
        $campaign_id = $row['campaign_id'];
        $campaign_name = $row['campaign_name'];
        if (!isset($campaigns[$campaign_id])) {
            $campaigns[$campaign_id] = [
                'name' => $campaign_name,
                'episodes' => []
            ];
        }
        if ($row['episode_id']) {
            $campaigns[$campaign_id]['episodes'][] = [
                'episode_id' => $row['episode_id'],
                'episode_name' => $row['episode_name'],
                'episode_description' => $row['episode_description'],
                'episode_date' => $row['episode_date']
            ];
        }
    }
}

$conn->close();
?>