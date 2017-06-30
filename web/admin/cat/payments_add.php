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
			$number = htmlspecialchars(trim($_POST['number']));
			$contents = htmlspecialchars(trim($_POST['contents']));
			$cost = htmlspecialchars(trim($_POST['cost']));
			$wallet = htmlspecialchars(trim($_POST['wallet']));

			if (empty($number) or empty($contents) or empty($cost) or empty($wallet))
			{
				$error = true;

				echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
			}

			if (!$error and !is_numeric($number) or !is_numeric($cost) or !is_numeric($wallet)) {
				$error = true;

				echo '<h4 class="alert_error">Numer, koszt i gotówka do portfela muszą być w formacie liczby.</h4>';
			}

			if (!$error)
			{
				$query = $connect -> prepare('INSERT INTO cms_payments_list (number, contents, cost, wallet) VALUES (?, ?, ?, ?)');

				$query -> execute(
					array($number, $contents, $cost, $wallet)
				);

				if ($query -> rowCount() > 0)
					echo '<h4 class="alert_success">Pomyślnie dodałeś/aś płatność SMS.</h4>';
			}
		}
	?>

	<article class="module width_full">
		<header>
			<h3>Dodawanie płatności SMS</h3>
		</header>

		<form action="" method="post">
			<div class="module_content">
				<fieldset>
					<label>Numer (wymagane)</label>

					<input type="text" name="number" />
				</fieldset>

				<fieldset>
					<label>Treść (wymagane)</label>

					<input type="text" name="contents" />
				</fieldset>

				<fieldset>
					<label>Cena (wymagane)</label>

					<input type="text" name="cost" />
				</fieldset>

				<fieldset>
					<label>Gotówka do portfela (wymagane)</label>

					<input type="text" name="wallet" />
				</fieldset>
				
				<input type="submit" name="send" value="Dodaj płatność SMS" class="alt_btn">
			</div>
		</form>
	</article>
</section>