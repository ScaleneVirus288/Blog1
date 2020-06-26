<?php 
session_start();
include 'classes.php';

if($_SESSION['logged_in_blog'] == true)
{
	$user = Blog::GetUser($_SESSION['id']);
}
?>
<!DOCTYPE html>
<html lang ="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title> Blog</title>
	<meta name="description" content="Blog">
	<meta name="keywords" content="">
	<meta name="author" content="">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">
    
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://poscielecapri.pl/Jakub/Szkola/blog3/main.css">
	<script src="https://poscielecapri.pl/Jakub/Szkola/blog3/search.js"></script>
</head>

<body>
	
	<header>
		
		<nav class="navbar navbar-light nav-bg navbar-expand-md">
			
			<a class="navbar-brand" href="https://poscielecapri.pl/Jakub/Szkola/blog3/"><img src="../files/img/logo.png" class="d-inline-block mr-1 align-bottom" alt="">Blog</a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Navbar toggler">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="mainmenu">
			
				<ul class="navbar-nav">
					
					<li class="nav-item active"><a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/"> Strona Główna </a></li>
				
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true"> Kategorie </a>
						
						<ul class="dropdown-menu text-centeral" aria-labelledby="submenu">
							<li><a class="dropdown-item" href="#"> 1</a></li>
							<li><a class="dropdown-item" href="#"> 2 </a></li>
							<li><a class="dropdown-item" href="#"> 3 </a></li>
							<li><a class="dropdown-item" href="#"> 4 </a></li>
							<li><a class="dropdown-item" href="#"> 5 </a></li>
							<li><a class="dropdown-item" href="#"> 6</a></li>
						</ul>
					</li>

					<li class="nav-item"><a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/kontakt"> Kontakt </a></li>
						
				</ul>

				<ul class="navbar-nav ml-auto">
					<?php 
					if($_SESSION['logged_in_blog'] != true)
						{
							echo '<li class="nav-item"><a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/register"> Rejestracja </a></li>';
							echo '<li class="nav-item"><a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/login"> Logowanie </a></li>';
						}
						else
						{
							echo '<li class="nav-item"><a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/profil"> Profil </a></li>';
							echo '<li class="nav-item"><a class="nav-link" href="https://poscielecapri.pl/Jakub/Szkola/blog3/logout.php"> Wyloguj się </a></li>';
						}
                    ?>

					<li class="nav-link">
                        <div class="search-container">
                        
                        <input type="text" placeholder="Search...Nazwa" name="query" id="se_n" />
                        <button type="submit" onclick="search_n()"><i class="fa fa-search"></i></button>
                        
                        </div>
                    </li>
					
					<li class="nav-link">
                        <div class="search-container">
                        
                        <input type="text" placeholder="Search...Autor" name="query" id="se_u" />
                        <button type="submit" onclick="search_u()"><i class="fa fa-search"></i></button>
                        
                        </div>
                    </li>
				</ul>
			</div>
			
		</nav>
		
	</header>
	<br/>
	<?php
	$option = $_GET['page'];

	if ($option == 'login' || $option == 'register')
	{
		echo '<section class="login-block">';
		if($_SESSION['logged_in_blog'] == true)
		{
			header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
		}
	}
	?>
	<div class="container">
		<div class="row">
            <?php
			if ($option == 'login')
			{
			?>
				<div class="col-sm-12">
                    <form action="https://poscielecapri.pl/Jakub/Szkola/blog3/login.php" method="post">
                        <div class="auth-box">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
										<h3 class="text-center">Login</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="login" class="form-control" required="" placeholder="Login">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" name="password" class="form-control" required="" placeholder="Password">
                                    <span class="form-bar"></span>
                                </div>
                                <span>
                                <?php if(isset($_SESSION['error']))
                                {
                                    echo $_SESSION['error']; 
                                    unset($_SESSION['error']);
                                }
                                ?>
                                </span>
                                <div class="row m-t-25 text-left">
                                    <div class="col-12">
                                        
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-dark btn-md btn-block text-center m-b-20">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
			<?php 
			}
			else if($option == 'register')
			{
			?>
				<div class="col-sm-12">
                    <form action="https://poscielecapri.pl/Jakub/Szkola/blog3/register.php" method="post"> 
                        <div class="auth-box">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
										<h3 class="text-center">Zarejestruj się</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
									<div class="col-md-12">
										<h6 class="text-center">Login:</h6>
                                    </div>
                                    <input type="text" name="login" class="form-control" required="" placeholder="Login">
                                    <span class="form-bar"></span>
                                </div>
                                <div class="form-group form-primary">
									<div class="col-md-12">
										<h6 class="text-center">Hasło:</h6>
                                    </div>
                                    <input type="password" name="password1" class="form-control" required="" placeholder="Password">
                                    <span class="form-bar"></span>
                                </div>
								<div class="form-group form-primary">
									<div class="col-md-12">
										<h6 class="text-center">Powtórz hasło:</h6>
                                    </div>
                                    <input type="password" name="password2" class="form-control" required="" placeholder="Password">
                                    <span class="form-bar"></span>
                                </div>
                                <span>
                                <?php if(isset($_SESSION['error']))
                                {
                                    echo $_SESSION['error']; 
                                    unset($_SESSION['error']);
                                }
                                ?>
                                </span>
                                <div class="row m-t-25 text-left">
                                    <div class="col-12">
                                        
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-dark btn-md btn-block text-center m-b-20">Zarejestruj</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
			<?php
			}
			else
			{
			?>
			<div class="card" id="lista">
			<?php

				//print_r($_GET);
				switch($option)
				{
					case '':
						Blog::ViewArticles();
					break; 

					case 'kontakt':
						echo '<a href="mailto:blog@bg.pl">Kontakt</a>';
					break;
					
					case 'artykul':
						$value = $_GET['value'];

						if(isset($_GET['value']))
						{
							$artykul = Article::GetArticle($value);
							Article::PrintArticle($artykul, $user);
						}
						else 
						{
							echo "Error 404";
						}
					break;
					
					case 'profil':
						if($_SESSION['logged_in_blog'] == true)
						{
							Blog::ViewProfile($user);
						}
						else
						{
							header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
						}
					break;
					
					case 'zmiana_hasla':
						if($_SESSION['logged_in_blog'] == true)
						{
							Blog::ChangePassword();
						}
						else
						{
							header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
						}
					break;
					
					case 'nowy_artykul':
						if($_SESSION['logged_in_blog'] == true && $user->admin == 1)
						{
							Article::NewArticle();
						}
						else
						{
							header('Location: https://poscielecapri.pl/Jakub/Szkola/blog3/');
						}
					break;
					
					default:
						echo "Error 404";
						//print_r($_GET);
					break;
				}

			?>

			</div>
			<?php
			}
			?>
		</div><!-- end of row -->
	</div><!-- end of container -->
	<?php

	if ($option == 'login' || $option == 'register')
	{
		echo '</section>';
	}
	?>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


</body>
</html>