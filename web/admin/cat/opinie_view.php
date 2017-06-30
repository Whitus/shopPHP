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
				$description = htmlspecialchars(trim($_POST['description']));

				if (empty($description))
				{
					$error = true;

					echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
				}

				if (!$error)
				{
					$query = $connect -> prepare('UPDATE cms_opinie SET description = ? WHERE id = ?');

					$query -> execute(
						array($description, $edit)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<h4 class="alert_success">Pomyślnie zmieniłeś/aś opinię.</h4>';
					}
				}
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$query = $connect -> prepare('SELECT * FROM cms_opinie WHERE id = ?');

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
								<h3>EDYCJA OPINII O ID '. $var['id'] .'</h3>
							</header>

							<form action="" method="post">
								<div class="module_content">
									<fieldset>
										<label>TREŚĆ OPINII (WYMAGANE)</label>

										<textarea rows="12" name="description">'. $var['description'] .'</textarea>
									</fieldset>
				
									<input type="submit" name="send" value="Zmień opinię" class="alt_btn">
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
			$query = $connect -> prepare('SELECT * FROM cms_opinie WHERE id = ?');

			$query -> execute(
				array($delete)
			);

			if ($query -> rowCount() > 0)
			{
				$query = $connect -> prepare('DELETE FROM cms_opinie WHERE id = ?');

				$query -> execute(
					array($delete)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie usunęłeś/aś opinię.</h4>';
				}
			}

			else

			{
				echo '<h4 class="alert_error">Nie znaleziono podanego wiersza w bazie danych.</h4>';
			}
		}

		////////////////////////////////////////////////////////////////////////////////////////////////////

		$active = htmlspecialchars(trim($_GET['active']));

		if ($active)
		{
			$query = $connect -> prepare('SELECT * FROM cms_opinie WHERE id = ? AND status = 1');

			$query -> execute(
				array($active)
			);

			if ($query -> rowCount() > 0)
			{
				$error = true;

				echo '<h4 class="alert_error">Podana opinia jest już aktywna.</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////

			if (!$error)
			{
				$query = $connect -> prepare('UPDATE cms_opinie SET status = 1 WHERE id = ?');

				$query -> execute(
					array($active)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Opinia została aktywowana.</h4>';
				}
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
    					<th class="header">TREŚĆ</th>
    					<th class="header">AUTOR</th>
    					<th class="header">DATA DODANIA</th>
    					<th class="header">AKCJE</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$query = $connect -> prepare('SELECT * FROM cms_opinie');

						$query -> execute();

						if ($query -> rowCount() > 0)
						{
							foreach ($query as $var)
							{
								echo '
									<tr>
   										<td>'. $var['id'] .'</td>

    									<td>'. $var['description'] .'</td>

    									<td>'. $var['username'] .'</td>

    									<td>'. $var['added'] .'</td>

    									<td>
    										<a href="'. $setting['site_url'] .'admin/index.php?cat=opinie_view&edit='. $var['id'] .'" title="Edycja"><img src="images/icn_edit.png"></a>
    									
    										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=opinie_view&delete='. $var['id'] .'" title="Usunięcie"><img src="images/icn_trash.png"></a>

       										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=opinie_view&active='. $var['id'] .'" title="Aktywacja"><img src="images/icn_user.png"></a>
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