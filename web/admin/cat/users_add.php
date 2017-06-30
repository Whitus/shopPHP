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
			$username = htmlspecialchars(trim($_POST['username']));
			$email = htmlspecialchars(trim($_POST['email']));
			$password = htmlspecialchars(trim($_POST['password']));

			$first_name = htmlspecialchars(trim($_POST['first_name']));
			$last_name = htmlspecialchars(trim($_POST['last_name']));

			////////////////////////////////////////////////////////////////////////////////////////////////////

			if (empty($username) or empty($email) or empty($password))
			{
				$error = true;

				echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$sql = $connect -> prepare('SELECT * FROM cms_users WHERE username = ?');
				
			$sql -> execute(
				array($username)
			);

			if (!$error and ($sql -> rowCount()) > 0)
			{
				$error = true;

				echo '<h4 class="alert_error">Podany użytkownik już istnieje w bazie danych.</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////

			if (!$error and !filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$error = true;

				echo '<h4 class="alert_error">Adres e-mail posiada nieprawidłowy format.</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////

			$sql = $connect -> prepare('SELECT * FROM cms_users WHERE email = ?');
				
			$sql -> execute(
				array($email)
			);

			if (!$error and ($sql -> rowCount()) > 0)
			{
				$error = true;

				echo '<h4 class="alert_error">Pod tym adresem e-mail jest już zarejestrowana osoba.</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////

			if (!$error)
			{
				$sql = $connect -> prepare('INSERT INTO cms_users (username, email, password, first_name, last_name, active) VALUES (?, ?, SHA2(?, 512), ?, ?, 1)');
					
				$sql -> execute(
					array($username, $email, $password, $first_name, $last_name)
				);

				if (($sql -> rowCount()) > 0)
				{
					$sql = $connect -> prepare('INSERT INTO cms_activation_codes (username, code) VALUES (?, ?)');

					$sql -> execute(
						array($username, 'utworzone_przez_acp')
					);

					if (($sql -> rowCount()) > 0)
					{
						echo '<h4 class="alert_success">Pomyślnie utworzono konto użytkownikowi.</h4>';
					}
				}
			}
		}
	?>

	<article class="module width_full">
		<header>
			<h3>Dodawanie użytkownika</h3>
		</header>

		<form action="" method="post">
			<div class="module_content">
				<fieldset>
					<label>NAZWA UŻYTKOWNIKA (WYMAGANE)</label>

					<input type="text" name="username" />
				</fieldset>

				<fieldset>
					<label>ADRES E-MAIL (WYMAGANE)</label>

					<input type="text" name="email" />
				</fieldset>

				<fieldset>
					<label>HASŁO (WYMAGANE)</label>

					<input type="text" name="password" />
				</fieldset>

				<fieldset>
					<label>IMIĘ (NIE WYMAGANE)</label>

					<input type="text" name="first_name" />
				</fieldset>

				<fieldset>
					<label>NAZWISKO (NIE WYMAGANE)</label>

					<input type="text" name="last_name" />
				</fieldset>
				
				<input type="submit" name="send" value="Dodaj użytkownika" class="alt_btn">
			</div>
		</form>
	</article>
</section>