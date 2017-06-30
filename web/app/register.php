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
		<h3 class="panel-title">Panel rejestracji</h3>
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
			if ($_POST['send'])
			{
				$username = htmlspecialchars(trim($_POST['username']));
				$email = htmlspecialchars(trim($_POST['email']));
				$password = htmlspecialchars(trim($_POST['password']));
				$repeat_password = htmlspecialchars(trim($_POST['repeat_password']));

				$first_name = htmlspecialchars(trim($_POST['first_name']));
				$last_name = htmlspecialchars(trim($_POST['last_name']));

				$rules = htmlspecialchars(trim($_POST['rules']));
				
				if (!$error and empty($username) or empty($email) or empty($password) or empty($repeat_password))
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wypełnij wymagane pola formularza oznaczone gwiazdką (*).</div>';
				}
				
				if (!$error and empty($rules))
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie zaakceptowałeś(aś) regulaminu serwisu.</div>';
				}
				
				$sql = $connect -> prepare('SELECT * FROM cms_users WHERE username = ?');
				
				$sql -> execute(
					array($username)
				);

				if (!$error and $sql -> rowCount() > 0)
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Podany użytkownik już istnieje w naszej bazie.</div>';
				}
				
				if (!$error and !filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Twój email ma nieprawidłowy format.</div>';
				}
				
				$sql = $connect -> prepare('SELECT * FROM cms_users WHERE email = ?');
				
				$sql -> execute(
					array($email)
				);

				if (!$error and $sql -> rowCount() > 0)
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Pod tym adresem email jest już zarejestrowana osoba.</div>';
				}
				
				if (!$error and $password != $repeat_password)
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Podane hasła nie zgadzają się.</div>';
				}
				
				if (!$error) {
					$sql = $connect -> prepare('INSERT INTO cms_users (username, email, password, first_name, last_name) VALUES (?, ?, SHA2(?, 512), ?, ?)');
					
					$sql -> execute(
						array($username, $email, $password, $first_name, $last_name)
					);
					
					if ($sql -> rowCount() > 0)
					{
						$code = str_shuffle('qwertyuiopasdfghjklzxcvbnm1234567890');
						
						$sql = $connect -> prepare('INSERT INTO cms_activation_codes (username, code) VALUES (?, ?)');
						
						$sql -> execute(
							array($username, $code)
						);
						
						if ($sql -> rowCount() > 0)
						{
							$page = 'Reply-to: admin@licencja-og.ct8.pl <admin@licencja-og.ct8.pl>'. PHP_EOL;
							$page .= 'From: admin@licencja-og.ct8.pl <admin@licencja-og.ct8.pl>'. PHP_EOL;
							$page .= 'Content-type: text/html; charset=utf-8r'. PHP_EOL;

							$title = 'Aktywacja konta na - '. $setting['site_name'];

							$description = '
								<html>
									<head>
										<title>Aktywacja konta na - '. $setting['site_name'] .'</title>
									</head>

									<body>
										Witaj '. $username .', dziękujemy za rejestrację.

										<br />
										<br />

										Aby aktywować konto na '. $setting['site_name'] .' musisz odwiedzić poniższy link:
										- <a href="'. $setting['site_url'] .'index.php?app=register&active_user='. $username .'&active_code='. $code .'">'. $setting['site_url'] .'index.php?app=register&active_user='. $username .'&active_code='. $code .'</a>

										<br />
										<br />

										Pozdrawiamy, administracja strony.
									</body>
								</html>
							';
							
							if (mail($email, $title, $description, $page))
							{
								echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Dziękujemy za rejestrację. Na podany adres email został wysłany link, za pomocą którego można dokonać aktywacji konta. Jeżeli wiadomość nie została wysłana odczekaj do 24 godzin lub sprawdź czy nie znajduje się przypadkiem w zakładce Spam. W razie problemów skontaktuj się z administracją strony.</div>';
								
								return;
							}
						}
						else
						{
							echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wystąpił nieznany błąd, powiadom administratora.</div>';
							
							return;
						}
					}
					else
					{
						echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wystąpił nieznany błąd, powiadom administratora.</div>';
						
						return;
					}
				}
			}
			else
			{
				$active_user = htmlspecialchars(trim($_GET['active_user']));
				$active_code = htmlspecialchars(trim($_GET['active_code']));

				if ($active_user or $active_code)
				{
					$sql = $connect -> prepare('SELECT * FROM cms_activation_codes WHERE username = ? AND code = ?');
					
					$sql -> execute(
						array($active_user, $active_code)
					);
					
					if ($sql -> rowCount() > 0)
					{
						$sql = $connect -> prepare('UPDATE cms_users SET active = ? WHERE username = ? AND active = ?');
						
						$sql -> execute(
							array('1', $active_user, '0')
						);
						
						if ($sql -> rowCount() > 0)
						{
							echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Konto zostało aktywowane, aby się zalogować przejdź <a href="'. $setting['site_url'] .'index.php?app=login">tutaj</a>.</div>';
							
							return;
						}
						else
						{
							echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wystąpił nieznany błąd, powiadom administratora.</div>';
							
							return;
						}
					}
					else
					{
						echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wystąpił nieznany błąd, powiadom administratora.</div>';
						
						return;
					}
				}
			}
		?>

		<form action="" method="post">
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Nazwa użytkownika * ...">
			</div>

			<br />

			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="Adres email * ...">
			</div>

			<br />

			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Hasło * ...">
			</div>

			<br />

			<div class="form-group">
				<input type="password" name="repeat_password" class="form-control" placeholder="Powtórz hasło * ...">
			</div>

			<hr>

			<div class="form-group">
				<input type="text" name="first_name" class="form-control" placeholder="Imię ...">
			</div>

			<br />

			<div class="form-group">
				<input type="text" name="last_name" class="form-control" placeholder="Nazwisko ...">
			</div>

			<hr>

			<div class="form-group">
				<input type="checkbox" name="rules"> &nbsp; Wyrażam zgodę na przetwarzanie moich danych osobowych oraz zapoznałem(am) się z regulaminem serwisu.
			</div>

			<hr>

			<button type="submit" value="send" name="send" class="btn btn-primary">Załóż konto</button>
		</form>
	</div>
</div>