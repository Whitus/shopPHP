<?php
  /**********************************************************************************
   *****
   *****    Name: Centrum MTA - CMS
   *****    Author: Szymon Orzeł (oszymon018@gmail.com)
   *****
   *****    Copyright (c) 2018 Szymon Orzeł (oszymon018@gmail.com)
   *****
  /**********************************************************************************/
?>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Dodawanie reklamy</h3>
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
      $advert['cost'] = 3.53;
    ?>

    <?php
      $send = htmlspecialchars(trim($_POST['send']));

      if ($send)
      {
        $site_url = htmlspecialchars(trim($_POST['site_url']));
        $image_url = htmlspecialchars(trim($_POST['image_url']));

        if (empty($site_url) or empty($image_url))
        {
          $error = true;

          echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Wypełnij wymagane pola formularza oznaczone gwiazdką (*).</div>';
        }

        if (!$error and $_SESSION['user_wallet'] < $advert['cost'])
        {
          $error = true;

          echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Nie posiadasz wystarczającej ilości gotówki w wirtualnej skarbonce.</div>';
        }

        if (!$error)
        {
          $query = $connect -> prepare('INSERT INTO cms_ads (site_url, image_url, username, end_time) VALUES (?, ?, ?, TIMESTAMPADD(DAY, 30, NOW()))');

          $query -> execute(
            array($site_url, $image_url, $_SESSION['user_login'])
          );

          if ($query -> rowCount() > 0)
          {
            $query = $connect -> prepare('UPDATE cms_users SET wallet = wallet - ? WHERE username = ?');

            $query -> execute(
              array($advert['cost'], $_SESSION['user_login'])
            );

            if ($query -> rowCount() > 0)
            {
              echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pomyślnie dodałeś(aś) swoją reklamę na stronę główną. Z Twojej wirtualnej skarbonki została pobrana kwota '. $advert['cost'] .' PLN.</div>';

              $_SESSION['user_wallet'] = $_SESSION['user_wallet'] - $advert['cost'];

              return;
            }
          }
        }
      }
    ?>

    <div class="alert alert-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> W tym miejscu możesz dodać reklamę na stronę główną. Po kliknięciu przycisku "Dodaj reklamę" zostanie pobrana z Twojej wirtualnej skarbonki kwota <?php echo $advert['cost']; ?> PLN.</div>

    <form action="" method="post">
      <div class="form-group">
        <input type="text" name="site_url" class="form-control" placeholder="http://licencja-og.ct8.pl/">
      </div>

      <br />

      <div class="form-group">
        <input type="text" name="image_url" class="form-control" placeholder="http://licencja-og.ct8.pl/obrazek.png">
      </div>

      <hr />

      <button type="submit" value="send" name="send" class="btn btn-primary">Dodaj reklamę</button>
    </form>
  </div>
</div>