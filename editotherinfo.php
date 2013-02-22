<?php
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");

    if ($pgsql_conn) {
	
		if(isset($_POST["edit"])){		
			$fname = $_POST["fname"];
			$mname = $_POST["mname"];
			$lname = $_POST["lname"];
			$bday = $_POST["bday"];
			$email = $_POST["email"];
			$gen = $_POST["gen"];
			$uname = adrianbiton;
			
			$query = "UPDATE usertry SET fname = '$fname', mname='$mname', lname='$lname', bday='$bday', email='$email', gender='$gen' WHERE username='$uname'";
			pg_query($pgsql_conn, $query) or die('Query failed: ' . pg_last_error());		
		}
	
	
    } else {
        print pg_last_error($pgsql_conn);
        exit;
    }
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
		<input type="text" name="fname" placeholder="Firstname" id="fname"/><br/>
		<input type="text" name="mname" placeholder="Middlename" id="mname"/><br/>
		<input type="text" name="lname" placeholder="Lastname" id="lname"/><br/>
		<input type="date" name="bday" placeholder="Birthday" id="bday"/><br/>
		<input type="text" name="email" placeholder="Email" id="email"/><br/>
		<input type="text" name="gen" placeholder="Gender" id="gen"/><br/>

		<input type="submit" name="edit" value="Submit"/><br/>
		</form>
	</body>
</html>