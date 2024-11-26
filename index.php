<?php
include 'handlers/handle_add_character.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Character</title>
</head>

<body>
    <div class="container">
        <h1>Add a New Character</h1>
        <form method="POST" action="index.php">
            <label for="name">Character Name:</label>
            <input type="text" name="name" id="name" required><br><br>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" required><br><br>

            <label for="country">Country:</label>
            <select name="country_id" id="country" required>
                <option value="">--Select Country--</option>
                <?php
                if ($countryResult->num_rows > 0) {
                    while ($row = $countryResult->fetch_assoc()) {
                        echo "<option value='{$row['country_id']}'>{$row['name']}</option>";
                    }
                }
                ?>
            </select><br><br>

            <label for="magicTypes">Magic Types:</label><br>
            <?php
            if ($magicResult->num_rows > 0) {
                while ($row = $magicResult->fetch_assoc()) {
                    echo "<input type='checkbox' name='magicTypes[]' value='{$row['magictype_id']}'> {$row['name']}<br>";
                }
            }
            ?><br>

            <input type="submit" value="Add Character">
        </form>
        <br>
        <?php include 'footer.php'; ?>
    </div>
</body>

</html>