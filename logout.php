<?php
	session_start();
	session_destroy();
	
	header("Location: login.php");
	exit;
	
?>

<html>
	<head>
	</head>
	
	<body>
	</body>
</html>