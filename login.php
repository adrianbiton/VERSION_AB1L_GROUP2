<?php
session_start();

$dbconn= pg_connect("dbname=postgres host=localhost user=postgres password=12345");

if(isset($_POST["login"])){

$user = $_POST["uname"];
$pw = md5($_POST["pword"]);

if(!empty($pword)){
$query = "select uname, pw from usertry where uname=".$user." and pw like '".$pw."'";
$result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
$row = pg_fetch_row($result);

if($user==$row[0] and $pw==$row[1]){
$_SESSION["login"] = 1;
$_SESSION["id"] = $user;
header("Location: home.php");
}
else{
?>
<script type="text/javascript">
function checkit() {
alert("Invalid username or password");
}
}
</script>
<?php
}
}
}

?>

<html>
<head>
<title>Login</title>
<script type="text/javascript">
function checkit() {
var letters=/^[a-zA-Z]+$/;
var u=document.forms["loginform"]["uname"].value;
var p=document.forms["loginform"]["pword"].value;
if(u.length==0){
alert("Username is required");
}else if(p.length==0) {
alert("Password is required");
}
}
</script>
</head>

<body>
<form name="loginform" action="login.php" method="POST" onSubmit="return checkit()">
<input type="text" name="uname" placeholder="Username" id="uname" value="<?php if(!empty($user)) echo $user; ?>" required/><br/>
<input type="password" name="pword" id="pword" placeholder="Password" required/><br/>
<input type="submit" name="login" value="Log in"/><br/>
<a href="register.php">Register</a>
</form>
</body>
</html>
