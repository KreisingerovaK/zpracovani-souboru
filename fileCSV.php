<?php require_once('classFileCSV.php'); ?>
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
        <h1>Formulář pro nahrání csv souboru:</h1>
      </div>
      <br>
      <form action="fileCSV.php" method="post" enctype="multipart/form-data">
        <label>Vyberte soubor, který chcete zpracovat:</label>
        <input name="soubor" type="file" class="form-control-file border">
        <br>
        <br>
        <label>Má se přeskočit první řádek? (obsahuje první řádek hlavičku, která se nemá použít?)</label>
        <input type="radio" id="yes" name="firstRow" value="yes"><label for="yes">ANO</label>
        <input type="radio" id="no" name="firstRow" value="no"><label for="no">NE</label>
        <br>
        <br>
        <label>Název prvního sloupečku: </label>
        <input name="firstColumnName" type="text"/>
        <br>
        <label>Název druhého sloupečku: </label>
        <input name="secondColumnName" type="text"/>
        <br>
        <label>Název třetího sloupečku: </label>
        <input name="thirdColumnName" type="text"/>
        <br>
        <label>Název čtvrtého sloupečku: </label>
        <input name="fourthColumnName" type="text"/>
        <br>
        <label>Název pátého sloupečku: </label>
        <input name="fifthColumnName" type="text"/>
        <br>
        <br>
        <label><strong>První sloupeček je 0, druhý 1 atd...</strong></label>
        <br>
        <label>Zadejte, který sloupeček má být první:</label>
        <input name="firstColumn" type="text"/>
        <br>
        <label>Zadejte, který sloupeček má být druhý:</label>
        <input name="secondColumn" type="text"/>
        <br>
        <label>Zadejte, který sloupeček má být třetí:</label>
        <input name="thirdColumn" type="text"/>
        <br>
        <label>Zadejte, který sloupeček má být čtvrtý:</label>
        <input name="fourthColumn" type="text"/>
        <br>
        <label>Zadejte, který sloupeček má být pátý:</label>
        <input name="fifthColumn" type="text"/>
        <br>
        <br>
        <input type="submit" value=" Odeslat " class="btn btn-secondary">
      </form>

      <?php
        if(!empty($_FILES['soubor']['name']))
        { 
          $firstRow = $_POST["firstRow"];
          $firstColumnName = $_POST["firstColumnName"];
          $secondColumnName = $_POST["secondColumnName"];
          $thirdColumnName = $_POST["thirdColumnName"];
          $fourthColumnName = $_POST["fourthColumnName"];
          $fifthColumnName = $_POST["fifthColumnName"];
          $firstColumn = $_POST["firstColumn"];
          $secondColumn = $_POST["secondColumn"];
          $thirdColumn = $_POST["thirdColumn"];
          $fourthColumn = $_POST["fourthColumn"];
          $fifthColumn = $_POST["fifthColumn"];
          $instance = new FileTable($_FILES['soubor']['name'], $_FILES['soubor']['tmp_name']);
          if($instance->saveFile())
          {
            echo "Soubor byl uložen";
          }
          $instance->handleFile($firstRow, $firstColumnName, $secondColumnName, $thirdColumnName, $fourthColumnName, $fifthColumnName, $firstColumn, $secondColumn, $thirdColumn, $fourthColumn, $fifthColumn);
        }
      ?>
    </div>
  </body>
</html>
