<?php
require_once('classFileExceptions.php'); 
require_once('classSaveFile.php'); 

// Trida pro zpracovani csv souboru
class FileCSV 
{
  // Nastavovani vlastnosti 
  private $fileName;
  private $orderColumn;
  private $firstRow;
  private $separator;
  private $nameColumn;
  private $columnNameArray;
  private $columnOrderArray;

  // Metoda, ktera soubor zpracovava
  public function handleFile($fileName, $orderColumn, $firstRow, $separator, $nameColumn, $columnNameArray=array(), $columnOrderArray=array()) 
  {
    // Nastaveni vlastnosti
    $this->fileName         = $fileName;
    $this->orderColumn      = $orderColumn;
    $this->firstRow         = $firstRow;
    $this->separator        = $separator;
    $this->nameColumn       = $nameColumn;
    $this->columnNameArray  = $columnNameArray;
    $this->columnOrderArray = $columnOrderArray;

    // Otevreni souboru
    $openFile = fopen($this->fileName, "r") or die("Soubor se nepodařilo otevřít");

    // Nacteni prvniho radku
    $row = fgetcsv($openFile, 0, $this->separator);

    // Pokud se ma prvni radek preskocit (obsahuje napriklad hlavicku, kterou uzivatel nechce), nacte se druhy
    if($this->firstRow == "yes")
    {
      $row = fgetcsv($openFile, 0, $this->separator);
    }

    echo '<table class="table table-hover">';

      // Tvorba hlavicky podle toho, co zadal uzivatel do formulare
      echo '<thead>';
        echo '<tr>';
          if($this->nameColumn == "yes")
          {
            foreach($row as $name)
            {
              echo '<th scope="col">'.$name.'</th>';
            }
            $row = fgetcsv($openFile, 0, $this->separator);
          }
          else
          {
            foreach($this->columnNameArray as $name)
            {
              echo '<th scope="col">'.$name.'</th>';
            }
          }
        echo '</tr>';
      echo '</thead>';

      echo '<tbody>';
        if($this->orderColumn == "no")
        {
          // cyklus, ktery se bude opakovat, dokud nebude prvni pole prazdne
          while (!empty($row[0]))
          {
            // Nactou se jednotlive hodnoty tak, jak je v souboru
            echo '<tr>';
              foreach($row as $value)
              {
                echo '<td>';
                  echo $value;
                echo '</td>';
              }
            echo '</tr>';

            // Nacte se dalsi radek
            $row = fgetcsv($openFile, 0, $this->separator);
          }
        }
        else 
        {
          // cyklus, ktery se bude opakovat, dokud nebude prvni pole prazdne
          while (!empty($row[0]))
          {
            echo '<tr>';
              // Nactou se jednotlive hodnoty tak, jak zadal uzivatel
              for ($i=0; $i<count($this->columnOrderArray); $i++) {
                $number = $this->columnOrderArray[$i];
                echo '<td>';
                  echo $row[$number];
                echo '</td>';
              }
            echo '</tr>';

            // Nacte se dalsi radek
            $row = fgetcsv($openFile, 0, $this->separator);
          }
        }
      echo '</tbody>';
    echo '</table>';

    // Po ukonceni cyklu se soubor zavre
    fclose($openFile);
  }
}