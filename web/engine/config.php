<?php
  /**********************************************************************************
   *****
   *****    Name: Centrum MTA - CMS
   *****
   *****    Copyright (c) 2018 .WhiteBlue (oszymon018@gmail.com)
   *****
  /**********************************************************************************/
  
  // settings
  $database['host'] = '';
  
  $database['name'] = '';

  $database['user'] = '';
  
  $database['pass'] = '';
  
  // connect
  try {
    $connect = new PDO('mysql:host='. $database['host'] .'; dbname='. $database['name'], $database['user'], $database['pass']);
    
    // code
    $sql = $connect -> prepare('SET NAMES utf8');
    $sql -> execute();
    
    // get settings
    $sql = $connect -> prepare('SELECT * FROM cms_settings');
    $sql -> execute();

    foreach($sql as $get) {
      $setting['site_url'] = $get['url'];
      $setting['site_name'] = $get['name'];
    }
  }

  catch (PDOException $e) {
    print '
      Nie nawiązano połączenia z bazą danych ...
      
      <br />
      <br />
      
      Treść błędu: '. $e -> getMessage() .'
    ';

    die();
  }