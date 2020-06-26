<?php
class Blog
{
    var $id;
    var $username;
    var $admin;

    function __construct($id, $username, $admin)
	{        
		$this->id = $id;
		$this->username = $username;
		$this->admin = $admin;
    }
    
    public static function GetUser($id)
    {
        require "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$conn = new mysqli($host, $db_user, $db_password, $db_name);

			if($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$sql = "select * from users where id=$id";
                $result=$conn->query($sql)->fetch_assoc();

                $user = new Blog($result['id'],$result['login'],$result['admin']);
                
                return $user;
                $conn->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
        }
    }

    public static function ViewProfile($user)
	{
        if(isset($_SESSION["f_title"]))
		{
			unset($_SESSION["f_title"]);
		}
		if(isset($_SESSION["f_content"]))
		{
			unset($_SESSION["f_content"]);
        }

        echo " <h1>Witaj, $user->username</h1>";
        
        if(isset($_SESSION["success"]))
		{
            echo $_SESSION['success'];
			unset($_SESSION["success"]);
        }
    
		echo "
			<br>
			<h4>Panel użytkownika</h4>
			<br>
			<a href=https://poscielecapri.pl/Jakub/Szkola/blog3/zmiana_hasla>Zmień hasło</a>
		";
		
		if($user->admin == 1)
		{
			echo "
				<br>
				<a href=https://poscielecapri.pl/Jakub/Szkola/blog3/nowy_artykul>Utwórz nowy artykuł</a>
			";
		}
		else if($user->admin == 0)
		{
			
		}
		
		echo "
			<br>
			<a href=https://poscielecapri.pl/Jakub/Szkola/blog3/logout.php>Wyloguj</a>
		";
	}

	public static function ChangePassword()
	{
		echo '
			<div class="col-sm-12">
				<form action="https://poscielecapri.pl/Jakub/Szkola/blog3/change_password.php" method="post"> 
					<div class="auth-box">
						<div class="card-block">
							<div class="row m-b-20">
								<div class="col-md-12">
									<h3 class="text-center">Zmień hasło</h3>
								</div>
							</div>
							<div class="form-group form-primary">
								<div class="col-md-12">
									<h6 class="text-center">Obecne hasło:</h6>
								</div>
								<input type="password" name="current_password" class="form-control" required="" placeholder="Obecne hasło">
								<span class="form-bar"></span>
							</div>
							<div class="form-group form-primary">
								<div class="col-md-12">
									<h6 class="text-center">Nowe hasło:</h6>
								</div>
								<input type="password" name="new_password1" class="form-control" required="" placeholder="Nowe hasło">
								<span class="form-bar"></span>
							</div>
							<div class="form-group form-primary">
								<div class="col-md-12">
									<h6 class="text-center">Powtórz nowe hasło:</h6>
								</div>
								<input type="password" name="new_password2" class="form-control" required="" placeholder="Powtórz nowe hasło">
								<span class="form-bar"></span>
							</div>
							<span>
		';
		if(isset($_SESSION["error"]))
		{
			echo $_SESSION["error"]; 
			unset($_SESSION["error"]);
		}
		echo '
							</span>
							<div class="row m-t-25 text-left">
								<div class="col-12">
									
								</div>
							</div>
							<div class="row m-t-30">
								<div class="col-md-12">
									<button type="submit" class="btn btn-dark btn-md btn-block text-center m-b-20">Zmień hasło</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		';
	}

	public static function ViewArticles()
	{
		$articles = Article::GetArticles();

		echo "<center><h1> Artykuły </h1></center>";
		
		for ($a=0; $a<count($articles); $a++)
		{
			echo '<a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/artykul/'.$articles[$a]->id.'">';
			echo $articles[$a]->tytul;
			echo '</a>';
		}
	}
}

class Article
{
	var $id;
    var $tytul;
	var $data;
    var $user;

    function __construct($id, $tytul, $data, $user)
	{        
		$this->id = $id;
		$this->tytul = $tytul;
		$this->data = $data;
		$this->user = $user;
    }
	
	public static function GetArticle($id_artykulu)
    {
        require "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$conn = new mysqli($host, $db_user, $db_password, $db_name);
			mysqli_set_charset($conn,"utf8");

			if($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$sql = "select * from artykuly where id=$id_artykulu";
                $result=$conn->query($sql)->fetch_assoc();

                $artykul = new Article($result['id'],$result['tytul'],$result['data'],$result['user']);
                
                return $artykul;
                $conn->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
        }
	}

	function GetArticles()
	{
		require "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$conn = new mysqli($host, $db_user, $db_password, $db_name);
			mysqli_set_charset($conn,"utf8");

			if($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$sql = "select * from artykuly ORDER BY id DESC";
				$result=$conn->query($sql);
				
				while($row=$result->fetch_array())
				{
					$rows[]=$row;
				}

				for($i=0;$i<count($rows);$i++)
				{
					$articles[$i] = new Article($rows[$i][0],$rows[$i][1],$rows[$i][2],$rows[$i][3]);
				}
                return $articles;
				$conn->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
        }
	}
	
	function ShowContent($id)
	{
		$plik=fopen("/home/blog/artykuly/".$id."/tresc.txt", "r") or die("Unable to open file!");
		
		$dane='';

		while(!feof($plik))
		{
		$linia=fgets($plik);

		$dane=$dane.$linia;
		}

		//$dane=htmlentities($dane, ENT_QUOTES, "UTF-8");

		fclose($plik);

		echo $dane;
	}

