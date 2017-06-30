<?php
  /**********************************************************************************
   *****
   *****    Name: Centrum MTA - CMS
   *****
   *****    Copyright (c) 2018 .WhiteBlue (oszymon018@gmail.com)
   *****
  /**********************************************************************************/
?>

<?php if (!$_SESSION['user_login']) { return; } ?>

<?php
	$send = htmlspecialchars(trim($_POST['send_code']));

	if ($send)
	{
		$code = htmlspecialchars(trim($_POST['code']));

		if (empty($code))
		{
			echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wypełnij wymagane pola formularza oznaczone gwiazdką (*).<br><br><a href="'. $setting['site_url'] .'index.php?app=wallet">Wróć</a></div>';

			return;
		}

		// ******************************************************************************************** //
		$query = $connect -> prepare('SELECT * FROM cms_promo_codes WHERE code = ?');

		$query -> execute(
			array(
				$code
			)
		);

		if ($query -> rowCount() == 0)
		{
			echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Podany kod nie istnieje w naszej bazie danych.<br><br><a href="'. $setting['site_url'] .'index.php?app=wallet">Wróć</a></div>';

			return;
		}

		// ******************************************************************************************** //

		$query = $connect -> prepare('SELECT * FROM cms_promo_codes WHERE code = ? AND amount == 0');

		$query -> execute(
			array(
				$code
			)
		);

		if ($query -> rowCount() > 0)
		{
			echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Podany kod został już wykorzystany.<br><br><a href="'. $setting['site_url'] .'index.php?app=wallet">Wróć</a></div>';

			return;
		}

		// ******************************************************************************************** //

		$query = $connect -> prepare('SELECT * FROM cms_promo_codes WHERE code = ?');

		$query -> execute(
			array(
				$code
			)
		);

		foreach ($query as $var)
		{
			$query = $connect -> prepare('SELECT * FROM cms_promo_codes_users WHERE code = ? AND username = ?');

			$query -> execute(
				array(
					$code,
					$_SESSION['user_login']
				)
			);

			if ($query -> rowCount() > 0)
			{
				echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Już użyłeś(aś) tego kodu.<br><br><a href="'. $setting['site_url'] .'index.php?app=wallet">Wróć</a></div>';

				return;
			}

			// ******************************************************************************************** //

			$query = $connect -> prepare('UPDATE cms_promo_codes SET amount = amount - 1 WHERE code = ?');

			$query -> execute(
				array(
					$code
				)
			);

			if ($query -> rowCount() > 0)
			{
				$query = $connect -> prepare('INSERT INTO cms_promo_codes_users (code, username) VALUES (?, ?)');

				$query -> execute(
					array(
						$code,
						$_SESSION['user_login']
					)
				);

				if ($query -> rowCount() > 0)
				{
					$_SESSION['user_wallet'] = $_SESSION['user_wallet'] + $var['wallet'];

					// ******************************************************************************************** //
					$query = $connect -> prepare('UPDATE cms_users SET wallet = ? WHERE username = ?');

					$query -> execute(
						array(
							$_SESSION['user_wallet'],
							$_SESSION['user_login'],
						)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie doładowałeś(aś) swoje konto kodem promocyjnym o kwocie '. $var['wallet'] .' PLN. Twój aktualny stan konta wynosi '. $_SESSION['user_wallet'] .' PLN.<br><br><a href="'. $setting['site_url'] .'index.php?app=home">Strona główna</a></div>';

						return;
					}
				}
			}
		}
	}
?>

<form action="" method="post">
	<div class="form-group">
		<input type="text" name="code" class="form-control" placeholder="Kod promocyjny * ...">
	</div>

	<hr>

	<button type="submit" value="send_code" name="send_code" class="btn btn-primary">Sprawdź kod</button>
</form>