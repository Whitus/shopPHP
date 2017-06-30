<?php
  /**********************************************************************************
   *****
   *****    Name: Centrum MTA - CMS
   *****
   *****    Copyright (c) 2018 .WhiteBlue (oszymon018@gmail.com)
   *****
  /**********************************************************************************/
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Lista Twoich reklam</h3>
	</div>

	<div class="panel-body">
		<?php
			if (!$_SESSION['user_login'])
			{
				echo '<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Nie posiadasz dostępu do tej sekcji. Nie jesteś zalogowany(a).</div>';
				
				return;
			}
		?>

		<?php
			$advert['cost'] = 3.53;
		?>

		<table class="table">
			<thead>
				<tr>
					<th width="100" style="text-align: center;">ID</th>
					<th width="200" style="text-align: center;">Adres strony</th>
					<th width="200" style="text-align: center;">Adres obrazka</th>
					<th width="300" style="text-align: center;">Wygaśnie</th>
					<th width="300" style="text-align: center;">Akcje</th>
				</tr>
			</thead>

			<tbody>
				<?php
					$query = $connect -> prepare('SELECT * FROM cms_ads WHERE username = ?');
					
					$query -> execute(
						array($_SESSION['user_login'])
					);

					if ($query -> rowCount() > 0)
					{
						foreach ($query as $var)
						{
							echo '
								<tr>
									<td style="text-align: center; word-break: break-all;">'. $var['id'] .'</td>
									<td style="text-align: center; word-break: break-all;">'. $var['site_url'] .'</td>
									<td style="text-align: center; word-break: break-all;">'. $var['image_url'] .'</td>
									<td style="text-align: center; word-break: break-all;">'. $var['end_time'] .'</td>

									<td style="text-align: center; word-break: break-all;">
										<a href="'. $setting['site_url'] .'index.php?app=ads_list&edit='. $var['id'] .'" class="btn btn-primary btn-sm">Edytuj</a>
										<a href="'. $setting['site_url'] .'index.php?app=ads_list&delete='. $var['id'] .'" class="btn btn-danger btn-sm">Usuń</a>
										<a href="'. $setting['site_url'] .'index.php?app=ads_list&extende='. $var['id'] .'" class="btn btn-primary btn-sm">Przedłuż</a>
									</td>
								</tr>
							';
						}
					}
					else
					{
						echo '
							<tr>
								<td style="text-align: center; word-break: break-all;" colspan="5">Nie znaleziono żadnych Twoich reklam w bazie danych.</td>
							</tr>
						';
					}
				?>
			</tbody>
		</table>

		<hr>

		<?php
			$edit = htmlspecialchars(trim($_GET['edit']));

			if ($edit)
			{
				$send = htmlspecialchars(trim($_POST['send']));

				if ($send) {
					$site_url = htmlspecialchars(trim($_POST['site_url']));
					$image_url = htmlspecialchars(trim($_POST['image_url']));

					if (empty($site_url) or empty($image_url))
					{
						echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wypełnij wymagane pola formularza oznaczone gwiazdką (*).</div>';

						return;
					}

					$query = $connect -> prepare('UPDATE cms_ads SET site_url = ?, image_url = ? WHERE id = ? AND username = ?');

					$query -> execute(
						array($site_url, $image_url, $edit, $_SESSION['user_login'])
					);

					if ($query -> rowCount() > 0)
					{
						echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie zmieniłeś(aś) dane reklamy.</div>';

						header('Refresh: 2; URL='. $setting['site_url'] .'index.php?app=ads_list');

						return;
					}
				}

				// ****************************************************************************** //

				$query = $connect -> prepare('SELECT * FROM cms_ads WHERE id = ? AND username = ?');

				$query -> execute(
					array($edit, $_SESSION['user_login'])
				);

				if ($query -> rowCount() == 0)
				{
					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie znaleziono podanej reklamy w naszej bazie lub nie jesteś jej właścicielem(właścicielką).</div>';

					return;
				}

				// ****************************************************************************** //

				$query = $connect -> prepare('SELECT * FROM cms_ads WHERE id = ? AND username = ?');

				$query -> execute(
					array($edit, $_SESSION['user_login'])
				);

				foreach ($query as $var)
				{
					echo '
						<form action="" method="post">
							<div class="form-group">
								<input type="text" name="site_url" class="form-control" value="'. $var['site_url'] .'" placeholder="Adres strony * ...">
							</div>

							<br />

							<div class="form-group">
								<input type="text" name="image_url" class="form-control" value="'. $var['image_url'] .'" placeholder="Adres obrazka * ...">
							</div>

							<hr />

							<button type="submit" value="send" name="send" class="btn btn-primary">Zmień dane</button>
						</form>
					';
				}
			}

			// ****************************************************************************** //

			$delete = htmlspecialchars(trim($_GET['delete']));

			if ($delete)
			{
				$query = $connect -> prepare('SELECT * FROM cms_ads WHERE id = ? AND username = ?');

				$query -> execute(
					array($delete, $_SESSION['user_login'])
				);

				if ($query -> rowCount() == 0)
				{
					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie znaleziono podanej reklamy w naszej bazie lub nie jesteś jej właścicielem(właścicielką).</div>';

					return;
				}

				$query = $connect -> prepare('DELETE FROM cms_ads WHERE id = ? AND username = ?');

				$query -> execute(
					array($delete, $_SESSION['user_login'])
				);

				if ($query -> rowCount() > 0)
				{
					echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie usunąłeś swoją reklamę.</div>';

					header('Refresh: 2; URL='. $setting['site_url'] .'index.php?app=ads_list');

					return;
				}
			}

			// ****************************************************************************** //

			$extende = htmlspecialchars(trim($_GET['extende']));

			if ($extende)
			{
				$send = htmlspecialchars(trim($_POST['send']));

				if ($send)
				{
					if ($_SESSION['user_wallet'] and $_SESSION['user_wallet'] < $advert['cost'])
					{
						$error = true;

						echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie posiadasz wystarczającej ilości gotówki w wirtualnej skarbonce.</div>';
					}

					if (!$error)
					{
						$query = $connect -> prepare('UPDATE cms_ads SET end_time = TIMESTAMPADD(DAY, 30, end_time) WHERE id = ? AND username = ?');

						$query -> execute(
							array($extende, $_SESSION['user_login'])
						);

						if ($query -> rowCount() > 0)
						{
							$query = $connect -> prepare('UPDATE cms_users SET wallet = wallet - ? WHERE username = ?');

							$query -> execute(
								array($advert['cost'], $_SESSION['user_login'])
							);

							if ($query -> rowCount() > 0)
							{
								echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie przedłużyłeś(aś) swoją reklamę na 30 dni. Z Twojej wirtualnej skarbonki została pobrana kwota '. $advert['cost'] .' PLN.</div>';

								$_SESSION['user_wallet'] = $_SESSION['user_wallet'] - $advert['cost'];

								header('Refresh: 2; URL='. $setting['site_url'] .'index.php?app=ads_list');

								return;
							}
						}
					}
				}

				// ****************************************************************************** //

				$query = $connect -> prepare('SELECT * FROM cms_ads WHERE id = ? AND username = ?');

				$query -> execute(
					array($extende, $_SESSION['user_login'])
				);

				if ($query -> rowCount() == 0)
				{
					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie znaleziono podanej reklamy w naszej bazie lub nie jesteś jej właścicielem(właścicielką).</div>';

					return;
				}

				// ****************************************************************************** //

				echo '
					<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Klikając przycisk "Potwierdzam przedłużenie". Jesteś świadomy że z Twojej wirtualnej skarbonki zostanie pobrana kwota '. $advert['cost'] .' PLN oraz że zostanie przedłużona reklama o ID: '. $extende .' na 30 dni.</div>

					<form action="" method="post">
						<button type="submit" value="send" name="send" class="btn btn-primary">Potwierdzam przedłużenie</button>
					</form>
				';
			}
		?>
	</div>
</div>