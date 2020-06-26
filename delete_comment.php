<?php
	session_start();
    
    // If not logged in redirect
	require_once "connect.php";
	include 'classes.php';
    mysqli_report(MYSQLI_REPORT_STRICT);
    if (empty($_POST)) header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
    
    $id = $_POST['id'];
    $user = $_POST['user'];
    $article = $_POST['article'];
    Comment::DeleteComment($id, $user);

    header("Location: https://poscielecapri.pl/Jakub/Szkola/blog3/artykul/$article");
?>