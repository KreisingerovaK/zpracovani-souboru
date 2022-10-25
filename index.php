<?php require_once('classFile.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel='stylesheet' href='bootstrap.min.css'>
    <title></title>
  </head>
  <body>
    <div class="container">
      <div class="mt-4 p-5 bg-secondary text-white rounded">
        <h1>Formulář pro nahrání souborů</h1>
      </div>
      <br>
      <form action="index.php" method="post" enctype="multipart/form-data">
        Vyberte soubor pro nahrání souboru: 
        <input name="soubor" type="file" class="form-control-file border" />
        <br>
        <br>
        <input type="submit" value=" Odeslat " class="btn btn-secondary" />
      </form>

      <?php
        if(!empty($_FILES['soubor']['name']))
        { 
          $instance = new File($_FILES['soubor']['name'], $_FILES['soubor']['tmp_name']);
          if($instance->saveFile())
          {
            echo "Soubor byl uložen";
          }
        }
      ?>
    </div>
  </body>
</html>
