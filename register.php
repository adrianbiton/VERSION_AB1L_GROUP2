
<!DOCTYPE HTML>
<html>
	<head>
	<title>Register</title>
		<script type="text/javascript">
			function check() {
				var letters = /^[a-zA-Z]+$/;
				var u = document.forms["signupform"]["uname"].value;
				var p = document.forms["signupform"]["pword"].value;
				var vp = document.forms["signupform"]["vpword"].value;
				var f = document.forms["signupform"]["fname"].value;
				var m = document.forms["signupform"]["mname"].value;
				var l = document.forms["signupform"]["lname"].value;
				var g = document.forms["signupform"]["gen"].value;
				var b = document.forms["signupform"]["bday"].value;
				var e = document.forms["signupform"]["email"].value;
				var atpos = e.indexOf("@");
				var dotpos = e.lastIndexOf(".");
				
				if(u.length==0 || p.length==0 || vp.length==0 || f.length==0 || m.length==0 || l.length==0 || g.length==0 || b.length == 0 ||  e.length == 0) {
					alert("All fields are required!");
					return false;
				}
				
				if(p != vp) {
					alert("Passwords did not match!");
					return false;
				}
				
				if(!f.match(letters)) {
					alert("Firstname must contain letters only!");
					return false;
				}
				
				if(!m.match(letters)) {
					alert("Middlename must contain letters only!");
					return false;
				}
				
				if(!l.match(letters)) {
					alert("Lastname must contain letters only!");
					return false;
				}
				
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=e.length) {
					alert("Invalid email address");
					return false;
				}
				return true;
			}
		</script>
	</head>

	<body>
		<form name="signupform" action="register.php" method="POST" onSubmit="return check()" enctype="multipart/form-data">
			<input type="text" name="uname" placeholder="Username" id="uname" value="<?php if(!empty($uname)) echo $uname; ?>"/><br/>
			<input type="password" name="password" placeholder="Password" id="pword"/><br/>
			<input type="password" name="vpassword" placeholder="Verify Password" id="vpword"/><br/>
			<input type="text" name="fname" placeholder="Firstname" id="fname" value="<?php if(!empty($fname)) echo $fname;?>"/><br/>
			<input type="text" name="mname" placeholder="Middlename" id="mname" value="<?php if(!empty($mname)) echo $mname;?>"/><br/>
			<input type="text" name="lname" placeholder="Lastname" id="lname" value="<?php if(!empty($lname)) echo $lname;?>"/><br/>
			<input type="date" name="bday" placeholder="Birthday" id="bday" value="<?php if(!empty($bday)) echo $bday;?>"/><br/>
			<input type="text" name="email" placeholder="Email" id="email" value="<?php if(!empty($email)) echo $email;?>"/><br/>
			<select name="gen" id="gen"/>
				<option></option>
				<option>Male</option>
				<option>Female</option>
			</select><br/>
			<input type="file" name="file" id="file" placeholder="Upload Image" /><br/>
			<textarea name = "about" placeholder = "About You"></textarea>
			<input type="submit" name="register" value="Submit"/><br/>
			<a href="login.php">Back</a>
		</form>
	</body>
</html>

<?php
	//session_start();

	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=12345");
	//echo 'Connected to: ', pg_dbname($dbconn);

	
	function findexts ($filename) 
		 { 
		 $filename = strtolower($filename) ; 
		 $exts = split("[/\\.]", $filename) ; 
		 $n = count($exts)-1; 
		 $exts = $exts[$n]; 
		 return $exts; 
		 }
	
	if(isset($_POST["register"])) {
		$uname = $_POST["uname"];
		$pw = md5($_POST["password"]);
		$vpw = md5($_POST["vpassword"]);
		$fname = $_POST["fname"];
		$mname = $_POST["mname"];
		$lname = $_POST["lname"];
		$bday = $_POST["bday"];
		$email = $_POST["email"];
		$gen = $_POST["gen"];

		//UPLOADS IMAGE FILES
			if($_FILES['file']['name'] != null){
				//This applies the function to our file  
				$ext = findexts ($_FILES['file']['name']) ;
				//This line assigns a random number to a variable.
				$ran = rand () ;
				$ran2 = $ran.".";
				//This assigns the subdirectory you want to save into... make sure it exists!
				$target = "dp/";
				//This combines the directory, the random file name, and the extension
				$target = $target . $ran2.$ext;
				//uploads the image file
				move_uploaded_file($_FILES['file']['tmp_name'], $target);
			}
			//END-UPLOAD

		$query = "select username from usertry where username='$_POST[uname]'";
		$res = pg_query($dbconn, $query) or die('Query failed: '.pg_last_error());
		
		if(pg_num_rows($res) == 0) {
			$query = "insert into usertry values('$_POST[uname]', '".$pw."', '$_POST[fname]', '$_POST[mname]', '$_POST[lname]', '$_POST[bday]', '$_POST[email]', '$_POST[gen]', '".$ran2.$ext."', '$_POST[about]');";
			
			pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());

		?>	
			<script type="text/javascript">
				alert("You have successfully registered!");
				return false;
			</script>
		<?php
			$uname = "";
			$fname = "";
			$mname = "";
			$lname = "";
			$bday = "";
			$email = "";
			$gen = "";
		
			//header("Location: login.php");
		}else{
		?>
			<script type="text/javascript">
				alert("Username already exist!");
			</script>
		<?php
		}
	}
?>
