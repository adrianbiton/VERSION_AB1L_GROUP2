<?php
//edits the blog selected

	session_start();
	if(isset($_POST['captionS']) || isset($_POST['blogS']) || isset($_POST['image']))
		$id = $_POST['name'];
	else
		$id = $_GET['name'];
	
	$pgsql_conn = pg_connect("dbname=postgres host=localhost user=postgres password=12345");
	
	$query = "select * from blogs where blog_id = ".$id.";";
	
	echo $query;
	
	$result = pg_query($pgsql_conn, $query);
		
	//fetching the column values :)
	while ($row = pg_fetch_array($result)) {
	
	//viewing the blog entries :)
		$myFile = "entries/".$row['blog_id'].".txt";
		$fh = fopen($myFile, 'r');
		$theData = fread($fh, filesize($myFile));
		fclose($fh);
?>
<html>
<head>
	<title></title>
	 <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

	<form enctype = "multipart/form-data" name = "edit_blog" action = "edit_blog.php" method = "post">
	<div class="accordion vertical">
		  <section id="repimage">
		      <h2><a href="#repimage">Replace Image</a></h2>
		      <p>
				<input type = "file" name = "uploaded" id = "pic" size = "50" />
				<input type = "submit" name = "image" value = "Submit"/>
			  </p>
		  </section>
		  <section id="imagecap">
		      <h2><a href="#imagecap">Edit Image Caption</a></h2>
		      <p>
				<textarea name = "caption" cols = 130 rows = 10 placeholder = "Type image caption here"><?php echo $row['caption'];?></textarea>
				<input type = "submit" name = "captionS" value = "Submit"/>
			  </p>
		  </section>
		  <section id="blog">
		      <h2><a href="#blog">Edit Diary Blog</a></h2>
		      <p>
				<textarea name = "text" cols = 130 rows = 10 required placeholder = "Type your thoughts here :)"><?php echo $theData; ?></textarea>
				<input type = "submit" name = "blogS" value = "Submit"/>
			  </p>
		  </section>
		</div>
		<div id = "HIDE">
			<textarea name="name"><?php echo $id; ?></textarea>

<?php
	}
	
	//FUNCTION FOR CHECKING FILE EXTENSION
		 function findexts ($filename) 
		 { 
		 $filename = strtolower($filename) ; 
		 $exts = split("[/\\.]", $filename) ; 
		 $n = count($exts)-1; 
		 $exts = $exts[$n]; 
		 return $exts; 
		 }
	
	//IF-CONDITION FOR REPLACING THE IMAGE
	if(isset($_POST['image'])){
		
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
		
		$query1 = "UPDATE blogs SET image = '".$ran2.$ext."' where blog_id =".$_POST['name'].";";
		//echo $query1;
		$result1 = pg_query($pgsql_conn, $query1);
	}else
	//IF-CONDITION FOR EDITING IMAGE CAPTION
	if(isset($_POST['captionS'])){
		$query2 = "UPDATE blogs SET caption = '".$_POST['caption']."' where blog_id =".$_POST['name'].";";
		//echo $query2;
		$result2 = pg_query($pgsql_conn, $query2);
	}else
	//IF-CONDITION FOR EDITING DIARY BLOG
	if(isset($_POST['blogS'])){
		 $File = "entries/".$id.".txt"; 
		 $Handle = fopen($File, 'w');
		 $Data = $_POST['text']; 
		 echo $Data;
		 fwrite($Handle, $Data);
		 fclose($Handle); 
	}
?>
		</div>
	</form>
	</body>
</html>