<?php
  // tworzenie nowej sesji
  session_start();

  // łączenie się z bazą danych
  include('engine/config.php');
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $setting['site_name']; ?></title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- navigation -->
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><?php echo $setting['site_name']; ?></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <!-- left menu -->
          <ul class="nav navbar-nav">
            <li><a href="<?php echo $setting['site_url']; ?>index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Strona główna</a>
            <li><a href="<?php echo $setting['site_url']; ?>index.php?app=opinie"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Opinie</a>
            <li><a href="<?php echo $setting['site_url']; ?>index.php?app=rules"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Regulamin</a>
          </ul>

          <!-- right menu -->
          <?php
            include('engine/user.php');
          ?>
        </div>
      </div>
    </nav>

    <!-- home -->
    <div class="container">
      <!-- ads -->
      <?php
        include('engine/ads.php');
      ?>
      
      <!-- left panel -->
      <div style="float: left; width: 25%;">
        <?php
          include('engine/left_menu.php');
        ?>
      </div>

      <!-- right panel -->
      <div style="float: right; width: 70%;">
        <?php
          $site = strip_tags(basename($_GET['app']));

          if (!isset($site) or $site == 'home' or $site == '')
          {
            include('app/home.php');
          }

          else

          {
            $file = 'app/'. $site .'.php';

            if (file_exists($file))
            {
              include($file);
            }

            else

            {
              include('app/error.php');
            }
          }
        ?>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>