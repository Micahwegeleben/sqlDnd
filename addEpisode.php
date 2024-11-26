<?php
include 'handlers/handle_add_episode.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Episode</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="container">

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
            <textarea name="episode_description" id="episode_description" rows="4" cols="50"
                required></textarea><br><br>

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

        <?php if ($successMessage): ?>
            <p class="success-message"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php elseif ($errorMessage): ?>
            <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
    </div>
    <br><?php include 'footer.php'; ?>

</body>

</html>