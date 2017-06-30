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
    <h3 class="panel-title">Wylogowywanie ...</h3>
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
      if ($_SESSION['user_login'] or $_SESSION['user_wallet'])
      {
        unset($_SESSION['user_login']);

        unset($_SESSION['user_first_name']);
        unset($_SESSION['user_last_name']);

        unset($_SESSION['user_wallet']);
        
        session_destroy();
      }
    ?>
  
    Trwa wylogowywanie. Proszę czekać ...
  </div>
</div>