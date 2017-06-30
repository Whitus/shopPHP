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
		<h3 class="panel-title">Logowanie</h3>
	</div>

	<div class="panel-body">
		<?php
			if ($_SESSION['user_login'])
			{
				echo '<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Nie posiadasz dostępu do tej sekcji. Jesteś już zalogowany(a).</div>';
				
				return;
			}
		?>
		
		<?php
			if ($_POST['send']) {
				$username = htmlspecialchars(trim($_POST['username']));
				$password = htmlspecialchars(trim($_POST['password']));
				
				if (empty($username) or empty($password))
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wypełnij wymagane pola formularza oznaczone gwiazdką (*).</div>';
				}
				
				$query = $connect -> prepare('SELECT * FROM cms_users WHERE username = ?');
				
				$query -> execute(
					array($username)
				);

				if (!$error and $query -> rowCount() == 0)
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie znaleziono podanego użytkownika w naszej bazie.</div>';
				}
				
				$query = $connect -> prepare('SELECT * FROM cms_users WHERE username = ? AND password = SHA2(?, 512)');
				
				$query -> execute(
					array($username, $password)
				);

				if (!$error and $query -> rowCount() == 0)
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Podałeś(aś) nieprawidłowe dane logowania.</div>';
				}
				
				$query = $connect -> prepare('SELECT * FROM cms_users WHERE username = ? AND active = ?');
				
				$query -> execute(
					array($username, '1')
				);

				if (!$error and $query -> rowCount() == 0)
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Konto nie jest aktywne. Aby aktywować konto sprawdź swojego emaila.</div>';
				}
				
				if (!$error)
				{
					$query = $connect -> prepare('SELECT * FROM cms_users WHERE username = ?');
					
					$query -> execute(
						array($username)
					);

					foreach ($query as $var)
					{
						$_SESSION['user_login'] = $var['username'];

						$_SESSION['user_first_name'] = $var['first_name'];
						$_SESSION['user_last_name'] = $var['last_name'];

						$_SESSION['user_wallet'] = $var['wallet'];
					}
					
					header('Refresh: 2; URL='. $setting['site_url'] .'index.php');
					
					echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie zalogowałeś(aś) się. Za chwilę zostaniesz przeniesiony(a) na stronę główną.</div>';

					return;
				}
			}
		?>

		<form action="" method="post">
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Nazwa użytkownika * ...">
			</div>

			<br />

			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Hasło * ...">
			</div>

			<hr>

			<button type="submit" value="send" name="send" class="btn btn-primary">Zaloguj się</button>
		</form>
	</div>
</div>