<?php
	if (!$_SESSION['admin_username'])
	{
		return;
	}
?>

<section id="main" class="column">
	<article class="module width_full">
		<header>
			<h3>Błąd</h3>
		</header>

		<div class="module_content">
			<h4 class="alert_error">Wystąpił błąd. Nie znaleziono podanej strony.</h4>
		</div>
	</article>
</section>