<?php
require_once('classFileExceptions.php'); 
require_once('classSaveFile.php'); 

// Trida pro zpracovani csv souboru
// Dedi z tridy SaveFile, tedy z tridy, ktera uklada soubory
class FileCSV extends SaveFile
{
  // Nastavovani vlastnosti 
  private $firstRow;
  private $firstColumnName;
  private $secondColumnName;
  private $thirdColumnName;
  private $fourthColumnName;
  private $fifthColumnName;
  private $firstColumn;
  private $secondColumn;
  private $thirdColumn;
  private $fourthColumn;
  private $fifthColumn;

  // Konstruktor, ktery preda hodnoty konstruktoru v tride SaveFile 
  function __construct($name, $tmpName)
  {
    parent::__construct($name, $tmpName);
  }

  // Funkce, ktera kontroluje priponu souboru, zda je pozadovaneho typu
  public function checkExtension()
  {
    try
    {
      if($this->fileExtension != "csv")
      {
        throw new FileExtensionException("<br><p><strong>Soubor není správného formátu. Musíte nahrát csv soubor.</strong></p>");
      }
      else
      {
        return true;
      }
    }
    catch(FileExtensionException $fee)
    {
      echo $fee;
    }
  }

  // Funkce, ktera soubor zpracovava
  public function handleFile($firstR, $firstName, $secondName, $thirdName, $fourthName, $fifthName, $first, $second, $third, $fourth, $fifth) 
  {
    // Nastaveni vlastnosti
    $this->firstRow         = $firstR;
    $this->firstColumnName  = $firstName;
    $this->secondColumnName = $secondName;
    $this->thirdColumnName  = $thirdName;
    $this->fourthColumnName = $fourthName;
    $this->fifthColumnName  = $fifthName;
    $this->firstColumn      = $first;
    $this->secondColumn     = $second;
    $this->thirdColumn      = $third;
    $this->fourthColumn     = $fourth;
    $this->fifthColumn      = $fifth;

    // Test, zda soubor existuje
    try
    {
      if(file_exists($this->completeFileName))
      {
        // Otevreni souboru
        $openFile = fopen($this->completeFileName, "r") or die("Soubor se nepodařilo otevřít");

        echo '<table class="table table-hover">';

          // Tvorba hlavicky podle toho, co zadal uzivatel do formulare
          echo '<thead>';
            echo '<tr>';
              if(!empty($this->firstColumnName))
              echo '<th scope="col">'.$this->firstColumnName.'</th>';
              if(!empty($this->secondColumnName))
              echo '<th scope="col">'.$this->secondColumnName.'</th>';
              if(!empty($this->thirdColumnName))
              echo '<th scope="col">'.$this->thirdColumnName.'</th>';
              if(!empty($this->fourthColumnName))
              echo '<th scope="col">'.$this->fourthColumnName.'</th>';
              if(!empty($this->fifthColumnName))
              echo '<th scope="col">'.$this->fifthColumnName.'</th>';
            echo '</tr>';
          echo '</thead>';

          // Nacteni prvniho radku
          $row = fgetcsv($openFile);

          // Pokud se ma prvni radek preskocit (obsahuje napriklad hlavicku, kterou uzivatel nechce), nacte se druhy
          if($this->firstRow == "yes")
          {
            $row = fgetcsv($openFile);
          }
          
          echo '<tbody>';

            // cyklus, ktery se bude opakovat, dokud nebude prvni pole prazdne
            while ($row[0] != NULL){
              echo '<tr>';

                // Pokud bylo vyplneno, jaky sloupec ma byt prvni, tak se nacte
                echo '<td>';
                  if($this->firstColumn != '')
                  echo $row[$this->firstColumn];
                echo '</td>';

                // Pokud bylo vyplneno, jaky sloupec ma byt druhy, tak se nacte
                echo '<td>';
                  if($this->secondColumn != '')
                  echo $row[$this->secondColumn];
                echo '</td>';

                // Pokud bylo vyplneno, jaky sloupec ma byt treti, tak se nacte
                echo '<td>';
                  if($this->thirdColumn != '')
                  echo $row[$this->thirdColumn];
                echo '</td>';

                // Pokud bylo vyplneno, jaky sloupec ma byt ctvrty, tak se nacte
                echo '<td>';
                  if($this->fourthColumn != '')
                  echo $row[$this->fourthColumn];
                echo '</td>';

                // Pokud bylo vyplneno, jaky sloupec ma byt paty, tak se nacte
                echo '<td>';
                  if($this->fifthColumn != '')
                  echo $row[$this->fifthColumn];
                echo '</td>';

              echo '</tr>';

            // Nacte se dalsi radek
            $row = fgetcsv($openFile);
            }

          echo '</tbody>';
        echo '</table>';

        // Po ukonceni cyklu se soubor zavre
        fclose($openFile);
      }
      else
      {
        throw new FileExistException("<br><p><strong>Soubor neexistuje. Zkontrolujte, zda soubor s cestou: ".$this->completeFileName." existuje.</strong></p>");
      }
    }
    catch(FileExistException $fee1)
    {
      echo $fee1;
    }
  }
}