<?php
	if ($_SESSION['admin_username'])
	{
		return;
	}
?>
	
<section id="main" class="column">
	<?php
		if ($_POST['send'])
		{
			$username = htmlspecialchars(trim($_POST['username']));
			$password = htmlspecialchars(trim($_POST['password']));

			////////////////////////////////////////////////////////////////////////////////////////////////////
				
			if (empty($username) or empty($password))
			{
				$error = true;

				echo '<h4 class="alert_error">Wypełnij wymagane pola formularza oznaczone gwiazdką (*).</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
				
			$sql = $connect -> prepare('SELECT * FROM cms_admins WHERE username = ? AND level > 0');
				
			$sql -> execute(
				array($username)
			);

			if (!$error and ($sql -> rowCount()) == 0)
			{
				$error = true;

				echo '<h4 class="alert_error">Brak dostępu.</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
				
			$sql = $connect -> prepare('SELECT * FROM cms_admins WHERE username = ? AND password = ?');
				
			$sql -> execute(
				array($username, sha1($password))
			);

			if (!$error and ($sql -> rowCount()) == 0)
			{
				$error = true;

				echo '<h4 class="alert_error">Brak dostępu.</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
				
			if (!$error)
			{
				$sql = $connect -> prepare('SELECT * FROM cms_admins WHERE username = ?');
					
				$sql -> execute(
					array($username)
				);

				foreach ($sql as $get)
				{
					$_SESSION['admin_username'] = $get['username'];
				}
					
				header('Refresh: 2; URL='. $setting['site_url'] .'admin/index.php?cat=dashboard');
					
				echo '<h4 class="alert_success">Pomyślnie zalogowałeś/aś się. Za chwilę zostaniesz przeniesiony(a) do panelu administracji.</h4>';
			}
		}
	?>

	<h4 class="alert_info">Wpisz poniżej swoje dane aby przejść dalej.</h4>

	<article class="module width_full">
		<header>
			<h3>Logowanie do ACP</h3>
		</header>

		<div class="module_content">
			<form action="" method="post">
				<!-- username -->
				<fieldset>
					<label>Nazwa użytkownika *</label>
					<input type="text" name="username">
				</fieldset>

				<!-- password -->
				<fieldset>
					<label>Hasło *</label>
					<input type="text" name="password">
				</fieldset>

				<!-- submit -->
				<input type="submit" name="send" value="Zaloguj się" class="alt_btn">
			</form>
		</div>
	</div>
</section>