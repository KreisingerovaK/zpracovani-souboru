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
        <h1>Formulář pro volbu, jakého typu je soubor, který chcete nahrát:</h1>
      </div>
      <br>
      <form action="index.php" method="post" enctype="multipart/form-data">
        Vyberte typ, jakého je soubor který chcete nahrát: 
        <select name="fileType" id="fileType">
          <option value="csv">csv</option>
          <option value="jpg">jpg</option>
        </select>
        <br>
        <br>
        <input type="submit" value=" Odeslat " class="btn btn-secondary" />
      </form>

      <?php
        // Podle hodnoty v selectu, se uzivatel presmeruje na stranku pro zpracovani daneho typu souboru   
        if(!empty($_POST['fileType']))
        { 
          $fileType = $_POST['fileType'];
          if($fileType == "csv")
          {
            header("Location: fileCSV.php");
          }
          elseif($fileType == "jpg")
          {
            header("Location: fileJPG.php");
          }
        }
      ?>
    </div>
  </body>
</html>
