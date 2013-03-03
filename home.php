<?php
	session_start();
	
	if($_SESSION["login"]!=1){
		header("Location: logout.php");
		exit;
	}
	
	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=12345");
	$user = $_SESSION["uname"];
	$query = "select * from usertry where username='".$user."'";
	$res = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
	$row = pg_fetch_row($res);
	
	echo "Username: ".$row[0]."<br/>";
	echo "First name: ".$row[2]."<br/>";
	echo "Middle name: ".$row[3]."<br/>";
	echo "Last name: ".$row[4]."<br/>";
	echo "Birthday: ".$row[5]."<br/>";
	echo "Email: ".$row[6]."<br/>";
	echo "Gender: ".$row[7]."<br/>";
	
?>

<html>
	<head>
		<title>Home</title>
	</head>
	
	<body>
		<a href="logout.php">Log out</a>
	</body>
</html>
