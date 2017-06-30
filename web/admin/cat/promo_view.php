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
					$query = $connect -> prepare('UPDATE cms_promo_codes SET code = ?, wallet = ?, amount = ? WHERE id = ?');

					$query -> execute(
						array($code, $wallet, $amount, $edit)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<h4 class="alert_success">Pomyślnie zmieniłeś/aś kod promocyjny.</h4>';
					}
				}
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$query = $connect -> prepare('SELECT * FROM cms_promo_codes WHERE id = ?');

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
								<h3>Edycja kodu promocyjnego - '. $var['code'] .'</h3>
							</header>

							<form action="" method="post">
								<div class="module_content">
									<fieldset>
										<label>Kod:</label>

										<input type="text" value="'. $var['code'] .'" name="code" />
									</fieldset>

									<fieldset>
										<label>Kwota:</label>

										<input type="text" value="'. $var['wallet'] .'" name="wallet" />
									</fieldset>

									<fieldset>
										<label>Ilość:</label>

										<input type="text" value="'. $var['amount'] .'" name="amount" />
									</fieldset>

									<input type="submit" name="send" value="Zmień kod promocyjny" class="alt_btn">
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

		/**************************************************************************************************/

		$delete = htmlspecialchars(trim($_GET['delete']));

		if ($delete)
		{
			$query = $connect -> prepare('SELECT * FROM cms_promo_codes WHERE id = ?');

			$query -> execute(
				array($delete)
			);

			if ($query -> rowCount() > 0)
			{
				$query = $connect -> prepare('DELETE FROM cms_promo_codes WHERE id = ?');

				$query -> execute(
					array($delete)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie usunęłeś/aś kod promocyjny.</h4>';
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
			<h3>Lista kodów promocyjnych</h3>
		</header>

		<div class="tab_container">
			<table class="tablesorter" cellspacing="0">
				<thead>
					<tr>
   						<th class="header">ID</th>
    					<th class="header">Kod</th>
    					<th class="header">Kwota</th>
    					<th class="header">Ilość</th>
    					<th class="header">Dodany</th>
    					<th class="header">Akcje</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$query = $connect -> prepare('SELECT * FROM cms_promo_codes');

						$query -> execute();

						if ($query -> rowCount() > 0)
						{
							foreach ($query as $var)
							{
								echo '
									<tr>
   										<td>'. $var['id'] .'</td>

    									<td>'. $var['code'] .'</td>

    									<td>'. $var['wallet'] .'</td>

    									<td>'. $var['amount'] .'</td>

    									<td>'. $var['added'] .'</td>

    									<td>
    										<a href="'. $setting['site_url'] .'admin/index.php?cat=promo_view&edit='. $var['id'] .'" title="Edycja"><img src="images/icn_edit.png"></a>

    										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=promo_view&delete='. $var['id'] .'" title="Usunięcie"><img src="images/icn_trash.png"></a>
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