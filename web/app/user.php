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
		<h3 class="panel-title">Konto</h3>
	</div>

	<div class="panel-body">
		<?php
			if (!$_SESSION['user_login'])
			{
				echo '<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Nie posiadasz dostępu do tej sekcji. Nie jesteś zalogowany(a).</div>';
				
				return;
			}
		?>

		<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> W tym miejscu możesz zmienić swoje hasło oraz adres email.</div>

		<?php
			$send = htmlspecialchars(trim($_POST['send_password']));

			if ($send)
			{
				$old_password = htmlspecialchars(trim($_POST['old_password']));
				$new_password = htmlspecialchars(trim($_POST['new_password']));
				$repeat_password = htmlspecialchars(trim($_POST['repeat_password']));

				if (empty($old_password) or empty($new_password) or empty($repeat_password))
				{
					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wypełnij wymagane pola formularza oznaczone gwiazdką (*).<br><br><a href="'. $setting['site_url'] .'index.php?app=user">Wróć</a></div>';

					return;
				}

				// ******************************************************************************************** //

				$query = $connect -> prepare('SELECT * FROM cms_users WHERE username = ? AND password = SHA2(?, 512)');

				$query -> execute(
					array(
						$_SESSION['user_login'],
						$old_password
					)
				);

				if ($query -> rowCount() == 0)
				{
					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Twoje stare hasło jest nieprawidłowe.<br><br><a href="'. $setting['site_url'] .'index.php?app=user">Wróć</a></div>';

					return;
				}

				// ******************************************************************************************** //

				if ($new_password != $repeat_password)
				{
					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Twoje nowe hasła nie zgadzają się.<br><br><a href="'. $setting['site_url'] .'index.php?app=user">Wróć</a></div>';

					return;
				}

				// ******************************************************************************************** //

				$query = $connect -> prepare('UPDATE cms_users SET password = SHA2(?, 512) WHERE username = ?');

				$query -> execute(
					array(
						$new_password,
						$_SESSION['user_login']
					)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Twoje aktualne hasło zostało zaktualizowane.<br><br><a href="'. $setting['site_url'] .'index.php?app=home">Strona główna</a></div>';

					return;
				}
			}
		?>

		<div class="panel panel-default">
			<div class="panel-body">
				<form action="" method="post">
					<div class="form-group">
						<input type="password" name="old_password" class="form-control" placeholder="Aktualne hasło * ...">
					</div>

					<br />

					<div class="form-group">
						<input type="password" name="new_password" class="form-control" placeholder="Nowe hasło * ...">
					</div>

					<br />

					<div class="form-group">
						<input type="password" name="repeat_password" class="form-control" placeholder="Potwierdź nowe hasło * ...">
					</div>

					<hr />

					<button type="submit" value="send_password" name="send_password" class="btn btn-primary">Zmiana hasła</button>
				</form>
			</div>
		</div>
	</div>
</div>