<?php require_once('classFileCSV.php'); ?>
<?php require_once('classFileExceptions.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel='stylesheet' href='bootstrap.min.css'>
    <script type="text/javascript" src="fileCSV.js"></script>
    <title></title>
  </head>
  <body>
    <div class="container">
      <div class="mt-4 p-5 bg-secondary text-white rounded">
        <h1>Formulář pro nahrání csv souboru:</h1>
      </div>
      <br>
        <form action="handlefileCSV.php" method="post" enctype="multipart/form-data">
          <div class="col-md-10">
            <label class="form-label"><strong>Vyberte soubor (formátu csv), který chcete zpracovat:</strong></label>
            <input name="soubor" id="file" class="form-control" type="file" accept=".csv" required>
          </div>
          <div class="col-md-6">
            <label class="form-label"><strong>Zadejte, jaký oddělovač je použit v souboru: </strong></label>
            <input name="separator" class="form-control" type="text" maxlength="1" value=";" required>
          </div>
          <br>
          <input id="button" name="submit" type="submit" value=" Uložit " class="btn btn-secondary">
        </form>
    </div>
  </body>
</html>
