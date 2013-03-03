<?php
	session_start();

	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=12345");
	//echo 'Connected to: ', pg_dbname($dbconn);
	
	if(isset($_POST["login"])) {
		$user = $_POST["uname"];
		$pword = md5($_POST["pword"]);
		$query = "select username from usertry where username='$_POST[uname]'";
		$res = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
		$row = pg_fetch_row($res);
		
		if($user == $row[0]) {
			$query = "select username, pword from usertry where username='$_POST[uname]' and pword='".$pword."'";
		$res = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
		$row = pg_fetch_row($res);
			if($pword == $row[1]) {
				$_SESSION["login"] = 1;
				$_SESSION["uname"] = $user;
				header("Location: home.php");
			}else {
				?>
					<script type="text/javascript">
						alert("Incorrect password!");
						return false;
					</script>
				<?php
			}
		}else {
			?>
				<script type="text/javascript">
					alert("Username does not exist!");
					return false;
				</script>
			<?php
		}
	}
?>

<html>
	<head>
		<title>Login</title>
		
		<script type="text/javascript">
			function checkit() {
				var letters = /^[a-zA-Z]+$/;
				var u = document.forms["loginform"]["uname"].value;
				var p = document.forms["loginform"]["pword"].value;
				
				if(u.length == 0) {
					alert("Username is required!");
					return false;
					
				}else if(p.length == 0) {
					alert("Password is required!");
					return false;
				}
				return true;
			}
		</script>
	</head>

	<body>
		<form name="loginform" action="login.php" method="POST" onSubmit="return checkit()">
			<input type="text" name="uname" placeholder="Username" id="uname"/><br/>
			<input type="password" name="pword" id="pword" placeholder="Password"/><br/>
			<input type="submit" name="login" value="Log in"/><br/>
			<a href="register.php">Register</a>
		</form>
	</body>
</html>
