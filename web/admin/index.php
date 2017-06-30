<?php
	// buforowanie danych wejściowych
	ob_start();

	// tworzenie nowej sesji
	session_start();

	// łączenie się z bazą danych
	include('../engine/config.php');
?>

<html>
	<head>
		<meta charset="utf-8"/>

		<title><?php echo $setting['site_name']; ?> - ACP</title>
	
		<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />

		<!--[if lt IE 9]>
		<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>

		<script src="js/hideshow.js" type="text/javascript"></script>

		<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>

		<script type="text/javascript" src="js/jquery.equalHeight.js"></script>

		<script type="text/javascript">
			$(document).ready(function() 
    			{ 
					$(".tablesorter").tablesorter(); 
				} 
			);

			$(document).ready(function() {

				//When page loads...
				$(".tab_content").hide(); //Hide all content
				$("ul.tabs li:first").addClass("active").show(); //Activate first tab
				$(".tab_content:first").show(); //Show first tab content

				//On Click Event
				$("ul.tabs li").click(function() {
					$("ul.tabs li").removeClass("active"); //Remove any "active" class
					$(this).addClass("active"); //Add "active" class to selected tab
					$(".tab_content").hide(); //Hide all tab content

					var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
					$(activeTab).fadeIn(); //Fade in the active ID content
					return false;
				});
			});
    	</script>

		<script type="text/javascript">
			$(function(){
				$('.column').equalHeight();
			});
		</script>
	</head>
	
	<body>
		<?php
			// sprawdzenie czy osoba jest zalogowana jako administrator
			if (!$_SESSION['admin_username']) {
				include('cat/login.php');

				return;
			}
		?>

		<!-- header -->
		<header id="header">
			<hgroup>
				<h1 class="site_title">
					<a href="<?php echo $setting['site_url']; ?>"><?php echo $setting['site_name']; ?> - ACP</a>
				</h1>
				
				<h2 class="section_title">Dashboard</h2>

				<div class="btn_view_site">
					<a href="<?php echo $setting['site_url']; ?>">Strona główna</a>
				</div>
			</hgroup>
		</header>

		<!-- navigation -->
		<section id="secondary_bar">
			<div class="user">
				<p>Witaj <?php echo $_SESSION['admin_login']; ?></p>
			</div>
			
			<div class="breadcrumbs_container">
				<article class="breadcrumbs">
					<a href="index.html">cat</a>

					<div class="breadcrumb_divider"></div>

					<a class="current">nawigacja wyłączona</a>
				</article>
			</div>
		</section>

		<!-- sidebar -->
		<aside id="sidebar" class="column">
			<h3>Start</h3>

			<ul class="toggle">
				<li class="icn_security"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=dashboard">Dashboard</a></li>
			</ul>

			<hr>

			<h3>Zawartość</h3>

			<ul class="toggle">
				<li class="icn_new_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=news_add">Nowy artykuł</a></li>
				<li class="icn_edit_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=news_view">Lista artykułów</a></li>
			</ul>

			<hr>

			<h3>Użytkownicy</h3>

			<ul class="toggle">
				<li class="icn_add_user"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=users_add">Nowy użytkownik</a></li>
				<li class="icn_view_users"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=users_view">Lista użytkowników</a></li>
			</ul>

			<hr>

			<h3>Opinie</h3>

			<ul class="toggle">
				<li class="icn_edit_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=opinie_view">Lista opinii</a></li>
			</li>

			<hr>

			<h3>Produkty</h3>

			<ul class="toggle">
				<li class="icn_new_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=products_add">Nowy produkt</a></li>
				<li class="icn_edit_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=products_view">Lista produktów</a></li>
			</ul>

			<h3>Zamówienia</h3>

			<ul class="toggle">
				<li class="icn_edit_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=orders_view">Lista zamówień</a></li>
			</ul>

			<hr>

			<h3>Płatności SMS</h3>

			<ul class="toggle">
				<li class="icn_new_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=payments_add">Nowa płatność SMS</a></li>
				<li class="icn_edit_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=payments_view">Lista płatności SMS</a></li>
			</ul>

			<hr>

			<h3>Reklamy</h3>

			<ul class="toggle">
				<li class="icn_new_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=ads_add">Nowa reklama</a></li>
				<li class="icn_edit_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=ads_view">Lista reklam</a></li>
			</ul>

			<hr>

			<h3>Kody promocyjne</h3>

			<ul class="toggle">
				<li class="icn_new_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=promo_add">Nowy kod promocyjny</a></li>
				<li class="icn_edit_article"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=promo_view">Lista kodów promocyjnych</a></li>
			</ul>

			<hr>

			<h3>Ustawienia</h3>

			<ul class="toggle">
				<li class="icn_settings"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=site_settings">Ustawienia strony</a></li>
			</ul>

			<hr>

			<h3>Konto</h3>

			<ul class="toggle">
				<li class="icn_jump_back"><a href="<?php echo $setting['site_url']; ?>admin/index.php?cat=logout">Wyloguj się</a></li>
			</ul>

			<footer>
				<p><strong>Copyright &copy; 2018 centrumMTA.eu</strong></p>
				<p>Theme by <a href="http://www.medialoot.com">MediaLoot</a></p>
			</footer>

			<br />
			<br />
		</aside>

		<!-- content -->
		<?php
			$site = strip_tags(basename($_GET['cat']));

			if (!isset($site) or $site == 'dashboard' or $site == '') {
				include('cat/dashboard.php');
			} else {
				$file = 'cat/'. $site .'.php';

				if (file_exists($file)) {
					include($file);
				} else {
					include('cat/error.php');
				}
			}
		?>
	</body>
</html>