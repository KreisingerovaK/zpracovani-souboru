<?php 
require_once('classFileCSV.php');
require_once('classFileExceptions.php');
$html = '<!DOCTYPE html>';
$html .= '<html>';
  $html .= '<head>';
    $html .= '<meta charset="UTF-8">';
    $html .= '<link rel="stylesheet" href="bootstrap.min.css">';
    $html .= '<script type="text/javascript" src="fileCSV.js"></script>';
    $html .= '<title></title>';
  $html .= '</head>';

  if(!empty($_FILES['soubor']['name']))
  {
    $ulozeno = 0;
    // ziskani poctu sloupcu v souboru, aby se podle toho mohl nabinout formular
    $file          = fopen($_FILES['soubor']['tmp_name'], "r") or die("Soubor se nepodařilo otevřít");
    $filerow       = fgetcsv($file, 0, $_POST['separator']);
    $numberColumns = count($filerow);

    // Vytvori se novy ojekt tridy SaveFile
    $save = new SaveFile($_FILES['soubor']['name'], $_FILES['soubor']['tmp_name']);

    // zkontroluje se, zda je soubor spravneho formatu
    if($save->checkExtension('csv'))
    {
      // metoda saveFile ulozi soubor
      if($save->saveFile())
      {
        $ulozeno = 1;
      }
    }
    $name = $save->getFileName();
    $separator = $_POST["separator"];
  }
  if(!empty($_POST["number"]))
  {
    $numberColumns = $_POST["number"];
  }
  $html .= '<body>';
    $html .= '<div class="container">';
      $html .= '<div class="mt-4 p-5 bg-secondary text-white rounded">';

        // Podle toho v jake fazi je uzivatel, se zobrazi nadpis
        if(empty($_POST["firstRow"]))
        {
          $html .= '<h1>Zadejte, jak se má csv soubor zpracovat:</h1>';
        }
        else if(!empty($_POST["firstRow"]))
        {
          $html .= '<h1>Zpracovaný csv soubor:</h1>';
        }

      $html .= '</div>';
      $html .= '<br>';
      echo $html;
      
      // Pokud je soubor zpracovany, tak se schova formular
      if(empty($_POST["firstRow"]) && $ulozeno)
      {
        // Vytvori formularova policka s moznosti pojmenovani sloupcu
        $htmlNameColumn = '';
        for($i=1; $i<=$numberColumns; $i++)
        {
          $htmlNameColumn .= '<label class="form-label">Název '.$i.'. sloupečku:&nbsp;</label>';
          $htmlNameColumn .= '<input name="'.$i.'ColumnName" type="text" id="names'.$i.'"/>';
          $htmlNameColumn .= '<br>';
        }

        // Vytvori formularova policka pro zadani poradi sloupcu
        $htmlOrderColumn = '';
        $numberColumns;
        for($i=1; $i<=$numberColumns; $i++)
        {
          $htmlOrderColumn .= '<label class="form-label">Zadejte, který sloupeček má být '.$i.'.:&nbsp;</label>';
          $htmlOrderColumn .= '<input id="order'.$i.'" name="'.$i.'Column" type="number" min="1" max="'.$numberColumns.'"/>';
          $htmlOrderColumn .= '<br>';
        }

        $html = '<form action="handleFileCSV.php" method="post" enctype="multipart/form-data" class="was-validated">';
          $html .= '<label>Má se přeskočit první řádek? (obsahuje první řádek hlavičku, která se nemá použít?)&nbsp;</label>';
          $html .= '<input type="radio" id="yes" name="firstRow" value="yes"><label for="yes">ANO</label>&nbsp;';
          $html .= '<input type="radio" id="no" name="firstRow" value="no" checked><label >NE</label>';
          $html .= '<br>';
          $html .= '<br>';
          $html .= '<div id="firstRowNames">';
            $html .= '<label>Chcete použít první řádek jako názvy sloupců?&nbsp;</label>';
              $html .= '<input type="radio" onchange="names(1,'.$numberColumns.')" name="nameColumn" value="yes"><label>ANO</label>&nbsp;';
              $html .= '<input type="radio" onchange="names(0,'.$numberColumns.')" name="nameColumn" value="no" checked><label >NE</label>';
            $html .= '<br>';
            $html .= '<br>';
          $html .= '</div>';
          $html .= '<div id="namesColumn">';
            $html .= $htmlNameColumn;
            $html .= '<br>';
          $html .= '</div>';
          $html .= '<label>Má se změnit pořadí sloupečků?&nbsp;</label>';
            $html .= '<input type="radio" onchange="order(1,'.$numberColumns.')" id="yes" name="orderColumnRadio" value="yes" checked><label >ANO</label>&nbsp;';
            $html .= '<input type="radio" onchange="order(0,'.$numberColumns.')" id="no" name="orderColumnRadio" value="no"><label>NE</label>';
          $html .= '<br>';
          $html .= '<br>';
          $html .= '<div id="orderColumn">';
            $html .= '<label class="form-label"><strong>Je nutné vyplnit všechny políčka, pokud zůstane nějaké prázdné, bude mu automaticky přidělen 1. sloupec</strong></label>';
            $html .= '<br>';
            $html .= $htmlOrderColumn;
          $html .= '</div>';
          $html .= '<br>';
          $html .= '<input type="hidden" name="number" value="'.$numberColumns.'">';
          $html .= '<input type="hidden" name="separator" value="'.$separator.'">';
          $html .= '<input type="hidden" name="nameFile" value="'.$name.'">';
          $html .= '<input type="hidden" name="ulozeno" value="'.$ulozeno.'">';
          $html .= '<input name="submit" type="submit" value=" Odeslat " class="btn btn-secondary">';
        $html .= '</form>';
        echo $html;
      }

      // Pokud je odeslana hodnota prvniho dotazu, tak se soubor zacne zpracovavat
      if(!empty($_POST["firstRow"]))
      {
        // Zkontroluje se, zda byl soubor ulozen
        $ulozeno = $_POST["ulozeno"];
        if($ulozeno == 1);
        {
          // Nacitou se hodnoty formulare
          $firstRow      = $_POST["firstRow"];
          $separator     = $_POST["separator"];
          $nameColumn    = $_POST["nameColumn"];
          $numberColumns = $_POST["number"];
          $nameFile      = $_POST["nameFile"];
          $orderColumn   = $_POST["orderColumnRadio"];

          // Nactou se do pole jmena
          $columnNameArray = array();
          for($i=1; $i<=$numberColumns; $i++)
          {
            $valueColumName = $_POST[$i.'ColumnName'];
            $valueColumName = htmlspecialchars($valueColumName);
            array_push($columnNameArray, $valueColumName);
          }

          // Nactou se do pole sloupecky, pokud nejsou vyplnene, priradi se hodnota 0
          $columnOrderArray = array();
          for($i=1; $i<=$numberColumns; $i++)
          {
            if(!empty($_POST[$i.'Column']))
            {
              $valueColumOrder = $_POST[$i.'Column'] - 1;
            }
            else
            {
              $valueColumOrder = 0;
            }
            array_push($columnOrderArray, $valueColumOrder);
          }
          
          // vytvori se novy objekt tridy FileCSV
          $handle = new FileCSV();

          // handleFile zpracuje soubor tak, jak zadal uzivatel do formulare
          $html = $handle->handleFile($nameFile, $orderColumn, $firstRow, $separator, $nameColumn, $columnNameArray, $columnOrderArray);
          echo $html;
        }
      }
    $html = '</div>';
  $html .= '</body>';
$html .= '</html>';
echo $html;
