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
		<h3 class="panel-title">Lista Twoich zamówień</h3>
	</div>

	<div class="panel-body">
		<table class="table">
			<thead>
				<tr>
					<th width="100" style="text-align: center;">ID</th>
					<th width="300" style="text-align: center;">Zamówienie</th>
					<th width="300" style="text-align: center;">Akcje</th>
				</tr>
			</thead>

			<tbody>
				<?php
					if (!$_SESSION['user_login'])
					{
						echo '<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Nie posiadasz dostępu do tej sekcji. Nie jesteś zalogowany(a).</div>';
				
						return;
					}

					$query = $connect -> prepare('SELECT * FROM cms_orders_users WHERE username=?');

					$query -> execute(
						array($_SESSION['user_login'])
					);

					if ($query -> rowCount() > 0)
					{
						foreach ($query as $var)
						{
							$query = $connect -> prepare('SELECT * FROM cms_orders WHERE id=?');

							$query -> execute(
								array($var['order_id'])
							);

							if ($query -> rowCount() > 0)
							{
								foreach ($query as $var) {
									echo '
										<tr>
											<td style="text-align: center; word-break: break-all;">'. $var['id'] .'</td>
											<td style="text-align: center; word-break: break-all;">'. $var['name'] .'</td>

											<td style="text-align: center; word-break: break-all;">
												<a href="'. $var['download_url'] .'" class="btn btn-primary btn-sm">Pobierz</a>
												<a href="/forum" class="btn btn-primary btn-sm">Zgłoś bug</a>
											</td>
										</tr>
									';
								}
							}
							else
							{
								echo '<tr><td style="text-align: center; word-break: break-all;" colspan="4">Wystąpił błąd podczas pobierania zasobów z bazy danych. Zgłoś ten błąd administracji.</td></tr>';
							}
						}
					}
					else
					{
						echo '<tr><td style="text-align: center; word-break: break-all;" colspan="4">Nie posiadasz żadnych zakupionych zasobów.</td></tr>';
					}
				?>
			</tbody>
		</table>

		<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Obowiązuje całkowity zakaz udostępniania zasobów które zostały pobrane z tego sklepu.</div>
	</div>
</div>