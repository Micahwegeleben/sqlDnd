<?php
include 'db_connection.php';
include 'auth.php';

$countryQuery = "SELECT country_id, name FROM Countries";
$countryResult = $conn->query($countryQuery);

$magicQuery = "SELECT magictype_id, name FROM MagicTypes";
$magicResult = $conn->query($magicQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $country_id = $_POST['country_id'];
    $magicTypes = isset($_POST['magicTypes']) ? $_POST['magicTypes'] : [];

    $stmt = $conn->prepare("INSERT INTO Characters (name, age, country_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $name, $age, $country_id);

    if ($stmt->execute()) {
        $character_id = $stmt->insert_id;
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