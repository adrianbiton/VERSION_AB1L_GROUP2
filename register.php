<?php
session_start();

$dbconn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");

if(isset($_POST["start"])){
$uname = $_POST["uname"];
$pw = md5($_POST["password"]);
$vpw = md5($_POST["vpassword"]);
$fname = $_POST["fname"];
$mname = $_POST["mname"];
$lname = $_POST["lname"];
$bday = $_POST["birthday"];
$email = $_POST["email"];
$gen = $_POST["gender"];

$uploaddir = '/home/postgres/';
$uploadfile = $uploaddir . basename($_FILES['file']);

if (move_uploaded_file($_FILES['userfile'], $uploadfile)) { // echo "File is valid, and was successfully uploaded.\n";

} else {
echo "File size greater than 5mb!\n\n";
}

$query = "insert into image values ('$name', lo_import('$uploadfile'), 'now')";
$result = pg_query($query);

if($result){
echo "Image was successfully uploaded.\n";
unlink($uploadfile);
}

if(empty($uname) || empty($pw) || empty($vpw) || empty($fname) || empty($mname) || empty($lname) || empty($bday) || empty($email) || empty($gen)){
?>
<script type="text/javascript">
function check () {
alert("All fields are required");
}
</script>
<?php
}
//else{

//if($pw!=$vpw){
// $error2 = "* Passwords do not match";
//}

else{

$query = "select uname from usertry where uname=".$uname;
$res = pg_query($dbconn, $query) or die('Query failed: '.pg_last_error());

if(pg_num_rows($res)==0){
$query = "insert into usertry values(".$uname.", '".$pw."', '".$fname."', '".$mname."', '".$lname."', '".$bday."', '".$email."', '".$gen."')";
pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());

$msg = "Sign up successful!";
$uname="";
$fname="";
$mname="";
$lname="";
$bday="";
$email="";
$gen="";

}
else{
?>
<script type="text/javascript">
function check() {
var letters=/^[a-zA-Z]+$/;
var u=document.forms["signupform"]["uname"].value;
if(u.length==0)
alert("Username already exist");
}
</script>
<?php
}
}
}
/*}*/

?>

<html>
<head>
<title>Login</title>
<script type="text/javascript">
function check() {
var letters=/^[a-zA-Z]+$/;
var u=document.forms["signupform"]["uname"].value;
var p=document.forms["signupform"]["pword"].value;
var vp=document.forms["signupform"]["vpword"].value;
var f=document.forms["signupform"]["fname"].value;
var m=document.forms["signupform"]["mname"].value;
var l=document.forms["signupform"]["lname"].value;
var g=document.forms["signupform"]["gen"].value;
var b=document.forms["signupform"]["bday"].value;
var e=document.forms["signupform"]["email"].value;
var atpos=e.indexOf("@");
var dotpos=e.lastIndexOf(".");
if(u.length==0) {
alert("Username is required");
return false;
}
if(p.length==0) {
alert("All fields are required");
return false;
}
if(vp.length==0) {
alert("All fields are required");
return false;
}
if(p!=vp) {
alert("Passwords did not match");
return false;
}
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
<form name="signupform" action="login.php" method="POST" onSubmit="return check()" enctype="multipart/form-data">
<input type="text" name="uname" placeholder="Username" id="uname" value="<?php if(!empty($uname)) echo $uname; ?>"/><br/>
<input type="password" name="password" placeholder="Password" id="pword"/><br/>
<input type="password" name="vpassword" placeholder="Verify Password" id="vpword"/><br/>
<input type="text" name="fname" placeholder="Firstname" id="fname" value="<?php if(!empty($fname)) echo $fname;?>"/><br/>
<input type="text" name="mname" placeholder="Middlename" id="mname" value="<?php if(!empty($mname)) echo $mname;?>"/><br/>
<input type="text" name="lname" placeholder="Lastname" id="lname" value="<?php if(!empty($lname)) echo $lname;?>"/><br/>
<input type="date" name="bday" placeholder="Birthday" id="bday" value="<?php if(!empty($bday)) echo $bday;?>"/><br/>
<input type="text" name="email" placeholder="Email" id="email" value="<?php if(!empty($email)) echo $email;?>"/><br/>
<input type="text" name="gen" placeholder="Gender" id="gen" value="<?php if(!empty($gen)) echo $gen;?>"/><br/>
<input type="file" name="file" placeholder="Upload Image" /><br/>
<input type="submit" name="start" value="Submit"/><br/>
<a href="login.php">Back</a>
</form>
</body>
</html>
