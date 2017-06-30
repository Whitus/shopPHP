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
	<div class="panel-body" style="text-align: center;">
		
		<marquee scrollamount="10" onmouseover="this.stop()" onmouseout="this.start()">
			<?php
				$query = $connect -> prepare('SELECT * FROM cms_ads WHERE end_time > NOW()');
				$query -> execute();

				if ($query -> rowCount() > 0)
				{
					foreach ($query as $var)
					{
						echo '<a href="'. $var['site_url'] .'"><img src="'. $var['image_url'] .'" alt="Obrazek nie został wczytany" width="460" height="60" /></a>';
					}
				}

				else

				{
					echo 'Nie znaleziono żadnych reklam. Reklamę możesz dodać w <a href="http://centrum-mta.eu/shop/?app=ads_add">tym</a> miejscu.';
				}
			?>
		</marquee>

	</div>
</div>