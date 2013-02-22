<?php
session_start();

if($_SESSION["login"]!=1) {
// header("Location:index.php");
exit;
}
$dbconn= pg_connect("dbname=postgres host=localhost user=postgres password=12345");

?>

<html>
<head>
<title>Home</title>
</head>
<body>
<a href="logout.php">Log out</a>
</body>
</html>
