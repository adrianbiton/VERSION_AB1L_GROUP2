<?php
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
	$lists = $_POST["name"];

	echo $_POST["name"];
	
	$query = "delete from blogs where blog_id=".$_GET["name"].";";
	$result = pg_query($pgsql_conn, $query);
	
	header("Location: fetch_blog.php");
?>