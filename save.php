<?php
session_start();


$nazwa=$_SESSION['nazwa'];
$nazwa=htmlentities($nazwa);

$tytul=$_SESSION['tytul'];
$tytul=htmlentities($tytul);

$text=$_SESSION['text'];
$text=htmlentities($text);

$obraz=$_SESSION['obraz'];

$sql="SELECT id FROM artykuly ORDER BY id DESC LIMIT 1";

try
{
require_once 'connect.php';
$conn = new mysqli($host, $db_user, $db_password, $db_name);

if($conn->connect_errno!=0)
{
throw new Exception(mysqli_connect_errno());
}
else
{
$result=$conn->query($sql);
$wyniki=$result->num_rows;

while($row=$result->fetch_array())
{
$rows[]=$row;
}
$conn->close();
}
}
catch(Exception $e)
{
echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
//echo '<br />Informacja developerska: '.$e;
}


$id=$rows[0]['id'];
echo $id;
mkdir('/home/blog/artykuly/'.$id.'/', 0757, true);
chmod('home/blog/artykuly/'.$id.'/', 0777);

$plik=fopen("/home/blog/artykuly/".$id."/tresc.txt", "w") or die("Unable to open file!");

fwrite($plik,$text);

fclose($plik);




$plik=fopen("/home/blog/artykuly/".$id."/komentarze.txt", "w") or die("Unable to open file!");

fwrite($plik,"");

fclose($plik);

unset($_SESSION['nazwa']);

unset($_SESSION['tytul']);

unset($_SESSION['text']);

unset($_SESSION['obraz']);
?>
