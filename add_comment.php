<?php
	session_start();

    if (empty($_POST))
    {
        header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
        exit();
    }

    include 'classes.php';
    mysqli_report(MYSQLI_REPORT_STRICT);
    
    
    $user = Blog::GetUser($_SESSION['id']);
    $login = $user->username;
    $content = $_POST['content'];
    $article = $_POST['article'];
    
    $content=htmlentities($content, ENT_QUOTES, "UTF-8");
   
    //wczytanie tekstu
    $plik=fopen('/home/blog/artykuly/'.$article.'/komentarze.txt','r');

    $dane='';

    while(!feof($plik))
    {
    $linia=fgets($plik);

    $dane=$dane.$linia;
    }

    fclose($plik);


    //zapis tekstu
    $plik=fopen('/home/blog/artykuly/'.$article.'/komentarze.txt', "a") or die("Unable to open file!");

    $part1 = '<div class="comment"> <div class="user"><b>';
    $part2 = '</b></div> <div class="commentcontent">';
    $part3 = '</br></br></div></div>';

    $append = $part1.$login.$part2.$content.$part3;

    fwrite($plik,$append."\n");

    fclose($plik);

    header("Location: https://poscielecapri.pl/Jakub/Szkola/blog3/artykul/$article");

/*
    // If not logged in redirect
	require_once "connect.php";
	include 'classes.php';
    mysqli_report(MYSQLI_REPORT_STRICT);
    if (empty($_POST)) header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
        
        $user = Blog::GetUser($_SESSION['id']);
        $login = $user->username;
        $content = $_POST['content'];
        $article = $_POST['article'];
    
        try 
        {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            $sql = "INSERT INTO komentarze VALUES (NULL, '$login', '$content', '$article')";
            if ($polaczenie->query($sql))
            {
                header("Location: https://poscielecapri.pl/Jakub/Szkola/blog3/artykul/$article");
            }
            else
            {
                throw new Exception($polaczenie->error);
            } 
        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! </span>';
            echo '<br />Informacja developerska: '.$e;
        }
    
        $polaczenie->close();
	*/
?>