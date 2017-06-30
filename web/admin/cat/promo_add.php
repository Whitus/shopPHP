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
			$code = htmlspecialchars(trim($_POST['code']));
			$wallet = htmlspecialchars(trim($_POST['wallet']));
			$amount = htmlspecialchars(trim($_POST['amount']));

			if (empty($code) or empty($wallet) or empty($amount))
			{
				$error = true;

				echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
			}

			if (!$error)
			{
				$query = $connect -> prepare('SELECT * FROM cms_promo_codes WHERE code = ?');

				$query -> execute(
					array(
						$code
					)
				);

				if ($query -> rowCount() > 0)
				{
					$error = true;

					echo '<h4 class="alert_error">Podany kod już istnieje w bazie danych.</h4>';
				}

				if (!$error)
				{
					$query = $connect -> prepare('INSERT INTO cms_promo_codes (code, wallet, amount) VALUES (?, ?, ?)');

					$query -> execute(
						array($code, $wallet, $amount)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<h4 class="alert_success">Pomyślnie dodałeś/aś kod promocyjny.</h4>';
					}
				}
			}
		}
	?>

	<article class="module width_full">
		<header>
			<h3>Dodawanie kodu promocyjnego</h3>
		</header>

		<form action="" method="post">
			<div class="module_content">
				<fieldset>
					<label>Kod:</label>

					<input type="text" name="code" />
				</fieldset>

				<fieldset>
					<label>Kwota:</label>

					<input type="text" value="5" name="wallet" />
				</fieldset>

				<fieldset>
					<label>Ilość:</label>

					<input type="text" value="10" name="amount" />
				</fieldset>

				<input type="submit" name="send" value="Dodaj kod promocyjny" class="alt_btn">
			</div>
		</form>
	</article>
</section>