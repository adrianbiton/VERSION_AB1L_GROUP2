<?php
	session_start();
	
    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
?>


<html>
	<head>
		<title>Add Blog Entry</title>
		<!-- modernizr enables HTML5 elements and feature detects -->
		<script type="text/javascript" src="js/modernizr-1.5.min.js"></script>	
		<script src="JS/jquery.js"></script>
		<script src="JS/picture.js"></script>
		<link href="CSS/picture.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="CSS/stylehome.css" />
		<script>
			$(function(){

				$('#slider').movingBoxes({
					/* width and panelWidth options deprecated, but still work to keep the plugin backwards compatible
					width: 500,
					panelWidth: 0.5,
					*/
					startPanel   : 1,      // start with this panel
					wrap         : false,  // if true, the panel will infinitely loop
					buildNav     : true,   // if true, navigation links will be added
					navFormatter : function(){ return "&#9679;"; } // function which returns the navigation text for each panel
				});

			});
		</script>
		<style>
			/* Dimensions set via css in MovingBoxes version 2.2.2+ */
			#slider { width: 500px; }
			#slider li { width: 250px; }
			
		</style>
	</head>
	
	<body>
	
	<header>
			<div id = "logo">
				<h1><a href = "home.php"><site name></a></h1>
				<p class="description">Online diary</p>
			</div>
			<div id = "navbar">
				<ul>
					<li><a href="home.php" id="home">&nbsp;Home&nbsp;</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
					<li><a href="#" id="profile">&nbsp;Profile&nbsp;</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
					<li><a href="#" id="blogs">&nbsp;Blogs&nbsp;</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
					<li><a href="logout.php" id="logout">&nbsp;Log Out&nbsp;	</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
					<li><form name = "search" method = "post" action = "search_result.php" id = "search">
						<input type = "search" id = "searchme" name = "searchme" placeholder="Search"/>
					</form></li>
				</ul>
			</div>
			<hr id = "hrtop"></hr>
		</header>
		<hr></hr>
		<div id = "sidebar">
			<img src = "images/default.png" id = "picture"/>
			<h3>Username</h3>
			<img src = "images/star.png" height= "10%" id = "starpic"/>
			<label id = "starcount">starcount</label>
			<hr/>
			<div id = "bottom">
				<a href="#" id = "linkblog">My Blogs</a><br/>
				<a href="#" id = "linkcomment">Comments</a>
			</div>
		</div>
		<div id = "main">
			<form enctype = "multipart/form-data" name = "add_blog" action = "add_blog.php" method = "post">
				<div id ="wrapper">
				<ul id="slider">

					<li>
						<!--div for BLOG_TITLE-->
						<div name = "blog_title">
							Blog Title:<input type = "text" name = "title" id = "title" placeholder = "Title"/>
						</div>
					</li>
					<li>
						<!--div for BLOG_PIC-->
						<div name = "blog_pic">
							Blog Image:<input type = "file" name = "uploaded" id = "pic" size = "50" />
						</div>
						<!--div for image_CAPTION-->
						<div name = "image_caption">
							Image Caption:<textarea name = "caption" cols = 40 rows = 10 placeholder = "Type image caption here"></textarea>
						</div>
					</li>
					<li>
						<!--div for right part--CONTAINS THE BLOG ENTRY-->
						<div id = "blog_entry">
							<!--div for BLOG_TEXT-->
							<div name = "blog_text">
								Blog Entry:<textarea name = "text" cols 50 rows = 20 required placeholder = "Type your thoughts here :)"></textarea>
							</div>
						</div>		
					</li>

				</ul>
				</div>
				<!--BUTTON HERE-->
				<input type = "submit" value = "Publish!" name = "add_blog" id ="button" />
			</form>
		</div>
	
	
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
