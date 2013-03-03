<?php
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
	
	if(isset($_POST["delete"])){
		$lists = $_POST["list"];

		echo $_POST["list"];
		
		$query = "delete from blogs where blog_id=".$_POST["list"]."";
		$result = pg_query($pgsql_conn, $query);
	}

?>

<html>
<head><title>Delete Post</title>
</head>
<body>

	<form name='postList' method='post' enctype = 'multipart/form-data'>
	<?php
		$uname=adrianbiton;
		echo "<br/>"."Blog posts"."<br/><br/>";	
		$query = "select * from blogs where owner = '$uname' order by date_published limit 10;";

		$result = pg_query($pgsql_conn, $query);
		

		while ($row = pg_fetch_array($result)) {

				//viewing the blog entries :)
				$myFile = "entries/".$row['blog_id'].".txt";
				$fh = fopen($myFile, 'r');
				$theData = fread($fh, filesize($myFile));
				fclose($fh);
		
				//displays the title
				
				echo "<input type='radio' name='list' value='".$row['blog_id']."'/>";	
				//echo "<input type='submit' name='delete[]' value='Submit'/>";
				echo $row['title'].$row['blog_id']."<br/>";
				
		//		
		}
	?>
	<input type='submit' name='delete' value='Delete'/>
	</form>
</body>
</html>

<?php

?>