<?php
	session_start();
	
	if($_SESSION["login"]!=1){
		header("Location: logout.php");
		exit;
	}
	
	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=12345");
	$user = $_SESSION["uname"];
	$query = "select * from blogs
			join stars on blogs.owner = stars.to_star
			where stars.from_star='".$_SESSION['uname']."'
			or blogs.owner = '".$_SESSION['uname']."' order by date_published;";
	$res = pg_query($dbconn, $query);
	
	while ($row = pg_fetch_array($res)) {
		echo "<hr/>";
		echo $row['owner'];
		echo "<br/>";
		
		//viewing the blog entries :)
		$myFile = "entries/".$row['blog_id'].".txt";
		$fh = fopen($myFile, 'r');
		$theData = fread($fh, filesize($myFile));
		fclose($fh);
		
		//displays the title
		echo $row['title']."<br/>";
		
		//displays the image -- WILL TRY TO USE JQuery TO SHOW THE FULL POST WHEN CLICKED
		echo "<a href = 'view_blog.php?name=".$row['blog_id']."'><img class = 'img' src = 'images/".$row['image']."'></a><br/>";
		
		//CAPTION here -- smaller font
		echo "<small>".$row['caption']."</small><br/>";
		
		//diplays the main blog entry
		echo "Blog Entry:<br/>".$theData."<br/>";
		
		//displays the timestamp
		//echo $row['date_published'];
		echo date('h:i:s A F j, Y',strtotime($row['date_published']));
		echo "<br/>";
		
		if($row['owner'] == $_SESSION['uname']){
		
			echo "<a href = 'edit_blog.php?name=".$row['blog_id']."'>Edit Blog</a>";
			echo "<br/>";
			echo "<a href = 'delete_blog.php?name=".$row['blog_id']."'>Delete Blog</a>";
		
		}
		
		echo "<hr/>";
	}
?>

<html>
	<head>
		<title>Home</title>
	</head>
	
	<body>
		<a href="logout.php">Log out</a>
	</body>
</html>
