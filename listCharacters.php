<?php
include 'handlers/handle_list_characters.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Character List</title>
</head>

<body>
	<div class="container">
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
	</div>

</body><?php include 'footer.php'; ?>

</html>

<?php
$conn->close();
?>