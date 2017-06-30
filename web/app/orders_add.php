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
		<h3 class="panel-title">Nowe zamówienie</h3>
	</div>

	<div class="panel-body">
		<?php
			if (!$_SESSION['user_login'])
			{
				echo '<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Nie posiadasz dostępu do tej sekcji. Nie jesteś zalogowany(a).</div>';
				
				return;
			}
		?>

		<?php
			$id = htmlspecialchars(trim($_GET['id']));

			if ($id)
			{
				$query = $connect -> prepare('SELECT * FROM cms_orders WHERE id=?');
				
				$query -> execute(
					array($id)
				);

				foreach ($query as $var)
				{
					$query = $connect -> prepare('SELECT * FROM cms_orders_users WHERE order_id=? AND username=?');

					$query -> execute(
						array($id, $_SESSION['user_login'])
					);

					if ($query -> rowCount() > 0)
					{
						$error = true;

						echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Już posiadasz zakupioną tą usługę. Aby nią zarządzać przejdź do listy zamówień.</div>';
					}

					$query = $connect -> prepare('SELECT * FROM cms_orders WHERE id=? AND amount=0');

					$query -> execute(
						array($id)
					);

					if (!$error and $query -> rowCount() > 0)
					{
						$error = true;

						echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Aktualnie nie ma dostępnych zamówień w naszej bazie.</div>';
					}

					if (!$error and $_SESSION['user_wallet'] < $var['cost'])
					{
						$error = true;

						echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie posiadasz wystarczającej ilości gotówki w wirtualnej skarbonce.</div>';
					}

					if (!$error)
					{
						$query = $connect -> prepare('UPDATE cms_orders SET amount = amount - 1 WHERE id = ?');
						
						$query -> execute(
							array($var['id'])
						);

						if ($query -> rowCount() > 0)
						{
							$query = $connect -> prepare('INSERT INTO cms_orders_users (order_id, username) VALUES (?, ?)');
							
							$query -> execute(
								array($var['id'], $_SESSION['user_login'])
							);

							if ($query -> rowCount() > 0)
							{
								$query = $connect -> prepare('UPDATE cms_users SET wallet = wallet - ? WHERE username = ?');

								$query -> execute(
									array($var['cost'], $_SESSION['user_login'])
								);

								if ($query -> rowCount() > 0)
								{
									echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie zakupiłeś/aś zasób. Z Twojej wirtualnej skarbonki została pobrana kwota '. $var['cost'] .' PLN. Aby zarządzać tym zamówieniem przejdź do listy zamówień.</div>';

									$_SESSION['user_wallet'] = $_SESSION['user_wallet'] - $var['cost'];

									return;
								}
							}
						}
					}
				}
			}
		?>

		<?php
			$query = $connect -> prepare('SELECT * FROM cms_orders');

			$query -> execute();

			if ($query -> rowCount() > 0)
			{
				echo '
					<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Aktualizacja zasobów jest co 72 godziny. Po kliknięciu w przycisk "Kup zasób" zostanie pobrana kwota z Twojej wirtualnej skarbonki a następnie zostanie udzielony dostęp do zakupionego zasobu.</div>

					<div class="row">
				';

				foreach ($query as $var)
				{
					echo '
						<div class="col-sm-6 col-md-6">

							<div class="thumbnail">
								<a href="'. $var['image_url'] .'">
									<img src="'. $var['image_url'] .'" width="500" height="200" alt="Nie wczytano obrazka" />
								</a>

								<div class="caption">
									<h3>'. $var['name'] .'</h3>

									<p>'. nl2br($var['description']) .'</p>

									<hr>

									<p>Cena: '. $var['cost'] .' PLN</p>

									<hr>

									<p>Pozostała ilość sztuk: '. $var['amount'] .'</p>

									<hr>

									<p>
										<a href="'. $setting['site_url'] .'index.php?app=orders_add&id='. $var['id'] .'" class="btn btn-primary">Kup zasób</a>
									</p>
								</div>
							</div>
						</div>
					';
				}
			}
			else
			{
				echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie znaleziono żadnych produktów w naszej bazie.</div>';
			}

			echo '</div>';
		?>
	</div>
</div>