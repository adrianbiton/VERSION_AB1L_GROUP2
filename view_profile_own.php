<?php
	
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
	
	$find = $_SESSION['uname'];
	
	//FETCHES THE USER INFO
	$query = "SELECT * FROM usertry where username = '".$_SESSION['uname']."'";
	
	$result1 = pg_query($pgsql_conn, $query);
	
	//USER NAME LANG TO	
	echo $_SESSION['uname'];
	echo "<br/>";
		
	while ($row1 = pg_fetch_array($result1)) {
		
		//displays the about of the user
		if($row1['dpic'] != '')
			echo "<img src = 'dp/".$row1['dpic']."'/><br/>";
		
		echo $row1['gender'];
		echo "<br/>";
		echo $row1['about'];
		echo "<br/>";
		
	}
	
	//FETCHES THE STAR COUNT OF THE USER
	
	//query para mag-count ng user-user relationships
	$query1 = "SELECT COUNT(DISTINCT from_star) as total1 FROM stars where to_star = '".$find."';";
	
	
	$result2 = pg_query($pgsql_conn, $query1);	

	$r = pg_fetch_array($result2);
	echo "Star count:";
	echo $r[0];
	echo "<br/>";
	
	
	//LINK TO COMMENTS PAGE
	echo "<a href = 'comment_profile.php?username=".$_SESSION['uname']."'>Comments</a><br/>";
	
	$query = "select * from blogs where owner = '".$_SESSION['uname']."' order by date_published;";
	$result = pg_query($pgsql_conn, $query);	
	while ($row = pg_fetch_array($result)) {
		
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
		
		//echo $row['blog_id']."<br/>";
		echo "<a href = 'edit_blog.php?name=".$row['blog_id']."'>Edit Blog</a>";
		echo "<br/>";
		echo "<a href = 'delete_blog.php?name=".$row['blog_id']."'>Delete Blog</a>";
		echo "<hr>";
		
	}//end-while
?>