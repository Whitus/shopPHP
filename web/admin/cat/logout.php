<?php
	if (!$_SESSION['admin_username'])
	{
		return;
	}
?>

<section id="main" class="column">
	<article class="module width_full">
		<header>
			<h3>Wylogowywanie</h3>
		</header>

		<div class="module_content">
			<?php
				if ($_SESSION['admin_username'])
				{
					unset($_SESSION['admin_username']);
				
					session_destroy();
				
					header('Refresh: 2; URL='. $setting['site_url'] .'admin/index.php');
				}
			?>

			<h4 class="alert_info">Trwa wylogowywanie. Proszę czekać ...</h4>
		</div>
	</article>
</section>