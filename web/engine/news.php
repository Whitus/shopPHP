<?php
  /**********************************************************************************
   *****
   *****    Name: Centrum MTA - CMS
   *****
   *****    Copyright (c) 2018 .WhiteBlue (oszymon018@gmail.com)
   *****
  /**********************************************************************************/

	// show one news
	$news_id = htmlspecialchars(trim($_GET['news_id']));
	
	if ($news_id)
	{
		$sql = $connect -> prepare('SELECT title, description, author, added FROM cms_news WHERE id = ?');
		
		$sql -> execute(
			array($news_id)
		);

		foreach ($sql as $get)
		{
			echo '
				<div class="jumbotron" style="word-break: break-all;">
					<h1>'. $get['title'] .'</h1>
					
					<hr>

					<p>'. nl2br($get['description']) .'</p>

					<hr>

					<p>Dodał(a): '. $get['author'] .', dnia: '. $get['added'] .'</p>
				</div>
			';
		}
	}

	else

	{
		$news_limit_one = htmlspecialchars(trim($_GET['news_limit_one']));
		$news_limit_two = htmlspecialchars(trim($_GET['news_limit_two']));

		if (empty($news_limit_one) OR empty($news_limit_two))
		{
			$news_limit_one = 1;
			$news_limit_two = 3;
		}

		// show news
		$sql = $connect -> prepare('SELECT * FROM cms_news WHERE (id BETWEEN ? AND ?) ORDER BY id DESC');
		
		$sql -> execute(
			array($news_limit_one, $news_limit_two)
		);

		foreach ($sql as $get)
		{
			echo '
				<div class="jumbotron" style="word-break: break-all;">
					<h1>'. $get['title'] .'</h1>
			';
			
					$cut = substr($get['description'], 0, 300);

					if ($cut < $get['description'])
					{
						echo '<p>'. nl2br($cut) .' (...)';
					}

					else

					{
						echo '<p>'. nl2br($get['description']) .'</p>';
					}

			echo '
					<hr>

					<p>Dodał(a): '. $get['author'] .', dnia: '. $get['added'] .'</p>

					<p><a class="btn btn-primary btn-lg" href="'. $setting['site_url'] .'index.php?news_id='. $get['id'] .'" role="button">Czytaj więcej</a></p>
				</div>
			';
		}
	
		// show pagination
		echo '
			<nav aria-label="news_pagination">
				<ul class="pager">
		';

					if ($news_limit_one > 1)
					{
						$news_prev_url = $setting['site_url'].'index.php?news_limit_one='. intval($news_limit_one - 3) .'&news_limit_two='. intval($news_limit_two - 3);

						echo '<li><a href="'. $news_prev_url .'">Poprzednia strona</a></li>';
					}

					else

					{
						echo '<li class="disabled"><a href="#">Poprzednia strona</a></li>';
					}

					$news_next_url = $setting['site_url'].'index.php?news_limit_one='. intval($news_limit_one + 3) .'&news_limit_two='. intval($news_limit_two + 3);

		echo '
					<li><a href="'. $news_next_url .'">Następna strona</a></li>
				</ul>
			</nav>
		';
	}

	echo 'Autor: .WhiteBlue. Skontaktuj się ze mną jeżeli chcesz to usunąć.';
?>