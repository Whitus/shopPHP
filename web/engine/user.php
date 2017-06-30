<?php
  /**********************************************************************************
   *****
   *****    Name: Centrum MTA - CMS
   *****
   *****    Copyright (c) 2018 .WhiteBlue (oszymon018@gmail.com)
   *****
  /**********************************************************************************/

	if (!$_SESSION['user_login'] and !$_SESSION['user_wallet'])
	{
		echo '
			<ul class="nav navbar-nav navbar-right">
				<li><a href="'. $setting['site_url'] .'index.php?app=login"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Logowanie</a></li>
				
				<li><a href="'. $setting['site_url'] .'index.php?app=register"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Rejestracja</a></li>
			</ul>
		';
	}

	else
	
	{
		$user['login'] = $_SESSION['user_login'];
		$user['wallet'] = $_SESSION['user_wallet'];

		echo '
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Witaj '. $user['login'] .'</a></li>

				<li><a href="'. $setting['site_url'] .'index.php?app=wallet"><span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></span> Skarbonka: '. round($user['wallet'], 2) .' PLN</a></li>
				
				<li><a href="'. $setting['site_url'] .'index.php?app=logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Wyloguj się</a></li>
			</ul>
		';
	}
?>