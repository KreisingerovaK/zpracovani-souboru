<?php require_once('classFileCSV.php'); ?>
<?php require_once('classFileExceptions.php'); ?>
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
        <?php 
          // Pokud neni odeslany soubor, tak se zobrazi nadpis pro stranku s formularem, jinak se zobrazi nadpis pro tabulku
          if(empty($_FILES['soubor']['name']))
          { 
        ?>
            <h1>Formulář pro nahrání csv souboru:</h1>
        <?php
          }
          else
          {
        ?>
            <h1>Zpracovaný csv soubor:</h1>
        <?php
          }
        ?>
      </div>
      <br>
      <?php 
        // Pokud je odeslany soubor, tak zmizi formular
        if(empty($_FILES['soubor']['name']))
        { 
      ?>
          <form action="fileCSV.php" method="post" enctype="multipart/form-data" class="was-validated">
            <div class="mb-3">
              <label class="form-label"><strong>Vyberte soubor (formátu csv), který chcete zpracovat:</strong></label>
              <input name="soubor" class="form-control" type="file" accept=".csv" required>
              <div class="valid-feedback">V pořádku.</div>
              <div class="invalid-feedback">Prosím nahrajte soubor.</div>
            </div>
            <br>
            <label>Má se přeskočit první řádek? (obsahuje první řádek hlavičku, která se nemá použít?)</label>
            <input type="radio" id="yes" name="firstRow" value="yes"><label for="yes">ANO</label>
            <input type="radio" id="no" name="firstRow" value="no" checked><label for="no">NE</label>
            <br>
            <br>
            <label class="form-label"><strong>Zadejte jaký oddělovač je použit v souboru: </strong></label>
            <input name="separator" type="text" maxlength="1" value=";"/>
            <br>
            <br>
            <label class="form-label">Název prvního sloupečku: </label>
            <input name="firstColumnName" type="text"/>
            <br>
            <label class="form-label">Název druhého sloupečku: </label>
            <input name="secondColumnName" type="text"/>
            <br>
            <label class="form-label">Název třetího sloupečku: </label>
            <input name="thirdColumnName" type="text"/>
            <br>
            <label class="form-label">Název čtvrtého sloupečku: </label>
            <input name="fourthColumnName" type="text"/>
            <br>
            <label class="form-label">Název pátého sloupečku: </label>
            <input name="fifthColumnName" type="text"/>
            <br>
            <br>
            <label class="form-label"><strong>První sloupeček je 0, druhý 1 atd...</strong></label>
            <br>
            <label class="form-label">Zadejte, který sloupeček má být první:</label>
            <input name="firstColumn" type="number" min="0" max="4"/>
            <br>
            <label class="form-label">Zadejte, který sloupeček má být druhý:</label>
            <input name="secondColumn" type="number" min="0" max="4"/>
            <br>
            <label class="form-label">Zadejte, který sloupeček má být třetí:</label>
            <input name="thirdColumn" type="number" min="0" max="4"/>
            <br>
            <label class="form-label">Zadejte, který sloupeček má být čtvrtý:</label>
            <input name="fourthColumn" type="number" min="0" max="4"/>
            <br>
            <label class="form-label">Zadejte, který sloupeček má být pátý:</label>
            <input name="fifthColumn" type="number" min="0" max="4"/>
            <br>
            <br>
            <input name="submit" type="submit" value=" Odeslat " class="btn btn-secondary">
          </form>
      <?php
        }

        // Otestuje se, zda byl nahran do formulare soubor, jinak to vyhodi vyjimku
        try
        {
          if(!empty($_POST['submit']))
          {
            if(!empty($_FILES['soubor']['name']))
            { 
              // Pokud je odeslany soubor, zacnou se nacitat hodnoty formulare
              $firstRow = $_POST["firstRow"];

              $separator = $_POST["separator"];

              $firstColumnName = $_POST["firstColumnName"];
              $secondColumnName = $_POST["secondColumnName"];
              $thirdColumnName = $_POST["thirdColumnName"];
              $fourthColumnName = $_POST["fourthColumnName"];
              $fifthColumnName = $_POST["fifthColumnName"];

              // Protoze je jmeno formulare neomezeny text, je potreba osetrit specialni znaky, aby se predeslo utoku
              $firstColumnName = htmlspecialchars($firstColumnName);
              $secondColumnName = htmlspecialchars($secondColumnName);
              $thirdColumnName = htmlspecialchars($thirdColumnName);
              $fourthColumnName = htmlspecialchars($fourthColumnName);
              $fifthColumnName = htmlspecialchars($fifthColumnName);

              $firstColumn = $_POST["firstColumn"];
              $secondColumn = $_POST["secondColumn"];
              $thirdColumn = $_POST["thirdColumn"];
              $fourthColumn = $_POST["fourthColumn"];
              $fifthColumn = $_POST["fifthColumn"];

              // Vytvori se novy ojekt tridy FileCSV
              $instance = new FileCSV($_FILES['soubor']['name'], $_FILES['soubor']['tmp_name']);

              if($instance->checkExtension())
              {
                // Pokud je soubor spravneho typu, tak se pouziji metody pro tridu FileCSV
                // metoda saveFile ulozi soubor
                $instance->saveFile();
                // handleFile zpracuje soubor tak, jak zadal uzivatel do formulare
                $instance->handleFile($firstRow, $separator, $firstColumnName, $secondColumnName, $thirdColumnName, $fourthColumnName, $fifthColumnName, $firstColumn, $secondColumn, $thirdColumn, $fourthColumn, $fifthColumn);
              }
            }
            else
            {
            throw new FileUploadException("<br><p><strong>Do formuláře nebyl nahrán soubor.</strong></p>");
            }
          }
        }
        catch(FileUploadException $fue)
        {
          echo $fue;
        }
      ?>
    </div>
  </body>
</html>
