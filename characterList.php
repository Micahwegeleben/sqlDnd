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

// Handle deletion of a character
if (isset($_POST['delete'])) {
	$character_id = $_POST['character_id'];

	// Delete from MagicTrainings table first (because of foreign key constraint)
	$conn->query("DELETE FROM MagicTrainings WHERE character_id = $character_id");

	// Then delete from Characters table
	$conn->query("DELETE FROM Characters WHERE character_id = $character_id");

	echo "Character deleted successfully!";
}

// Fetch all characters with their countries and magic types
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

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Character List</title>
</head>

<body>

	<h2>Character List</h2>
	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Country</th>
				<th>Magic Types</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($charactersResult->num_rows > 0) {
				while ($row = $charactersResult->fetch_assoc()) {
					echo "<tr>
                    <td>{$row['character_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['age']}</td>
                    <td>{$row['country_name']}</td>
                    <td>{$row['magic_types']}</td>
                    <td>
                        <form method='POST' action='' style='display:inline;'>
                            <input type='hidden' name='character_id' value='{$row['character_id']}'>
                            <input type='submit' name='delete' value='Delete' onclick='return confirm(\"Are you sure you want to delete this character?\");'>
                        </form>
                    </td>
                </tr>";
				}
			} else {
				echo "<tr><td colspan='6'>No characters found</td></tr>";
			}
			?>
		</tbody>
	</table>

	<a href="index.php">Add a New Character</a>

</body>

</html>

<?php
$conn->close();
?>