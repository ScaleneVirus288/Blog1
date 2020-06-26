<?php
	session_start();

	require_once "connect.php";
	include 'classes.php';
	mysqli_report(MYSQLI_REPORT_STRICT);
    
    if (empty($_POST)) header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
	$wszystko_OK = true;

	//
	//sprawdzanie hasla
	//
	
	if (isset($_POST['new_password1']) && isset($_POST['new_password2']))
	{
		$haslo1 = $_POST['new_password1'];
		$haslo2 = $_POST['new_password2'];
		
		if ((strlen($haslo1)<6) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			
			$_SESSION['error']="Hasło musi posiadać od 6 do 20 znaków!";
			header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/zmiana_hasla');
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			
			$_SESSION['error']="Podane hasła nie są identyczne!";
			header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/zmiana_hasla');
		}	
	
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
	}
	
	//
	//SQL
	//
	if ($wszystko_OK == true)
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
				//
				// sprawdzanie obecnego hasla
                //
                $user = Blog::GetUser($_SESSION['id']);
                $login = $user->username;
                    
                $rezultat = $polaczenie->query("SELECT password FROM users WHERE login='$login'");
                
                $row = $rezultat->fetch_assoc();

                $obecne_haslo = $_POST['current_password'];
        
                if (password_verify($obecne_haslo,$row['password']))
                {
                    echo "tak";
                    $sql = "UPDATE users SET password='$haslo_hash' WHERE login='$login';";//KURWA, CZEMU TO NIE ZMIENIA HASŁA XD
					if ($polaczenie->query($sql))
					{
                        $_SESSION['success'] = "Pomyślnie zmieniono hasło";
						header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/profil');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}	
                }
                else
                {
                    echo "nie";
                    $_SESSION['error'] = "Błędnie podane aktualne hasło";
                    header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/zmiana_hasla');
                }
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! </span>';
			echo '<br />Informacja developerska: '.$e;
		}
	}
	
?>