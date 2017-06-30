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
			$name = htmlspecialchars(trim($_POST['name']));
			$description = htmlspecialchars(trim($_POST['description']));
			$image_url = htmlspecialchars(trim($_POST['image_url']));
			$download_url = htmlspecialchars(trim($_POST['download_url']));
			$cost = htmlspecialchars(trim($_POST['cost']));
			$amount = htmlspecialchars(trim($_POST['amount']));

			if (empty($name) or empty($description) or empty($image_url) or empty($download_url) or empty($cost) or empty($amount))
			{
				$error = true;

				echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
			}

			if (!$error and !is_numeric($cost))
			{
				$error = true;

				echo '<h4 class="alert_error">Koszt musi zawierać liczbę.</h4>';
			}

			if (!$error and !is_numeric($amount))
			{
				$error = true;

				echo '<h4 class="alert_error">Ilość sztuk musi zawierać liczbę.</h4>';
			}

			if (!$error)
			{
				$query = $connect -> prepare('INSERT INTO cms_orders (name, description, image_url, download_url, cost, amount) VALUES (?, ?, ?, ?, ?, ?)');

				$query -> execute(
					array($name, $description, $image_url, $download_url, $cost, $amount)
				);

				if ($query -> rowCount() > 0)
					echo '<h4 class="alert_success">Pomyślnie dodałeś/aś produkt.</h4>';
			}
		}
	?>

	<article class="module width_full">
		<header>
			<h3>Dodawanie artykułu</h3>
		</header>

		<form action="" method="post">
			<div class="module_content">
				<fieldset>
					<label>NAZWA PRODUKTU (WYMAGANE)</label>

					<input type="text" name="name" />
				</fieldset>

				<fieldset>
					<label>OPIS PRODUKTU (WYMAGANE)</label>

					<textarea rows="12" name="description"></textarea>
				</fieldset>

				<fieldset>
					<label>ADRES OBRAZKA (WYMAGANE)</label>

					<input type="text" name="image_url" />
				</fieldset>

				<fieldset>
					<label>ADRES DO POBRANIA (WYMAGANE)</label>

					<input type="text" name="download_url" />
				</fieldset>

				<fieldset>
					<label>CENA (WYMAGANE)</label>

					<input type="text" value="5" name="cost" />
				</fieldset>

				<fieldset>
					<label>ILOŚĆ SZTUK (WYMAGANE)</label>

					<input type="text" value="10" name="amount" />
				</fieldset>
				
				<input type="submit" name="send" value="DODAJ PRODUKT" class="alt_btn">
			</div>
		</form>
	</article>
</section>