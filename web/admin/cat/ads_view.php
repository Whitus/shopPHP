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
				$site_url = htmlspecialchars(trim($_POST['site_url']));
				$image_url = htmlspecialchars(trim($_POST['image_url']));

				if (empty($site_url) or empty($image_url))
				{
					$error = true;

					echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
				}

				if (!$error)
				{
					$query = $connect -> prepare('UPDATE cms_ads SET site_url = ?, image_url = ? WHERE id = ?');

					$query -> execute(
						array($site_url, $image_url, $edit)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<h4 class="alert_success">Pomyślnie zmieniłeś/aś reklamę.</h4>';
					}
				}
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$query = $connect -> prepare('SELECT * FROM cms_ads WHERE id = ?');

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
								<h3>Edycja reklamy - '. $var['id'] .'</h3>
							</header>

							<form action="" method="post">
								<div class="module_content">
									<fieldset>
										<label>Adres strony (wymagane)</label>

										<input type="text" value="'. $var['site_url'] .'" name="site_url" />
									</fieldset>

									<fieldset>
										<label>Adres obrazka (wymagane)</label>

										<input type="text" value="'. $var['image_url'] .'" name="image_url" />
									</fieldset>
				
									<input type="submit" name="send" value="Zmień reklamę" class="alt_btn">
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
			$query = $connect -> prepare('SELECT * FROM cms_ads WHERE id = ?');

			$query -> execute(
				array($delete)
			);

			if ($query -> rowCount() > 0)
			{
				$query = $connect -> prepare('DELETE FROM cms_ads WHERE id = ?');

				$query -> execute(
					array($delete)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie usunęłeś/aś reklamę.</h4>';
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
			<h3>Lista reklam</h3>
		</header>

		<div class="tab_container">
			<table class="tablesorter" cellspacing="0">
				<thead>
					<tr>
   						<th class="header">ID</th>
    					<th class="header">Adres strony</th>
    					<th class="header">Adres obrazka</th>
    					<th class="header">Dodał</th>
    					<th class="header">Aktywne do dnia</th>

    					<th class="header">Akcje</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$query = $connect -> prepare('SELECT * FROM cms_ads');

						$query -> execute();

						if ($query -> rowCount() > 0)
						{
							foreach ($query as $var)
							{
								echo '
									<tr>
   										<td># '. $var['id'] .'</td>

    									<td>'. $var['site_url'] .'</td>

    									<td>'. $var['image_url'] .'</td>

    									<td>'. $var['username'] .'</td>

    									<td>'. $var['end_time'] .'</td>

    									<td>
    										<a href="'. $setting['site_url'] .'admin/index.php?cat=ads_view&edit='. $var['id'] .'" title="Edycja"><img src="images/icn_edit.png"></a>
    									
    										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=ads_view&delete='. $var['id'] .'" title="Usunięcie"><img src="images/icn_trash.png"></a>
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