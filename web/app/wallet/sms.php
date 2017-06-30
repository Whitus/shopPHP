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
  $api['user_key'] = 'Twoje id użytkownika';
  $api['service_key'] = 'Twoje id usługi';
?>

<table class="table">
  <thead>
    <tr>
      <th width="100" style="text-align: center;">ID</th>
      <th width="200" style="text-align: center;">Numer</th>
      <th width="200" style="text-align: center;">Treść</th>
      <th width="200" style="text-align: center;">Koszt</th>
      <th width="200" style="text-align: center;">Doładowanie</th>
    </tr>
  </thead>
  
  <tbody>
    <?php
      $query = $connect -> prepare('SELECT id, number, contents, cost, wallet FROM cms_payments_list');
      
      $query -> execute();

      if ($query -> rowCount() > 0)
      {
        foreach ($query as $var) {
          echo '
            <tr>
              <td style="text-align: center; word-break: break-all;">'. $var['id'] .'</td>
              <td style="text-align: center; word-break: break-all;">'. $var['number'] .'</td>
              <td style="text-align: center; word-break: break-all;">'. $var['contents'] .'</td>
              <td style="text-align: center; word-break: break-all;">'. $var['cost'] .' PLN z VAT</td>
              <td style="text-align: center; word-break: break-all;">'. $var['wallet'] .' PLN</td>
            </tr>
          ';
        }
      }
      else
      {
        echo '
          <tr>
            <td style="text-align: center; word-break: break-all;" colspan="5">Nie znaleziono żadnych płatności SMS w bazie danych.</td>
          </tr>
        ';
      }
    ?>
  </tbody>
</table>

<hr>

<?php
  if ($_POST['send_sms'])
  {
    $code = htmlspecialchars(trim($_POST['code']));
    
    if (empty($code))
    {
      $error = true;
      
      echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie wpisałeś(aś) kodu zwrotnego.</div>';
    }
    
    if (!$error and !preg_match('/^[A-Za-z0-9]{8}$/', $code))
    {
      $error = true;
      
      echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Twój kod zwrotny posiada nieprawidłową wartość.</div>';
    }
    
    if (!$error)
    {
      $api = @file_get_contents('http://microsms.pl/api/v2/multi.php?userid='. $api['user_key'] .'&code='. $code .'&serviceid='. $api['service_key']);
    
      if (!$api)
      {
        $error = true;
      
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie można nawiązać połączenia z serwerem płatności.</div>';
      }
      
      if (!$error)
      {
        $api = json_decode($api);
    
        if (!$error and !is_object($api))
        {
          $error = true;
          
          echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie można odczytać informacji o płatności.</div>';
        }
        
        if (!$error and $api -> error)
        {
          $error = true;
          
          echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wystąpił nieznany błąd API: '. $api -> error -> message .'.</div>';
        }
        
        if (!$error and $api -> connect == FALSE)
        {
          $error = true;
          
          echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wystąpił nieznany błąd API: '. $api -> error -> message .'.</div>';
        }
        
        if (!$error and $api -> connect and $api -> connect == TRUE)
        {
          if ($api -> data -> status == 1)
          {
            $query = $connect -> prepare('SELECT * FROM cms_payments_list WHERE number=?');
            
            $query -> execute(
              array($api -> data -> number)
            );
            
            foreach ($query as $var)
            {
              $_SESSION['user_wallet'] = $_SESSION['user_wallet'] + $var['wallet'];
            }
            
            $query = $connect -> prepare('UPDATE cms_users SET wallet = ? WHERE username = ?');
            
            $query -> execute(
              array($_SESSION['user_wallet'], $_SESSION['user_login'])
            );
            
            if ($query -> rowCount() > 0)
            {
              echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie doładowałeś(aś) swoje konto. Masz aktualnie '. $_SESSION['user_wallet'] .' PLN.</div>';
              
              return;
            }
          }
          else
          {
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Podany kod jest nieprawidłowy lub został zużyty.</div>';
          }
        }
      }
    }
  }
?>

<form action="" method="post">
  <div class="form-group">
    <input type="text" name="code" class="form-control" placeholder="Kod zwrotny * ...">
  </div>
  
  <hr>
  
  <button type="submit" value="send_sms" name="send_sms" class="btn btn-primary">Doładuj konto</button>
</form>

<hr>

<center>
  Płatności zapewnia firma <a href="http://microsms.pl/">MicroSMS</a>. Korzystanie z serwisu jest jednozanczne z akceptacją <a href="http://microsms.pl/partner/documents/">regulaminów</a>. Jeśli nie dostałeś kodu zwrotnego w ciągu 30 minut skorzystaj z <a href="http://microsms.pl/customer/complaint/">formularza reklamacyjnego</a>.

  <br/>
  <br/>

  <img src="http://microsms.pl/public/cms/img/banner.png">
</center>