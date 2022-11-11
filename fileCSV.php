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
        <h1>Formulář pro nahrání csv souboru:</h1>
      </div>
      <br>
        <form action="handlefileCSV.php" method="post" enctype="multipart/form-data" class="was-validated">
          <div class="mb-3">
            <label class="form-label"><strong>Vyberte soubor (formátu csv), který chcete zpracovat:</strong></label>
            <input name="soubor" class="form-control" type="file" accept=".csv" required>
            <div class="valid-feedback">V pořádku.</div>
            <div class="invalid-feedback">Prosím nahrajte soubor.</div>
          </div>
          <label class="form-label"><strong>Zadejte, jaký oddělovač je použit v souboru: </strong></label>
          <input name="separator" type="text" maxlength="1" value=";"/>
          <br>
          <br>
          <input name="submit" type="submit" value=" Uložit " class="btn btn-secondary">
        </form>
    </div>
  </body>
</html>
