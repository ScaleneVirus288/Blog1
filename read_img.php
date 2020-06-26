<?php
	session_start();


	$article_id = $_GET['article_id'];
	
	header("Content-Type:image/png"); //passing the mimetype

	$image = '/home/blog/artykuly/'.$article_id.'/img.png'; 
	if(!is_file($image)) $image = '/home/blog/artykuly/'.$article_id.'/img.jpg'; 
	if(!is_file($image)) $image = '/home/blog/artykuly/'.$article_id.'/img.gif'; 
	if(!is_file($image)) $image = '/home/blog/artykuly/'.$article_id.'/img.jpeg'; 

	if(is_file($image) ||  is_file($image = "/home/ftpUsername/assets/no_image.png"))
		readfile($image);
	echo "<br>";
	
?>