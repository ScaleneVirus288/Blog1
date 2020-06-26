<?php

	session_start();
	
	if($_SESSION['logged_in_blog'] == true)
	{
		header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
		exit();
	}

	if((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/login');
		exit();
	}

	require_once(__DIR__.'/connect.php');
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try 
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$login = $_POST['login'];
			$password = $_POST['password'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			
			if($sumarry = @$connection->query(
			sprintf("SELECT * FROM users WHERE BINARY login='%s'",
			mysqli_real_escape_string($connection,$login))))
			{
				$how_many_users = $sumarry->num_rows;
				if($how_many_users>0)
				{
					$row = $sumarry->fetch_assoc();
				
					if (password_verify($password,$row['password']))
					{
						$_SESSION['logged_in_blog'] = true;
						$_SESSION['id'] = $row['id'];
						
						unset($_SESSION['error']);
						$sumarry->close();
						header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
					}
					else
					{
						$_SESSION['error'] = '<span style="color:red"> Nieprawidłowy login lub hasło!</span>';
						header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/login');
					}
				}	
					else 
					{
						$_SESSION['error'] = '<span style="color:red"> Nieprawidłowy login lub hasło!</span>';
						header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/login');
					}
			}
			else
			{
				throw new Exception($connection->error);
			}
			
			$connection->close();
		}
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
		//echo '<br />Informacja developerska: '.$e;
	}
?>