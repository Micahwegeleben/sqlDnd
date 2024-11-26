<?php
include 'handlers/handle_list_episodes.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Episodes by Campaign</title>
</head>

<body>
    <div class="container">

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
    </div>
    <?php include 'footer.php'; ?>


</body>

</html>