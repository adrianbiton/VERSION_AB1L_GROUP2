<?php
	
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
	
	$user = $_GET['username'];
	
	if( $_SESSION['uname'] != $user ){
		//SHOW COMMENTS TEXT AREA IF THE PERSON LOGGED IN IS NOT THE OWNER
		echo "<form name='comm' action = 'comment_profile.php?username=".$user."' method = 'post'>";
		echo "<textarea name='comments' placeholder='comments here'></textarea>";
		echo "<br/><input type='submit' name='cc' value='Post Comment'/></form>";
	}
	
	if(isset($_POST['cc']))
	{
		$query = "insert into comments values('".$user."', '".$_SESSION['uname']."', '".$_POST['comments']."', now())";
		
		$result = pg_query($pgsql_conn, $query);
	}
	
	//SHOW ALL THE COMMENTS TO THE USER
	$query1 = "select * from comments where for_who = '".$user."';";
	
	$result = pg_query($pgsql_conn, $query1);
	
	while($row = pg_fetch_array($result)){
		echo $row['from_who']." says ".$row['comment'];
		echo "<br/>";
		echo date('h:i:s A F j, Y',strtotime($row['time']));
		echo "<br/><hr/>";
	}
	
?>