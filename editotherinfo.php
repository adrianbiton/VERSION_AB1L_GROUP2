<?php
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");

		$uname = $_SESSION["uname"];
		
		function findexts ($filename) 
		 { 
		 $filename = strtolower($filename) ; 
		 $exts = split("[/\\.]", $filename) ; 
		 $n = count($exts)-1; 
		 $exts = $exts[$n]; 
		 return $exts; 
		 }
		
		if(isset($_POST["edit"])){		
			$fname = $_POST["fname"];
			$mname = $_POST["mname"];
			$lname = $_POST["lname"];
			$bday = $_POST["bday"];
			$email = $_POST["email"];
			$gen = $_POST["gen"];
			$abt = $_POST['about'];
			$newpass = null;
			if(isset($_POST['old']))
			{
				$query = "select pword from usertry where username='$uname'";
				$res = pg_query($pgsql_conn, $query);
				$row = pg_fetch_row($res);
				if(md5($_POST['old']) == $row[0]){
					if( $_POST['new1'] == $_POST['new2'] )
						$newpass = md5($_POST['new1']);
				}else{
					$msg = "Old password is incorrect";
				}
			}
			
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
				
				$query = "UPDATE usertry SET fname = '$fname', mname='$mname', lname='$lname', bday='$bday', email='$email', gender='$gen',dpic='".$ran2.$ext."', about='$abt' WHERE username='$uname'";
			}else{			
				$query = "UPDATE usertry SET fname = '$fname', mname='$mname', lname='$lname', bday='$bday', email='$email', gender='$gen', about='$abt' WHERE username='$uname'";
			}
			
			if(pg_query($pgsql_conn, $query))
				echo "Edit Successful";
			//pg_query($pgsql_conn, $query) or die('Query failed: ' . pg_last_error());		
		}
		
		$query2 = "select * from usertry where username = '".$uname."';";
		
		$result = pg_query($pgsql_conn, $query2);
		
	//fetching the column values :)
	while ($row = pg_fetch_array($result)) {
    
?>

<html>
	<head>
		<title>Edit Other Information</title>
			<script type="text/javascript">
			function check() {
				var letters=/^[a-zA-Z]+$/;
				var f=document.forms["editotherinfo"]["fname"].value;
				var m=document.forms["editotherinfo"]["mname"].value;
				var l=document.forms["editotherinfo"]["lname"].value;
				var g=document.forms["editotherinfo"]["gen"].value;
				var b=document.forms["editotherinfo"]["bday"].value;
				var e=document.forms["editotherinfo"]["email"].value;
				var atpos=e.indexOf("@");
				var dotpos=e.lastIndexOf(".");
				
				if(f.length==0) {
					alert("All fields are required");
					return false;
				}else if(!f.match(letters)) {
					alert("Firstname must contain letters only");
					return false;
				}
				
				if(m.length==0) {
					alert("All fields are required");
					return false;
				}else if(!m.match(letters)) {
					alert("Middlename must contain letters only");
					return false;
				}
				
				if(l.length==0) {
					alert("All fields are required");
					return false;
				}else if(!l.match(letters)) {
					alert("Lastname must contain letters only");
					return false;
				}
				
				if(g.length==0) {
					alert("All fields are required");
					return false;
				}else if(!g.match(letters)) {
					alert("Gender must contain letters only");
					return false;
				}
				
				if(b.length==0) {
					alert("All fields are required");
					return false;
				}
				
				if(e.length==0) {
					alert("All fiels are required");
					return false;
				} else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=e.length) {
					alert("Invalid email address");
					return false;
				}
				return true;
			}
		</script>

	</head>
	<body>
		Edit Other Information		<br />
		<form name="editotherinfo" method="POST" onSubmit="return check()" enctype="multipart/form-data">
		<input type="text" name="fname" placeholder="Firstname" id="fname" value = "<? echo $row['fname'];?>"/><br/>
		<input type="text" name="mname" placeholder="Middlename" id="mname" value = "<? echo $row['mname'];?>"/><br/>
		<input type="text" name="lname" placeholder="Lastname" id="lname" value = "<? echo $row['lname'];?>"/><br/>
		<input type="date" name="bday" placeholder="Birthday" id="bday" value = "<? echo $row['bday'];?>"/><br/>
		<input type="text" name="email" placeholder="Email" id="email" value = "<? echo $row['email'];?>"/><br/>
		<select name="gen" id="gen"/>
				<? 
				if ($row['gender'] == 'Male'){
					echo "<option selected>Male</option>";
					echo "<option>Female</option>";
					}else if ($row['gender'] == 'Female'){
						echo "<option>Male</option>";
						echo "<option selected>Female</option>";
					}
					else{
						echo "<option></option><option>Male</option><option>Female</option>";
					}
				?>
		</select><br/>
		<input type="file" name="file" id="file" placeholder="Upload Image" /><br/>
		<textarea name = "about" placeholder = "About You"><?echo $row['about'];?></textarea><br/>
		
		<!--PASSWORD CHANGE dapat javascript toh on click lang ng checkbox saka maactive ung fields-->
		<input type="password" name="old" placeholder="Old password"/><?echo $msg;?><br/>
		<input type="password" name="new1" placeholder="New password"/><br/>
		<input type="password" name="new2" placeholder="Re-type new password"/><br/>
		
		
		<input type="submit" name="edit" value="Submit"/><br/>		
		</form>
	</body>
</html>
<?php
	}
?>