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
					$query = $connect -> prepare('UPDATE cms_payments_list SET number = ?, contents = ?, cost = ?, wallet = ? WHERE id = ?');

					$query -> execute(
						array($number, $contents, $cost, $wallet, $edit)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<h4 class="alert_success">Pomyślnie zmieniłeś/aś płatność SMS.</h4>';
					}
				}
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$query = $connect -> prepare('SELECT * FROM cms_payments_list WHERE id = ?');

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
								<h3>Edycja płatności SMS - '. $var['id'] .'</h3>
							</header>

							<form action="" method="post">
								<div class="module_content">
									<fieldset>
										<label>Numer (wymagane)</label>

										<input type="text" value="'. $var['number'] .'" name="number" />
									</fieldset>

									<fieldset>
										<label>Treść (wymagane)</label>

										<input type="text" value="'. $var['contents'] .'" name="contents" />
									</fieldset>

									<fieldset>
										<label>Cena (wymagane)</label>

										<input type="text" value="'. $var['cost'] .'" name="cost" />
									</fieldset>

									<fieldset>
										<label>Gotówka do portfela (wymagane)</label>

										<input type="text" value="'. $var['wallet'] .'" name="wallet" />
									</fieldset>
				
									<input type="submit" name="send" value="Zmień płatność SMS" class="alt_btn">
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
			$query = $connect -> prepare('SELECT * FROM cms_payments_list WHERE id = ?');

			$query -> execute(
				array($delete)
			);

			if ($query -> rowCount() > 0)
			{
				$query = $connect -> prepare('DELETE FROM cms_payments_list WHERE id = ?');

				$query -> execute(
					array($delete)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie usunęłeś/aś płatność SMS.</h4>';
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
			<h3>Lista płatności SMS</h3>
		</header>

		<div class="tab_container">
			<table class="tablesorter" cellspacing="0">
				<thead>
					<tr>
   						<th class="header">ID</th>
    					<th class="header">Number</th>
    					<th class="header">Treść</th>
    					<th class="header">Cena</th>
    					<th class="header">Gotówka do portfela</th>

    					<th class="header">Akcje</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$query = $connect -> prepare('SELECT * FROM cms_payments_list');

						$query -> execute();

						if ($query -> rowCount() > 0)
						{
							foreach ($query as $var)
							{
								echo '
									<tr>
   										<td># '. $var['id'] .'</td>

    									<td>'. $var['number'] .'</td>

    									<td>'. $var['contents'] .'</td>

    									<td>'. $var['cost'] .' PLN</td>

    									<td>'. $var['wallet'] .' PLN</td>

    									<td>
    										<a href="'. $setting['site_url'] .'admin/index.php?cat=payments_view&edit='. $var['id'] .'" title="Edycja"><img src="images/icn_edit.png"></a>
    									
    										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=payments_view&delete='. $var['id'] .'" title="Usunięcie"><img src="images/icn_trash.png"></a>
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