<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>DB Example</title>
	<style type='text/css'>
		html,
		body,
		select {
			font-size: 25px;
		}
	</style>
	<script language="javascript">
		items = []; // set up array
	</script>
</head>

<body>
	<h1>This is my Web Page</h1>
	<em>It happens to be a PHP page</em>
	<br /><br />

	<?php
	//establish connection info
	$server = "sql211.epizy.com";
	$userid = "epiz_27941844";
	$pw = "qAA3UUc6P5";
	$db = "epiz_27941844_jade_delight";

	// Create connection
	$conn = new mysqli($server, $userid, $pw);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully";

	//select the database
	$conn->select_db($db);

	//run a query
	$sql = "SELECT * FROM product";
	echo "<br />The query is: " . $sql . "<br />";
	// $result = $conn->query($sql);





	// if ($result->num_rows > 0) {
	// 	echo "<select name='ptype'>";   // set up drop down list 
	// 	while ($row = $result->fetch_array()) {
	// 		$type = $row[0];
	// 		echo "$type<br>";	// display items retrieved
	// 		// add the items to the array
	// 		echo "<script language='javascript'>petTypes.push('$type')</script>";
	// 		// create a select option
	// 		echo "<option>$type</option>";
	// 	}
	// 	echo "</select><br />";
	// } else {
	// 	echo "no results";
	// }

	// //close the connection	
	// $conn->close();

	?>

	<!-- <form name='form1' method='post' action='something.php'>
		<input type='hidden' name='secret_key' />
	</form> -->

	<script language="javascript">
		// document.write(items);
		// document.form1.secret_key.value = "suel39so";
	</script>
</body>

</html>