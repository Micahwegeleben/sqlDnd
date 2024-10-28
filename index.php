<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sqlDnd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch countries for the dropdown
$countryQuery = "SELECT country_id, name FROM Countries";
$countryResult = $conn->query($countryQuery);

// Fetch magic types for checkboxes
$magicQuery = "SELECT magictype_id, name FROM MagicTypes";
$magicResult = $conn->query($magicQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $country_id = $_POST['country_id'];
    $magicTypes = isset($_POST['magicTypes']) ? $_POST['magicTypes'] : [];

    // Insert character into Characters table
    $stmt = $conn->prepare("INSERT INTO Characters (name, age, country_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $name, $age, $country_id);

    if ($stmt->execute()) {
        $character_id = $stmt->insert_id;

        // Insert selected magic types into MagicTrainings
        if (!empty($magicTypes)) {
            $stmtMagic = $conn->prepare("INSERT INTO MagicTrainings (character_id, magictype_id) VALUES (?, ?)");
            foreach ($magicTypes as $magictype_id) {
                $stmtMagic->bind_param("ii", $character_id, $magictype_id);
                $stmtMagic->execute();
            }
            $stmtMagic->close();
        }

        echo "Character successfully added!";
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
    <title>Add a Character</title>
</head>
<body>

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
            while($row = $countryResult->fetch_assoc()) {
                echo "<option value='{$row['country_id']}'>{$row['name']}</option>";
            }
        }
        ?>
    </select><br><br>

    <label for="magicTypes">Magic Types:</label><br>
    <?php
    if ($magicResult->num_rows > 0) {
        while($row = $magicResult->fetch_assoc()) {
            echo "<input type='checkbox' name='magicTypes[]' value='{$row['magictype_id']}'> {$row['name']}<br>";
        }
    }
    ?><br>

    <input type="submit" value="Add Character">
</form>
<br>
<a href="characterList.php">View Character List</a>

</body>
</html>