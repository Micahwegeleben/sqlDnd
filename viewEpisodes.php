<?php
// Database connection
include 'db_connection.php';

// Fetch campaigns with their episodes
$campaignQuery = "
    SELECT c.campaign_id, c.name AS campaign_name, e.episode_id, e.episode_name, e.episode_description, e.episode_date 
    FROM Campaigns c
    LEFT JOIN Episodes e ON c.campaign_id = e.campaign_id
    ORDER BY c.name, e.episode_date
";
$campaignResult = $conn->query($campaignQuery);

$campaigns = [];

// Organize data by campaign with episodes nested inside
if ($campaignResult->num_rows > 0) {
    while ($row = $campaignResult->fetch_assoc()) {
        $campaign_id = $row['campaign_id'];
        $campaign_name = $row['campaign_name'];

        // Create campaign entry if it doesn't exist
        if (!isset($campaigns[$campaign_id])) {
            $campaigns[$campaign_id] = [
                'name' => $campaign_name,
                'episodes' => []
            ];
        }

        // Add episode to campaign's episode list
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Episodes by Campaign</title>
</head>
<body>

<h1>Episodes by Campaign</h1>

<?php if (!empty($campaigns)): ?>
    <?php foreach ($campaigns as $campaign): ?>
        <h2><?php echo htmlspecialchars($campaign['name']); ?></h2>
        <?php if (!empty($campaign['episodes'])): ?>
            <ul>
                <?php foreach ($campaign['episodes'] as $episode): ?>
                    Episodes <br> <br>
                    <li>
                        <?php echo htmlspecialchars($episode['episode_name']); ?><br>
                        <div style="margin-left: 20px;">
                            Description: <?php echo htmlspecialchars($episode['episode_description']); ?>
                        </div>
                        <div style="margin-left: 20px;">
                            Date: <?php echo htmlspecialchars($episode['episode_date']); ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No episodes available for this campaign.</p>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>No campaigns found.</p>
<?php endif; ?>
<?php include 'footer.php'; ?>


</body>
</html>
