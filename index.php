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
        </select>
        <br>
        <br>
        <input type="submit" value=" Odeslat " class="btn btn-secondary" />
      </form>

      <?php   
        if(!empty($_POST['fileType']))
        { 
          $fileType = $_POST['fileType'];
          if($fileType == "csv")
          {
            header("Location: fileCSV.php");
          }
        }
      ?>
    </div>
  </body>
</html>
