<?php
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");

    if ($pgsql_conn) {
	
		if(isset($_POST["edit"])){
			$npword = $_POST["npword"];
			$uname = adrianbiton;
			
			$query = "UPDATE usertry SET pword = '$npword' WHERE username='$uname'";
			pg_query($pgsql_conn, $query) or die('Query failed: ' . pg_last_error());		
		}
	
	
    } else {
        print pg_last_error($pgsql_conn);
        exit;
    }
?>

<html>
	<head>
		<title>Change Password</title>
		
		<script type="text/javascript">
			function check(){
				var curpword=document.forms["editpassword"]["cpword"].value;
				var newpword=document.forms["editpassword"]["npword"].value;
				var newpword2=document.forms["editpassword"]["npword2"].value;
				//var realpword= <?php pg_query($pgsql_conn, "SELECT pword FROM usertry WHERE username='adrianbiton'"); ?>;
				
				if(curpword.length == 0 || newpword.length ==0 || newpword2.length ==0){
					alert("All fields are required");
					return false;
				}
				
				/*if(curpword!=realpword){
					alert("Incorrect current password");
					return false;
				}*/
				
				if(curpword==newpword || curpword==newpword2){
					alert("The current and new password are the same.");
					return false;
				}
				
				if(newpword != newpword2){
					alert("Password re-typing did not match.");
					return false;
				}
				
				return true;
			}			
		</script>
	</head>
	<body>
		<form name="editpassword" method="POST" onSubmit="return check()" enctype="multipart/form-data">
		Change Password
		<br />
		<br />
		Current Password: <input type="password" name="cpword" placeholder="Password" id="cpword"/><br/>
		New Password:	<input type="password" name="npword" placeholder="Password" id="npword"/><br/>
		Re-type Password:	<input type="password" name="npword2" placeholder="Password" id="npword2"/><br/>
		<input type="submit" name="edit" value="Submit"/><br/>
		<a href="login.php">Back</a>
		</form>
	</body>
</html>