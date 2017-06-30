<?php
	if (!$_SESSION['admin_username'])
	{
		return;
	}
?>

<section id="main" class="column">
	<?php
		$send = htmlspecialchars(trim($_POST['send']));

		if ($send)
		{
			$site_url = htmlspecialchars(trim($_POST['site_url']));
			$image_url = htmlspecialchars(trim($_POST['image_url']));

			if (empty($site_url) or empty($image_url))
			{
				$error = true;

				echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
			}

			if (!$error)
			{
				$query = $connect -> prepare('INSERT INTO cms_ads (site_url, image_url, username, end_time) VALUES (?, ?, ?, TIMESTAMPADD(DAY, 30, NOW()))');

				$query -> execute(
					array($site_url, $image_url, $_SESSION['admin_username'])
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie dodałeś/aś reklamę na stronę główną.</h4>';
				}
			}
		}
	?>

	<article class="module width_full">
		<header>
			<h3>Dodawanie reklamy</h3>
		</header>

		<form action="" method="post">
			<div class="module_content">
				<fieldset>
					<label>Adres strony (wymagane)</label>

					<input type="text" name="site_url" />
				</fieldset>

				<fieldset>
					<label>Adres obrazka (wymagane)</label>

					<input type="text" name="image_url" />
				</fieldset>
				
				<input type="submit" name="send" value="Dodaj reklamę" class="alt_btn">
			</div>
		</form>
	</article>
</section>