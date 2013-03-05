<?php
	session_start();

    $pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
?>

<html lang="en-US">
	<head>
		<title>Add Blog Entry</title>
		<link href="CSS/styleUI.css" rel="stylesheet" type="text/css">
		<!--[if IE 6]>
		<script type="text/ecmascript" src="js/html5.js"></script>
		<![endif]-->
	</head>
	<body>

		<div id="wrap">
			<header id="mainheader">
				<h1>Site <span>Name</span></h1>
			</header>
			<nav id="topnav">
				<ul>
					<li class="active"><a href="#">Home</a></li>
					<li><a href="view_profile.php">Profile</a></li>
					<li><a href="view_blog.php">Blogs</a></li>
					<li><a href="logout.php">Logout</a></li>
					<li><form name = "search" method = "post" action = "search_result.php">
						<label for = "searchme">Search: </label><input type = "search" id = "searchme" name = "searchme"/>
					</form></li>
				</ul>
			</nav>
			<div id="maincontent">
				<section id="leftcontent" class="normalpage">
					<section id="leftcontents">
						<header id="mainheading">
							<h2>Publish Journal</h2>
						</header>
						<div id="contentwrap">
							<form enctype = "multipart/form-data" name = "add_blog" action = "add_blog.php" method = "post">
								<article class="postpre">
									<header>
										<h3>Blog Title:</h3>
									</header>
									<input type = "text" name = "title" id = "title" placeholder = "Title"/>
								</article>
								<div class="postbtm"></div>
								<article class="postpre">
									<header>
										<h3>Blog Image:</h3>
										</header>
									<input type = "file" name = "uploaded" id = "pic" size = "50" />
								</article>
								<div class="postbtm"></div>
								<article class="postpre">
									<header>
										<h3>Image Caption:</h3>
									</header>
									<textarea name = "caption" cols = 40 rows = 3 placeholder = "Type image caption here"></textarea>
								</article>
								<div class="postbtm"></div>
								<article class="postpre">
									<header>
										<h3>Blog Entry:</h3>
									</header>
									<textarea name = "text" cols = 40 rows = 10 required placeholder = "Type your thoughts here :)"></textarea>
								</article>
								<div class="postbtm"></div>
								<article class="postpre">
									<header>
										<h3>Publish</h3>
									</header>
									<input type = "submit" value = "Publish!" name = "add_blog" />
								</article>
								<div class="postbtm"></div>
							</form>
						</div>
					</section>
				</section>
				<section id="sidebar">
					<img src="images/default.png" height="10%" width="30%"/>
					<h2 title="Categories">Username</h2>
						<div class="sb-c">
							<p class="testimonial">
								<img src="images/star.png" height="5%" width="15%"/>
								<p>star count</p>
							</p>
						</div>
					<div class="sb-c">
						<a href="view_blog.php">My Blogs</a>
						<a href="view_profile.php">My Profile</a>
					</div>
				</section>
				<div class="clear"></div>
			</div>
		</div>
		<footer>
			<p>2013 &copy; Online Diary| All Rights Reserved|Partial Fulfillment of Requirements In CMSC 128</a></p>

		</footer>
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
