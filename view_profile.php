<?php

	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
		$find = $_GET['username'];
	
	if( isset($_GET['star']) ){
		$query1 = "insert into stars values('".$_SESSION['uname']."', '".$find."');";
		$result = pg_query($pgsql_conn, $query1);
		
	}
	
	//FETCHES THE USER INFO
	$query = "SELECT * FROM usertry where username = '".$find."'";
	
	$result1 = pg_query($pgsql_conn, $query);
	
	//USER NAME LANG TO	
	echo $find;
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
	$query = "SELECT COUNT(DISTINCT from_star) as total1 FROM stars where to_star = '".$find."';";
	
	
	$result2 = pg_query($pgsql_conn, $query);	

	$r = pg_fetch_array($result2);
	echo "Star count:";
	echo $r[0];
	echo "<br/>";
	
	//SHOULD INDICATE IF THE SIGNED USER ALREADY STARRED THE OTHER USER
	
	$query = "SELECT COUNT(from_star) as total2 FROM stars where to_star = '".$find."' and from_star = '".$_SESSION['uname']."';";
	$result3 = pg_query($pgsql_conn, $query);
	$row = pg_fetch_array($result3);
	//1 -> the signed in user already starred the other user
	
	if( $row[0] == 1 ){
		echo "Starred";
	}
	else{
		echo "Not yet starred.<br/>";
		echo "<a href='view_profile.php?username=".$find."&star=1'>Star ME!</a>";
	}
	
	//LINK TO COMMENTS PAGE
	echo "<br/><a href = 'comment_profile.php?username=".$find."'>Comment</a>";
	
	
	//FETCH THE BLOG POSTS OF THE USER
	echo "<br/><br/>Blog posts<br/><br/>";	
	$query = "select * from blogs where owner = '".$find."' order by date_published;";
	
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
		echo "Blog Text:<br/>".$theData."<br/>";
		
		//displays the timestamp
		//echo $row['date_published'];
		echo date('h:i:s A F j, Y',strtotime($row['date_published']));
		echo "<br/>";
		
		echo "<hr>";
		
	}//end-while
	
	//PANO GAGAWIN YUNG NEXT PAGES NA MAY LAMAN NA BLOGS NG SAME USERRRRR
?>