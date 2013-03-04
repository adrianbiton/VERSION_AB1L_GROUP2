<?php
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
?>


<html>
	<head>
		<title>Add Blog Entry</title>
		<!-- modernizr enables HTML5 elements and feature detects -->
		<script type="text/javascript" src="js/modernizr-1.5.min.js"></script>	
	</head>
	
	<body>
	
	<form enctype = "multipart/form-data" name = "add_blog" action = "add_blog.php" method = "post">
		
		<!--div for left part of the page-->
		<div id = "left_cblog">
			<!--div for BLOG_TITLE-->
			<div name = "blog_title">
				Blog Title:<input type = "text" name = "title" id = "title" placeholder = "Title"/>
			</div>
			
			<!--div for BLOG_PIC-->
			<div name = "blog_pic">
				Blog Image:<input type = "file" name = "uploaded" id = "pic" size = "50" />
			</div>
			
			<!--div for image_CAPTION-->
			<div name = "image_caption">
				Image Caption:<textarea name = "caption" cols = 40 rows = 10 placeholder = "Type image caption here"></textarea>
			</div>
		</div>
		
		<!--div for right part--CONTAINS THE BLOG ENTRY-->
		<div id = "blog_entry">
			<!--div for BLOG_TEXT-->
			<div name = "blog_text">
				Blog Entry:<textarea name = "text" cols 50 rows = 20 required placeholder = "Type your thoughts here :)"></textarea>
			</div>
		</div>
		
		<!--BUTTON HERE-->
		<input type = "submit" value = "Publish!" name = "add_blog" />
	</form>
	
	
	<?php
		//FUNCTION FOR CHECKING FILE EXTENSION
		 function findexts ($filename) 
		 { 
		 $filename = strtolower($filename) ; 
		 $exts = split("[/\\.]", $filename) ; 
		 $n = count($exts)-1; 
		 $exts = $exts[$n]; 
		 return $exts; 
		 } 
		 
		if(isset($_POST['add_blog'])){
			
			
			//UPLOADS IMAGE FILES
			if($_FILES['uploaded']['name'] != null){
				//This applies the function to our file  
				$ext = findexts ($_FILES['uploaded']['name']) ;
				//This line assigns a random number to a variable.
				$ran = rand () ;
				$ran2 = $ran.".";
				//This assigns the subdirectory you want to save into... make sure it exists!
				$target = "images/";
				//This combines the directory, the random file name, and the extension
				$target = $target . $ran2.$ext;
				//uploads the image file
				move_uploaded_file($_FILES['uploaded']['tmp_name'], $target);
			}
			//END-UPLOAD
			
			//SAVE THE BLOG ENTRY IN A FILE
			$ran3 = rand();
			$filename = $ran3.".txt";
			$filesave = "entries/".$filename;
			$filehandle = fopen($filesave, 'w') or die("can't open file");
			$data = $_POST['text'];
			fwrite( $filehandle, $data );
			print "Blog Published!<br/>";
			fclose($filehandle);
			//END-SAVE-BLOG-ENTRY
			
			//check values first
			if($_POST['title'] != null)
				$titleV = $_POST['title'];
			else
				$titleV = null;
			if($_POST['caption'] != null)
				$captionV = $_POST['caption'];
			else
				$captionV = null;
			
			//real query
			$query = "INSERT INTO blogs VALUES('".$ran3."', now(), '".$ran2.$ext."', '". $titleV."', '". $captionV."', '".$_SESSION['uname']."');";
			
			echo $query;
			$result = pg_exec($pgsql_conn, $query) or die('Query failed: ' . pg_last_error());
		}
		
	?>
	</body>
</html>