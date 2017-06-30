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
				$username = htmlspecialchars(trim($_POST['username']));
				$email = htmlspecialchars(trim($_POST['email']));

				$first_name = htmlspecialchars(trim($_POST['first_name']));
				$last_name = htmlspecialchars(trim($_POST['last_name']));

				$wallet = htmlspecialchars(trim($_POST['wallet']));

				////////////////////////////////////////////////////////////////////////////////////////////////////

				if (empty($username) or empty($email))
				{
					$error = true;

					echo '<h4 class="alert_error">Wypełnij wymagane pola formularza.</h4>';
				}

				////////////////////////////////////////////////////////////////////////////////////////////////////

				if (!$error and !filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$error = true;

					echo '<h4 class="alert_error">Adres e-mail posiada nieprawidłowy format.</h4>';
				}

				////////////////////////////////////////////////////////////////////////////////////////////////////

				if (!$error)
				{
					$sql = $connect -> prepare('UPDATE cms_users SET username = ?, email = ?, first_name = ?, last_name = ?, wallet = ? WHERE id = ?');
					
					$sql -> execute(
						array($username, $email, $first_name, $last_name, $wallet, $edit)
					);

					if ($sql -> rowCount() > 0)
						echo '<h4 class="alert_success">Pomyślnie zmieniono konto użytkownikowi.</h4>';
				}
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$query = $connect -> prepare('SELECT * FROM cms_users WHERE id = ?');

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
								<h3>EDYCJA UŻYTKOWNIKA '. $var['username'] .'</h3>
							</header>

							<form action="" method="post">
								<div class="module_content">
									<fieldset>
										<label>NAZWA UŻYTKOWNIKA (WYMAGANE)</label>

										<input type="text" value="'. $var['username'] .'" name="username" />
									</fieldset>

									<fieldset>
										<label>ADRES E-MAIL (WYMAGANE)</label>

										<input type="text" value="'. $var['email'] .'" name="email" />
									</fieldset>

									<fieldset>
										<label>IMIĘ (NIE WYMAGANE)</label>

										<input type="text" value="'. $var['first_name'] .'" name="first_name" />
									</fieldset>

									<fieldset>
										<label>NAZWISKO (NIE WYMAGANE)</label>

										<input type="text" value="'. $var['last_name'] .'" name="last_name" />
									</fieldset>

									<fieldset>
										<label>GOTÓWKA (NIE WYMAGANE)</label>

										<input type="text" value="'. $var['wallet'] .'" name="wallet" />
									</fieldset>
				
									<input type="submit" name="send" value="Zmień użytkownika" class="alt_btn">
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
			$query = $connect -> prepare('SELECT * FROM cms_users WHERE id = ?');

			$query -> execute(
				array($delete)
			);

			if ($query -> rowCount() > 0)
			{
				$query = $connect -> prepare('DELETE FROM cms_users WHERE id = ?');

				$query -> execute(
					array($delete)
				);

				if ($query -> rowCount() > 0)
				{
					echo '<h4 class="alert_success">Pomyślnie usunęłeś/aś użytkownika.</h4>';
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
			$query = $connect -> prepare('SELECT * FROM cms_users WHERE id = ? AND active = 1');

			$query -> execute(
				array($active)
			);

			if ($query -> rowCount() > 0)
			{
				$error = true;

				echo '<h4 class="alert_error">Podane konto jest już aktywowane.</h4>';
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////

			if (!$error)
			{
				$query = $connect -> prepare('UPDATE cms_users SET active = 1 WHERE id = ?');

				$query -> execute(
					array($active)
				);

				if ($query -> rowCount() > 0) 
					echo '<h4 class="alert_success">Konto zostało aktywowane.</h4>';
			}
		}
	?>

	<article class="module width_full">
		<header>
			<h3>Lista użytkowników</h3>
		</header>

		<div class="tab_container">
			<table class="tablesorter" cellspacing="0">
				<thead>
					<tr>
   						<th class="header">ID</th>
    					<th class="header">NAZWA UŻYTKOWNIKA</th>
    					<th class="header">ADRES EMAIL</th>
    					<th class="header">IMIĘ</th>
    					<th class="header">NAZWISKO</th>
    					<th class="header">GOTÓWKA</th>
    					<th class="header">STATUS</th>
    					<th class="header">ZAREJESTROWANY</th>
    					<th class="header">AKCJE</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						$query = $connect -> prepare('SELECT * FROM cms_users');

						$query -> execute();

						if ($query -> rowCount() > 0)
						{
							foreach ($query as $var)
							{
								echo '
									<tr>
   										<td>'. $var['id'] .'</td>

    									<td>'. $var['username'] .'</td>

    									<td>'. $var['email'] .'</td>

    									<td>'. $var['first_name'] .'</td>

    									<td>'. $var['last_name'] .'</td>

    									<td>'. $var['wallet'] .'</td>

    							';

    									if ($var['active'] == 0) { echo '<td>Nie Aktywne</td>'; }
    									if ($var['active'] == 1) { echo '<td>Aktywne</td>'; }

    							echo'
    									<td>'. $var['added'] .'</td>

    									<td>
    										<a href="'. $setting['site_url'] .'admin/index.php?cat=users_view&edit='. $var['id'] .'" title="Edycja"><img src="images/icn_edit.png"></a>
    									
    										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=users_view&delete='. $var['id'] .'" title="Usunięcie"><img src="images/icn_trash.png"></a>

    										&nbsp;

    										<a href="'. $setting['site_url'] .'admin/index.php?cat=users_view&active='. $var['id'] .'" title="Aktywacja konta"><img src="images/icn_user.png"></a>
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