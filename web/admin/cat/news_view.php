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
				$title = htmlspecialchars(trim($_POST['title']));
				$description = htmlspecialchars(trim($_POST['description']));

				if (empty($title) or empty($description))
				{
					$error = true;

					echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
				}

				if (!$error)
				{
					$query = $connect -> prepare('UPDATE cms_news SET title = ?, description = ? WHERE id = ?');

					$query -> execute(
						array($title, $description, $edit)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<h4 class="alert_success">Pomyślnie zmieniłeś/aś artykuł na stronie głównej.</h4>';
					}
				}
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$query = $connect -> prepare('SELECT * FROM cms_news WHERE id = ?');

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
								<h3>EDYCJA NEWSA O ID '. $var['id'] .'</h3>
							</header>

							<form action="" method="post">
								<div class="module_content">
									<fieldset>
										<label>Tytuł artykułu (wymagane):</label>

										<input type="text" value="'. $var['title'] .'" name="title" />
									</fieldset>

									<fieldset>
										<label>Treść artykułu (wymagane):</label>

										<textarea rows="12" name="description">'. $var['description'] .'</textarea>
									</fieldset>
				
									<input type="submit" name="send" value="Zmień artykuł" class="alt_btn">
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
			$query = $connect -> prepare('SELECT * FROM cms_news WHERE id = ?');

			$query -> execute(
				array($delete)
			);

			if ($query -> rowCount() > 0)
			{
				$query = $connect -> prepare('DELETE FROM cms_news WHERE id = ?');

				$query -> execute(
					array($delete)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie usunęłeś/aś artykuł ze strony głównej.</h4>';
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
			<h3>Lista artykułów</h3>
		</header>

		<div class="tab_container">
			<table class="tablesorter" cellspacing="0">
				<thead>
					<tr>
   						<th class="header">ID</th>
    					<th class="header">TYTUŁ</th>
    					<th class="header">AUTOR</th>
    					<th class="header">DATA DODANIA</th>
    					<th class="header">AKCJE</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$query = $connect -> prepare('SELECT * FROM cms_news');

						$query -> execute();

						if ($query -> rowCount() > 0)
						{
							foreach ($query as $var)
							{
								echo '
									<tr>
   										<td>'. $var['id'] .'</td>

    									<td>'. $var['title'] .'</td>

    									<td>'. $var['author'] .'</td>

    									<td>'. $var['added'] .'</td>

    									<td>
    										<a href="'. $setting['site_url'] .'admin/index.php?cat=news_view&edit='. $var['id'] .'" title="Edycja"><img src="images/icn_edit.png"></a>
    									
    										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=news_view&delete='. $var['id'] .'" title="Usunięcie"><img src="images/icn_trash.png"></a>
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