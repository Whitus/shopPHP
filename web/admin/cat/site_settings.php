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
			$site_name = htmlspecialchars(trim($_POST['site_name']));

			if (empty($site_url) or empty($site_name))
			{
				$error = true;

				echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
			}

			if (!$error)
			{
				$query = $connect -> prepare('UPDATE cms_settings SET url = ?, name = ?');

				$query -> execute(
					array($site_url, $site_name)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie zmieniłeś/aś ustawienia.</h4>';
				}
			}
		}

		$query = $connect -> prepare('SELECT * FROM cms_settings');

		$query -> execute();

		foreach ($query as $var)
		{
			echo '
				<article class="module width_full">
					<header>
						<h3>Ustawienia strony</h3>
					</header>

					<form action="" method="post">
						<div class="module_content">
							<fieldset>
								<label>Adres strony (wymagane)</label>

								<input type="text" value="'. $var['url'] .'" name="site_url" />
							</fieldset>

							<fieldset>
								<label>Nazwa strony (wymagane)</label>

								<input type="text" value="'. $var['name'] .'" name="site_name" />
							</fieldset>
				
							<input type="submit" name="send" value="Zmień ustawienia" class="alt_btn">
						</div>
					</form>
				</article>
			';
		}
	?>
</section>