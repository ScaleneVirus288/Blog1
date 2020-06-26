<?php
	session_start();

	require_once "connect.php";
	include 'classes.php';
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	$wszystko_OK = true;

	//
	//sprawdzanie tytułu
	//
	
	if (empty($_POST)) header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3');
	if (isset($_POST['title']))	
	{
		$title = $_POST['title'];
		$_SESSION['f_title'] = $title;
	
		if ((strlen($title)<3) || (strlen($title)>200))
		{
			$wszystko_OK = false;
			
			$_SESSION['error'] = "Tytuł musi posiadać od 3 do 200 znaków!";
			header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/nowy_artykul');
		}
	}
	else
	{
		$wszystko_OK = false;
	}
	
	//
	//sprawdzanie treści
	//
	
	if (isset($_POST['content']))	
	{
		$content = $_POST['content'];
		$_SESSION['f_content'] = $content;
	
		if ((strlen($content)<50) || (strlen($content)>2000))
		{
			$wszystko_OK=false;
			
			$_SESSION['error']="Treść musi posiadać od 50 do 2000 znaków!";
			header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/nowy_artykul');
		}
	}
	
	if(!is_uploaded_file($_FILES["plik"]["tmp_name"]))
	{
		$wszystko_OK = false;
		$_SESSION['error']="Musisz dodać zdjęcie!";
		header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/nowy_artykul');
	}
	
	//
	//SQL
	//

	if ($wszystko_OK == true)
	{
		if (isset($_POST['title']) && isset($_POST['content'])) 
		{
			$title = $_POST['title'];
			$content = $_POST['content'];

			try 
			{
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
				$polaczenie-> query('SET NAMES utf8');
				if ($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$user = Blog::GetUser($_SESSION['id']);
					$login = $user->username;
					$data = date("Y-m-d H:i:s");
					$sql = "INSERT INTO artykuly VALUES (NULL, '$title', '$data', '$login');";
					if ($polaczenie->query($sql))
					{
						$_SESSION['success'] = "Pomyślnie utworzono atykuł";

						$_SESSION['tytul']=$title;
						$_SESSION['text']=$content;
						include 'save.php';
						
						$sql = "select id from artykuly where data='$data';";
					
						$result = $polaczenie->query($sql);
						
						if ($result->num_rows > 0) 
						{
							// output data of each row
							while($row = $result->fetch_assoc()) 
							{
								$article = $row["id"];
							}
						} 
						else 
						{
							echo "0 results";
						}
						
						$polaczenie->close();
						
						//$_SESSION['success'] = $article;
						
						//print_r($_FILES);
						
						if(is_uploaded_file($_FILES["plik"]["tmp_name"]))
						{
							$imageFileType = strtolower(pathinfo($_FILES["plik"]["name"],PATHINFO_EXTENSION));
							$target_file = '/home/blog/artykuly/'.$article.'/img.' . $imageFileType;
							$uploadOk = 1;
							
							echo $imageFileType;
							//$imageFileType = filetype($target_file);
							// Check if image file is a actual image or fake image
							if(isset($_POST["submit"])) 
							{
								$check = getimagesize($_FILES["plik"]["tmp_name"]);
								if($check !== false) 
								{
									echo "File is an image - " . $check["mime"] . ".";
									$uploadOk = 1;
								} 
								else 
								{
									echo "File is not an image.";
									$uploadOk = 0;
								}
							}
							// Check if file already exists
							//if (file_exists($target_file)) 
							if (is_file($target_file)) 
							{
								echo "Sorry, file already exists.";
								$uploadOk = 0;
							}

							// Check file size
							// if ($_FILES["plik"]["size"] > 5000000) 
							// {
								// echo "Sorry, your file is too large.";
								// $uploadOk = 0;
							// }

							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") 
							{
								$_SESSION['error']= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
								header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/nowy_artykul');
								$uploadOk = 0;
							}

							// Check if $uploadOk is set to 0 by an error
							if ($uploadOk == 0) 
							{
								echo "Sorry, your file was not uploaded.";
							// if everything is ok, try to upload file
							} 
							else 
							{
								if (move_uploaded_file($_FILES["plik"]["tmp_name"], $target_file)) 
								{
									echo "The file ". basename( $_FILES["plik"]["name"]). " has been uploaded.";
								} 
								else 
								{
									echo "Sorry, there was an error uploading your file.";
								}
							}
						}
						else 
						{
							echo "Nawet nie przesyłasz żadnego pliku xD";
						}
						
						
						
						header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/profil');
					}
					else
					{
						throw new Exception($polaczenie->error);
						$_SESSION['error']="Niezidentyfikowany błąd!";
						$polaczenie->close();
						header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/nowy_artykul');
					}
					
					
				}
				
			}
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! </span>';
				echo '<br />Informacja developerska: '.$e;
			}
		}
	}
	
	//
	//sprawdzanie zdjęcia
	//
	
	
?>