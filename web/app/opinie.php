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
		<h3 class="panel-title">Opinie</h3>
	</div>

	<div class="panel-body">
		<table class="table">
			<thead>
				<tr>
					<th width="100" style="text-align: center;">ID</th>
					<th width="200" style="text-align: center;">Treść</th>
					<th width="400" style="text-align: center;">Użytkownik</th>
					<th width="200" style="text-align: center;">Data</th>
				</tr>
			</thead>

			<tbody>
				<?php
					$query = $connect -> prepare('SELECT * FROM cms_opinie WHERE status = 1 LIMIT 5');
					
					$query -> execute();

					if ($query -> rowCount() > 0)
					{
						foreach ($query as $var)
						{
							echo '
								<tr>
									<td style="text-align: center; word-break: break-all;">'. $var['id'] .'</td>
									<td style="text-align: center; word-break: break-all;">'. $var['description'] .'</td>
									<td style="text-align: center; word-break: break-all;">'. $var['username'] .'</td>
									<td style="text-align: center; word-break: break-all;">'. $var['added'] .'</td>
								</tr>
							';
						}
					}
					else
					{
						echo '
							<tr>
								<td style="text-align: center; word-break: break-all;" colspan="4">Nie znaleziono żadnych opinii w bazie danych.</td>
							</tr>
						';
					}
				?>
			</tbody>
		</table>

		<?php
			if (!$_SESSION['user_login'])
			{
				echo '<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Aby dodać opinię musisz być zalogowany(a).</div>';
				
				return;
			}
		?>

		<?php
			$query = $connect -> prepare('SELECT * FROM cms_opinie WHERE username = ?');

			$query -> execute(
				array($_SESSION['user_login'])
			);

			if ($query -> rowCount() > 0)
			{
				echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Już dodałeś(aś) opinię na temat serwisu.</div>';
				
				return;
			}
		?>

		<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Twoja opinia przed dodaniem zostanie sprawdzona przez administratora strony.</div>

		<?php
			$send = htmlspecialchars(trim($_POST['send']));

			if ($send)
			{
				$description = htmlspecialchars(trim($_POST['description']));
				
				if (empty($description))
				{
					$error = true;

					echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie uzupełniłeś(aś) treści opinii.</div>';
				}

				if (!$error)
				{
					$query = $connect -> prepare('INSERT INTO cms_opinie (username, description) VALUES (?, ?)');

					$query -> execute(
						array($_SESSION['user_login'], $description)
					);

					if ($query -> rowCount() > 0)
					{
						echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie dodałeś(aś) opinię na temat strony. Do 24 godzin zostanie ona sprawdzona przez administratora i jeżeli będzie ona zgodna z regulaminem strony zostanie ona zatwierdzona.</div>';
					}
				}
			}
		?>

		<form action="" method="post">
			<div class="form-group">
				<textarea class="form-control" name="description" rows="5" placeholder="Wprowadź treść opinii (maksymalnie 150 znaków) ..." maxlength="150"></textarea>
			</div>

			<hr>

			<button type="submit" value="send" name="send" class="btn btn-primary">Dodaj opinię</button>
		</form>
	</div>
</div>