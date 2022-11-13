<?php require_once('classFileJPG.php'); ?>
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
            echo '<h1>Formulář pro nahrání jpg souboru:</h1>';
          }
          else
          {
            echo '<h1>Zpracovaný jpg soubor:</h1>';
          }
        ?>
      </div>
      <br>
      <?php 
        // Pokud je odeslany soubor, tak zmizi formular
        if(empty($_FILES['soubor']['name']))
        { 
      ?>
          <form action="fileJPG.php" method="post" enctype="multipart/form-data">
            <div class="col-md-10">
              <label class="form-label"><strong>Vyberte soubor (formátu jpg), který chcete zpracovat:</strong></label>
              <input name="soubor" class="form-control" type="file" accept=".jpg, .JPG" required>
            </div>
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

              // Vytvori se novy ojekt tridy FileTable
              $instance = new FileJPG($_FILES['soubor']['name'], $_FILES['soubor']['tmp_name']);

              // Pokud je soubor spravneho typu, tak se pouziji metody pro tridu FileJPG
              if($instance->checkExtension('jpg'))
              {
                // Zkontroluje se, zda se jedna o pravy obrazek
                if($instance->checkImg())
                {
                  // metoda saveFile ulozi soubor
                  $instance->saveFile();

                  // metoda, ktera zobrazi obrazek
                  $instance->displayImg();
                }
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