<?php
	/*
	session_start();
	
	if($_SESSION['logged_in_blog'] == true)
	{
		header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
		exit();
	}

	if((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/register');
		exit();
	}

	require_once(__DIR__.'/connect.php');
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try 
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);

		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		//$sql = "INSERT INTO users VALUES (null, '".$login."', '".$password."', 0);";
		
		if($connection->connect_errno!=0)
		{
			throw new Exception($connection->error);
		}
		else
		{
			$connection->query($sql);
			
			print_r($sql);
			
			$connection->close();
			//header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3');
		}
		
		$connection->close();
	
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
		//echo '<br />Informacja developerska: '.$e;
	}
	*/
?>

<!--
<?php
	session_start();

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	$wszystko_OK = true;

	//
	//sprawdzanie loginu
	//
	
	if (isset($_POST['login']))	
	{
		$login = $_POST['login'];
	
		if ((strlen($login)<3) || (strlen($login)>20))
		{
			$wszystko_OK=false;
			
			$_SESSION['error']="Login musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($login)==false)
		{
			$wszystko_OK=false;
			
			$_SESSION['error']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
	}
	/*
	if (isset($_POST['email']))
	{
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
	
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK = false;
			$_SESSION['e_email'] = "Podaj poprawny adres email!";
		}
	}
	*/
	
	//
	//sprawdzanie hasla
	//
	
	if (isset($_POST['password1']) || isset($_POST['password2']))
	{
		if (isset($_POST['password1'])) $haslo1 = $_POST['password1'];
		if (isset($_POST['password2'])) $haslo2 = $_POST['password2'];
		
		if ((strlen($haslo1)<6) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			
			$_SESSION['error']="Hasło musi posiadać od 6 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			
			$_SESSION['error']="Podane hasła nie są identyczne!";
		}	
	
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
	}
	
	//
	//SQL
	//

	if (isset($_POST['login'])) 
	{
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT id FROM users WHERE login='$login'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_loginow = $rezultat->num_rows;
				if($ile_takich_loginow>0)
				{
					$wszystko_OK=false;
					
					$_SESSION['error']="Istnieje już użytkownik o takim loginie! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					$sql = "INSERT INTO users VALUES (NULL, '$login', '$haslo_hash', 0)";
					if ($polaczenie->query($sql))
						{
							header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3');
						}
						else
						{
							throw new Exception($polaczenie->error);
						}		
				}
				else
				{
					header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/register');
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! </span>';
			//echo '<br />Informacja developerska: '.$e;
		}
	}
?>
-->