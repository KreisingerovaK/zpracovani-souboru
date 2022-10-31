<?php
require_once('classFileExceptions.php'); 
require_once('classSaveFile.php'); 

class FileTable extends SaveFile
{
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

  function __construct($name, $tmpName)
  {
    parent::__construct($name, $tmpName);
  }

  public function handleFile($firstR, $firstName, $secondName, $thirdName, $fourthName, $fifthName, $first, $second, $third, $fourth, $fifth) 
  {
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

    try
    {
      if(file_exists($this->completeFileName))
      {
        $openFile = fopen($this->completeFileName, "r") or die("Soubor se nepodařilo otevřít");

        echo '<table class="table table-hover">';

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

          $row = fgetcsv($openFile);
          if($this->firstRow == "yes")
          {
            $row = fgetcsv($openFile);
          }
          
          echo '<tbody>';

            while ($row[0] != NULL){
              echo '<tr>';

                  echo '<td>';
                    print_r($row[$this->firstColumn]);
                  echo '</td>';

                  echo '<td>';
                    print_r($row[$this->secondColumn]);
                  echo '</td>';

                  echo '<td>';
                    print_r($row[$this->thirdColumn]);
                  echo '</td>';

                  echo '<td>';
                    print_r($row[$this->fourthColumn]);
                  echo '</td>';

                  echo '<td>';
                    print_r($row[$this->fifthColumn]);
                  echo '</td>';

              echo '</tr>';

            $row = fgetcsv($openFile);
            }
          echo '</tbody>';
        echo '</table>';

        fclose($openFile);
      }
      else
      {
        throw new FileExistException();
      }
    }
    catch(FileExistException $fee)
    {
      echo "<br><p><strong>Soubor neexistuje. Zkontrolujte, zda soubor s cestou: ".$this->completeFileName." existuje.</strong></p>";
    }

  }

}