<?php
	$id = $_POST['name'];
	echo "huhu".$id;
	//IF-CONDITION FOR REPLACING THE IMAGE
	if(isset($_GET['image'])){
		$query1 = "UPDATE blogs SET ";
	}
	//IF-CONDITION FOR EDITING IMAGE CAPTION
	if(isset($_GET['captionS'])){
		$query2 = "UPDATE blogs SET caption = ".$_POST['caption']." where blog_id =".$_POST['name'].";";
	}
	//IF-CONDITION FOR EDITING DIARY BLOG
	if(isset($_GET['text'])){
	}
?>