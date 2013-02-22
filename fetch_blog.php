<?php
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
	
	//real query
	//$query = "select * from blogs where owner = '".$_SESSION['id']."' order by date_published limit 10;";
	
	//sample query
	$query = "select * from blogs where owner = 'adrianbiton' order by date_published limit 10;";
	
	$result = pg_query($pgsql_conn, $query);
	
	//catching the returned rows :D -- TEST
	//while ($row = pg_fetch_array($result)) {
	//	echo $row['blog_id']."<br/>".$row['date_published']."<br/>".$row['image']."<br/>".$row['title']."<br/>".$row['caption']."<br/>";
	//}
	
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
		echo "<hr>";
		
	}//end-while
	
?>