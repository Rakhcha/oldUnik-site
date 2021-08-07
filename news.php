<?php
	$page = round($_GET['page']); // 1 2 3 4 5 ...

	if($page == null || $page <= 0){
		header("Location: /news.php?page=1");
		return;
	}

	session_start();
	require_once 'scripts/php/connect.php';

	$post_index = 5*$page-5; // 0 5 10 15 20 ...
	$sql = "SELECT * FROM `news` LIMIT 5 OFFSET ".$post_index."";
	$request = mysqli_query($connect, $sql);

	$lastpage = round((mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) FROM `news`"))["COUNT(*)"]+5)/5);

	if(mysqli_num_rows($request) == 0){ // перемещение на последнюю страницу, в случае ухода за границу новостных индексов
		header("Location: /news.php?page=".$lastpage."");
	}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="shortcut icon" href="img/favicon.ico">

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/media.css">
	<link rel="stylesheet" href="css/carcass.css">

	<title>UnikVerse - Приватный сервер</title>

</head>

<body>

	<header  class="header">
		<div class="container inline">

			
			<img class="nav-btn close" src="img/menu-close.svg" alt="">
			
			<div class="logo-mini turner">
				<a href="">
					<img src="img/uniklogo_mini.webp" alt="error: L001" >
				</a>
			</div>

			
			<nav class="nav turner">
				<ul>
					<li><a href="">Главная страница</a></li>
					<li><a href="">Правила</a></li>
					<li><a href="">Начать игру</a></li>
				</ul>
			</nav>

			<div class="nav login-menu">
				<a href="">Войти</a>
			</div>
		</div>
	</header>

	

	<section class="section background clay">
		<div class="test container vertical-box">
			<header>
				<h1>Новости</h1>
			</header>
			<section id="news-container">
				<?php
					
					while ($posts = mysqli_fetch_array($request)) {
						
						printf(

							'<div class="post-container">
								<div style="background: url(img/'.$posts["image_name"].') center; background-size:cover" class="post-info post-image"></div>
								<div class="post-info post-pretext">
									<div class="post-pretext-box">
										<h2>'.$posts["title"].'</h2>
										<p>'.$posts["content"].'</p>
										<time pubdate datetime="'.$posts["datetime"].'">'.date("d.m.Y",strtotime($posts["datetime"])).'</time>
										<a href="#" class="button">Полная новость</a>
									</div>
								</div>
							</div>'
						);

					}
				?> 

			</section>
			<div class="page-container">
				<div class="page-list">
					
					<a href="?page='.($page-1).'">
						<img src="img/page-list/left-button.svg" alt="error-lb">
					</a>

					<img src="img/page-list/mini-point.svg" alt="error-mp1">
					<img src="img/page-list/medium-point.svg" alt="error-mep1">
					<img src="img/page-list/large-point.svg" alt="error-lp">
					<img src="img/page-list/medium-point.svg" alt="error-mep2">
					<img src="img/page-list/mini-point.svg" alt="error-mp2">

					<a href="?page='($page+1)'">
						<img src="img/page-list/right-button.svg" alt="error-rb">
					</a>

				</div>
			</div>
			
	</section>


	<footer>
		<div class="container footer">
			©UnikVerse 2021
		</div>		
	</footer>


	<script src="scripts/js/jquery-3.6.0.min.js"></script>
	<script src="scripts/js/main.js"></script>

	

</body>

</html>