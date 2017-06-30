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
		<h3 class="panel-title">Doładowanie swojego konta</h3>
	</div>

	<div class="panel-body">
		<?php
			if (!$_SESSION['user_login'])
			{
				echo '<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Nie posiadasz dostępu do tej sekcji. Nie jesteś zalogowany(a).</div>';
				
				return;
			}
		?>
		
		<script>
			function showElement(item) {
				// sms
				if (item == 'sms')
				{
					sms.style.display = 'block';
					sms.style.visibility = 'visible';
				}
				else
				{
					sms.style.display = 'none';
					sms.style.visibility = 'hidden';
				}

				// przelew
				if (item == 'przelew')
				{
					przelew.style.display = 'block';
					przelew.style.visibility = 'visible';
				}
				else
				{
					przelew.style.display = 'none';
					przelew.style.visibility = 'hidden';
				}

				// kod promocyjny
				if (item == 'code')
				{
					code.style.display = 'block';
					code.style.visibility = 'visible';
				}
				else
				{
					code.style.display = 'none';
					code.style.visibility = 'hidden';
				}
			}
		</script>
		
		<div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Wybierz poniżej opcję doładowania i postępuj zgodnie z dalszymi instrukcjami.</div>
		
		<!-- wallet options -->
		<div class="form-group">
			<select class="form-control" onchange="java_script_:showElement(this.options[this.selectedIndex].value)">
				<option selected disabled>Wybierz opcję doładowania ...</option>

				<option disabled></option>
				
				<option value="sms">Doładowanie: SMS</option>
				<option value="przelew">Doładowanie: Przelew</option>

				<option disabled></option>

				<option value="code">Doładowanie: Kod Promocyjny</option>
			</select>
		</div>
		
		<!-- sms -->
		<div id="sms" <?php if (!$_POST['send_sms']) echo 'style="display: none;"'; else echo 'style="display: block;"'; ?>>
			<?php
				include('wallet/sms.php');
			?>
		</div>
		
		<!-- przelew -->
		<div id="przelew" <?php if (!$_POST['send_przelew']) echo 'style="display: none;"'; else echo 'style="display: block;"'; ?>>
			<?php
				include('wallet/przelew.php');
			?>
		</div>

		<!-- kod promocyjny -->
		<div id="code" <?php if (!$_POST['send_code']) echo 'style="display: none;"'; else echo 'style="display: block;"'; ?>>
			<?php
				include('wallet/code.php');
			?>
		</div>
	</div>
</div>