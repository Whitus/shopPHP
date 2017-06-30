<?php
	if (!$_SESSION['admin_username'])
	{
		return;
	}
?>

<section id="main" class="column">
	<?php
		$edit = htmlspecialchars(trim($_GET['edit']));

		if ($edit)
		{
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
					$query = $connect -> prepare('UPDATE cms_orders SET name = ?, description = ?, image_url = ?, download_url = ?, cost = ?, amount = ? WHERE id = ?');

					$query -> execute(
						array($name, $description, $image_url, $download_url, $cost, $amount, $edit)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<h4 class="alert_success">Pomyślnie zmieniłeś/aś produkt.</h4>';
					}
				}
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$query = $connect -> prepare('SELECT * FROM cms_orders WHERE id = ?');

			$query -> execute(
				array($edit)
			);
			
			if ($query -> rowCount() > 0)
			{
				foreach ($query as $var)
				{
					echo '
						<article class="module width_full">
							<header>
								<h3>EDYCJA PRODUKTU - '. $var['name'] .'</h3>
							</header>

							<form action="" method="post">
								<div class="module_content">
									<fieldset>
										<label>NAZWA PRODUKTU (WYMAGANE)</label>

										<input type="text" value="'. $var['name'] .'" name="name" />
									</fieldset>

									<fieldset>
										<label>OPIS PRODUKTU (WYMAGANE)</label>

										<textarea rows="12" name="description">'. $var['description'] .'</textarea>
									</fieldset>

									<fieldset>
										<label>ADRES OBRAZKA (WYMAGANE)</label>

										<input type="text" value="'. $var['image_url'] .'" name="image_url" />
									</fieldset>

									<fieldset>
										<label>ADRES DO POBRANIA (WYMAGANE)</label>

										<input type="text" value="'. $var['download_url'] .'" name="download_url" />
									</fieldset>

									<fieldset>
										<label>CENA (WYMAGANE)</label>

										<input type="text" value="'. $var['cost'] .'" name="cost" />
									</fieldset>

									<fieldset>
										<label>ILOŚĆ SZTUK (WYMAGANE)</label>

										<input type="text" value="'. $var['amount'] .'" name="amount" />
									</fieldset>
				
									<input type="submit" name="send" value="ZMIANA PRODUKTU" class="alt_btn">
								</div>
							</form>
						</article>
					';
				}
			}

			else

			{
				echo '<h4 class="alert_error">Nie znaleziono podanego wiersza w bazie danych.</h4>';
			}
		}

		////////////////////////////////////////////////////////////////////////////////////////////////////

		$delete = htmlspecialchars(trim($_GET['delete']));

		if ($delete)
		{
			$query = $connect -> prepare('SELECT * FROM cms_orders WHERE id = ?');

			$query -> execute(
				array($delete)
			);

			if ($query -> rowCount() > 0)
			{
				$query = $connect -> prepare('DELETE FROM cms_orders WHERE id = ?');

				$query -> execute(
					array($delete)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie usunęłeś/aś produkt.</h4>';
				}
			}

			else

			{
				echo '<h4 class="alert_error">Nie znaleziono podanego wiersza w bazie danych.</h4>';
			}
		}
	?>

	<article class="module width_full">
		<header>
			<h3>LISTA OPINII</h3>
		</header>

		<div class="tab_container">
			<table class="tablesorter" cellspacing="0">
				<thead>
					<tr>
   						<th class="header">ID</th>
    					<th class="header">NAZWA</th>
    					<th class="header">LINK DO OBRAZKA</th>
    					<th class="header">LINK DO POBRANIA</th>
    					<th class="header">KOSZT</th>
    					<th class="header">ILOŚĆ SZTUK</th>
    					<th class="header">AKCJE</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$query = $connect -> prepare('SELECT * FROM cms_orders');

						$query -> execute();

						if ($query -> rowCount() > 0)
						{
							foreach ($query as $var)
							{
								echo '
									<tr>
   										<td>'. $var['id'] .'</td>

    									<td>'. $var['name'] .'</td>

    									<td>'. $var['image_url'] .'</td>

    									<td>'. $var['download_url'] .'</td>

    									<td>'. $var['cost'] .' PLN</td>

    									<td>'. $var['amount'] .'</td>

    									<td>
    										<a href="'. $setting['site_url'] .'admin/index.php?cat=products_view&edit='. $var['id'] .'" title="Edycja"><img src="images/icn_edit.png"></a>
    									
    										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=products_view&delete='. $var['id'] .'" title="Usunięcie"><img src="images/icn_trash.png"></a>
    									</td>
									</tr>
								';
							}
						}

						else
						
						{
							echo '<tr><td colspan="4">Nie znaleziono wierszy w bazie danych.</td></tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</article>
</section>