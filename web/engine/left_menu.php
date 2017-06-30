<?php
  /**********************************************************************************
   *****
   *****    Name: Centrum MTA - CMS
   *****
   *****    Copyright (c) 2018 .WhiteBlue (oszymon018@gmail.com)
   *****
  /**********************************************************************************/
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Główne menu</h3>
	</div>

	<div class="panel-body">
		<ul class="nav nav-pills nav-stacked">
			<li><a href="<?php echo $setting['site_url']; ?>index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Strona główna</a></li>
			
			<li><a href="<?php echo $setting['site_url']; ?>index.php?app=opinie"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Opinie</a></li>
			
			<li><a href="<?php echo $setting['site_url']; ?>index.php?app=rules"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Regulamin</a></li>
		</ul>
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Panel użytkownika</h3>
	</div>

	<div class="panel-body">
		<ul class="nav nav-pills nav-stacked">
			<?php if($_SESSION['user_login']) { ?>
			
			<li><a href="<?php echo $setting['site_url']; ?>?app=wallet"><span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></span> Doładuj konto</a></li>

			<hr>

			<li><a href="<?php echo $setting['site_url']; ?>?app=ads_add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj reklamę</a></li>
			
			<li><a href="<?php echo $setting['site_url']; ?>?app=ads_list"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Lista reklam</a></li>

			<hr>

			<li><a href="<?php echo $setting['site_url']; ?>?app=orders_add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nowe zamówienie</a></li>

			<li><a href="<?php echo $setting['site_url']; ?>?app=orders_list"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Lista zamówień</a></li>
			
			<hr>

			<li><a href="<?php echo $setting['site_url']; ?>?app=logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Wyloguj się</a></li>

			<?php } else { ?>

			<li><a href="<?php echo $setting['site_url']; ?>?app=login"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Logowanie</a></li>

			<li><a href="<?php echo $setting['site_url']; ?>?app=register"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Rejestracja</a></li>

			<?php } ?>
		</ul>
	</div>
</div>