<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Process Form</title>
</head>

<body>
	<?php
	$message = $_GET['message'];
	$email = $_GET['eaddress'];

	echo $message;
	mail($email, "Thank you for your order." , $message);
	?>
</body>

</html>