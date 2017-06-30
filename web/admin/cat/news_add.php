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
			$title = htmlspecialchars(trim($_POST['title']));
			$description = htmlspecialchars(trim($_POST['description']));

			if (empty($title) or empty($description))
			{
				$error = true;

				echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
			}

			if (!$error)
			{
				$query = $connect -> prepare('INSERT INTO cms_news (title, description, author) VALUES (?, ?, ?)');

				$query -> execute(
					array($title, $description, $_SESSION['admin_username'])
				);

				if ($query -> rowCount() > 0)
					echo '<h4 class="alert_success">Pomyślnie dodałeś/aś artykuł na stronę główną.</h4>';
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
					<label>Tytuł artykułu (wymagane):</label>

					<input type="text" name="title" />
				</fieldset>

				<fieldset>
					<label>Treść artykułu (wymagane):</label>

					<textarea rows="12" name="description"></textarea>
				</fieldset>
				
				<input type="submit" name="send" value="Dodaj artykuł" class="alt_btn">
			</div>
		</form>
	</article>
</section>