<?php
	//SHOWS THE SEARCH RESULT :)
	//only display pics, usernames and gender are showed
	
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
	
	$item = $_POST['searchme'];
	
	echo "Search results for: ".$item;
	
	$query = "SELECT * from usertry where username LIKE '".$item."' OR username LIKE '%".$item."' OR username LIKE '".$item."%' OR username LIKE '%".$item."%'";
	
	$result = pg_query($pgsql_conn, $query);
	
	while ($row = pg_fetch_array($result)) {
		
		if($row['username'] != $_SESSION['uname']){
			//TEMPORARY
			echo "<hr>";
			
			//should show DP here
			if($row['dpic'] != '')
				echo "<a href = 'view_profile.php?username=".$row['username']."'><img class = 'img' src = 'dp/".$row['dpic']."'></a><br/>";
			else{
				echo "<a href = 'view_profile.php?username=".$row['username']."'><img class = 'img' src = 'dp/default.jpg'></a><br/>";
			}
			
			echo "<a href = 'view_profile.php?username=".$row['username']."'>".$row['username']."</a>";
			
			echo "<br>";
			
			echo $row['gender'];
		}
	}
	
?>