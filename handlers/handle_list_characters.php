<?php
include 'db_connection.php';
include 'auth.php';


if (isset($_POST['delete'])) {
    $character_id = $_POST['character_id'];

    $conn->query("DELETE FROM Relationships WHERE character_id = $character_id OR relative_id = $character_id") or die(" Relationships " . $conn->error);
    $conn->query("DELETE FROM MagicTrainings WHERE character_id = $character_id") or die(" MagicTrainings" . $conn->error);
    $conn->query("DELETE FROM Characters WHERE character_id = $character_id") or die(" Characters " . $conn->error);

    echo "Character deleted successfully!";
}

$charactersQuery = "
    SELECT Characters.character_id, Characters.name, Characters.age, Countries.name AS country_name,
           GROUP_CONCAT(MagicTypes.name SEPARATOR ', ') AS magic_types
    FROM Characters
    LEFT JOIN Countries ON Characters.country_id = Countries.country_id
    LEFT JOIN MagicTrainings ON Characters.character_id = MagicTrainings.character_id
    LEFT JOIN MagicTypes ON MagicTrainings.magictype_id = MagicTypes.magictype_id
    GROUP BY Characters.character_id, Characters.name, Characters.age, Countries.name
";
$charactersResult = $conn->query($charactersQuery);
?>