	function ShowComments($id)
	{
		$plik=fopen("/home/blog/artykuly/".$id."/komentarze.txt", "r") or die("Unable to open file!");
		
		$dane='';

		while(!feof($plik))
		{
		$linia=fgets($plik);

		$dane=$dane.$linia;
		}

		//$dane=htmlentities($dane, ENT_QUOTES, "UTF-8");

		fclose($plik);

		echo $dane;
	}

	function AddComment($id)
	{
		echo '<form action="https://poscielecapri.pl/Jakub/Szkola/blog3/add_comment.php" method="post"> 

		<div class="col-md-12">
			<h6 class="text-center">Dodaj nowy komentarz:</h6>
		</div>
		<textarea rows="6" name="content" class="form-control" placeholder="Komentarz">'.$_SESSION["f_comment"].'</textarea>

		<input id="article" name="article" value="'.$id.'" style="display: none;"></input>

		<div class="row m-t-30">
			<div class="col-md-12">
				<button type="submit" class="btn btn-dark btn-md btn-block text-center m-b-20">Wyślij</button>
			</div>
		</div>

		</form>';
	}

	public static function PrintArticle($article, $user)
	{
		if ($article->id == "")
		{
			echo "Nie znaleziono artykułu";
		}
		else
		{
			echo "<center><h2>$article->tytul</h2></center>"; //wyswietlanie tytułu
			echo "<br>";
			
			echo "
				<center>
					<img src='https://poscielecapri.pl/Jakub/Szkola/blog3/read_img.php?article_id=$article->id' width='50%' class='rounded mx-auto d-block'/>
				</center>"
			; //wyswietlanie obrazka
			

			
			
			echo "<p>";
			Article::ShowContent($article->id); //wyświetlanie treści
			echo "</p>"; 
			echo "<br>";

			echo "<h2>Komentarze</h2>";
			Article::ShowComments($article->id); // komentarze

			
			if($_SESSION['logged_in_blog']) Article::AddComment($article->id);
			else echo 'Zaloguj się aby skomentować!';

			/*
			//
			//komentarze
			//
			$nazwa_artykulu = $article->nazwa;
			$komentarze = Comment::GetComments($article->id);
			
			if(count($komentarze) > 0)
			{
				for($i = 0; $i<count($komentarze); $i++)
				{
					echo '	<br>';
					echo $komentarze[$i]->user; 
					echo '<br>';
					echo $komentarze[$i]->tresc; 
					echo '<br>';
					if(isset($_SESSION['logged_in_blog']))
					{
						if($_SESSION['logged_in_blog'] == true && $user->admin == 1)
						{
							echo '
								<form action="https://poscielecapri.pl/Jakub/Szkola/blog3/delete_comment.php" method="post"> 
									<input name="user" value="'.$komentarze[$i]->user.'" style="display: none;"></input>
									<input name="id" value="'.$komentarze[$i]->id.'" style="display: none;"></input>
									<input name="article" value="'.$article->id.'" style="display: none;"></input>
									<input type="submit" name="test" id="test" value="RUN" /><br/>
								</form>
							';
						}
					}
				}
			}
			*/
		}
	}

	public static function DeleteComment($id, $user)
    {
        require "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$conn = new mysqli($host, $db_user, $db_password, $db_name);
			mysqli_set_charset($conn,"utf8");

			if($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$sql = "delete from komentarze where id='$id' and user='$user'";
				$conn->query($sql);
				
                $conn->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
        }
    }

	public static function NewArticle()
	{
		echo '
			<div class="col-sm-12">
				<form action="https://poscielecapri.pl/Jakub/Szkola/blog3/create_article.php" method="post" enctype="multipart/form-data"> 
					<div class="auth-box">
						<div class="card-block">
							<div class="row m-b-20">
								<div class="col-md-12">
									<h3 class="text-center">Utwórz nowy artykuł</h3>
								</div>
							</div>
							<div class="form-group form-primary">
								<div class="col-md-12">
									<h6 class="text-center">Tytuł:</h6>
								</div>
								<input type="text" name="title" class="form-control" required="" placeholder="Tytuł" value='.$_SESSION["f_title"].'>
								<span class="form-bar"></span>
							</div>
							<div class="form-group form-primary">
								<div class="col-md-12">
									<h6 class="text-center">Zdjęcie:</h6>
								</div>
								<input type="file" name="plik" class="form-control" id="fileToUpload">
								<span class="form-bar"></span>
							</div>
							<div class="form-group form-primary">
								<div class="col-md-12">
									<h6 class="text-center">Treść:</h6>
								</div>
								<textarea rows="6" name="content" class="form-control" placeholder="Treść artykułu">'.$_SESSION["f_content"].'</textarea>
								<span class="form-bar"></span>
							</div>
							<span>
		';
		if(isset($_SESSION["f_title"]))
		{
			unset($_SESSION["f_title"]);
		}
		if(isset($_SESSION["f_content"]))
		{
			unset($_SESSION["f_content"]);
		}
		if(isset($_SESSION["error"]))
		{
			echo $_SESSION["error"]; 
			unset($_SESSION["error"]);
		}
		echo '
							</span>
							<div class="row m-t-25 text-left">
								<div class="col-12">
								</div>
							</div>
							<div class="row m-t-30">
								<div class="col-md-12">
									<button type="submit" name="submit" class="btn btn-dark btn-md btn-block text-center m-b-20">Wyślij</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		';
	}
}

?>