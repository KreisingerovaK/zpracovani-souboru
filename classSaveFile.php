<?php
require_once('classFileExceptions.php'); 

// Trida pro ulozeni souboru
class SaveFile 
{
  // Nastaveni vlastnosti
  protected $fileName;
  protected $fileExtension;
  protected $fileTmpName;
  protected $fileNameDir;
  protected $completeFileName;
  protected $dir;
  protected $increment;

  // Konstrukt, ktery pracuje s nazvem souboru
  function __construct($name, $tmpName)
  {
    $this->fileTmpName   = $tmpName; // Ulozi se tmp name
    $this->dir           = dirname(__FILE__).'\\upload\\'; // Nacte se cesta ke slozce "upload", kam se ma soubor ulozit
    $this->fileName      = basename($name); // Nacte jmeno souboru
    $this->fileExtension = pathinfo($this->fileName, PATHINFO_EXTENSION); // Nacte pouze priponu 
    $this->fileName      = pathinfo($this->fileName, PATHINFO_FILENAME); // Nacte pouze jmeno souboru
    $this->fileName      = iconv("utf-8", "us-ascii//TRANSLIT", $this->fileName); // Odstrani diakritiku
    $this->fileExtension = strtolower($this->fileExtension); // Vechna pismena v pripone budou mala 
  }

  // Metoda, ktera vrati cestu k souboru 
  public function getFileName()
  {
    return $this->fileNameDir;
  }

  // Metoda, ktera kontroluje priponu souboru, zda je pozadovaneho typu
  public function checkExtension($extension)
  {
    try
    {
      if($this->fileExtension != $extension)
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

  // Metoda, ktera zkontroluje jmeno
  protected function checkName()
  {
    $this->increment = '';
    // Cyklus, ktery se bude opakovat dokud bude existovat soubor se jmenem, ktere chceme ulozit
    while (file_exists($this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension))
    {
      // Pricte se 1 k cislu, ktere pridavame za jmeno souboru, aby vzniklo jmeno, ktere jeste neni ve slozce
      $this->increment++;
      // Pokud pridana hodnota je 100, vyhodi to vyjimku o tom, ze byl prekrocen limit
      try
      {
        if($this->increment > 100)
        {
          throw new FileNameException("<p><strong>Byl překročen limit o vytvoření neexistujícího názvu.</strong></p>");
        }
      } 
      catch(FileNameException $fne)
      {
        echo $fne;
      }
    }
    // Kdyz soubor se stejnym jmenem neexistuje, vrati metoda true
    if(!file_exists($this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension))
    {
      return true;
    }
  }

  // Metoda, pro ulozeni souboru - presunuti do slozky upload
  protected function moveFile()
  {
    // Pokud neexistuje slozka s nazvem upload, tak se vytvori
    if(!file_exists('upload'))
    {
      mkdir('upload');
    }

    // Cesta k souboru
    $this->fileNameDir = 'upload/'.$this->fileName.$this->increment.'.'.$this->fileExtension;
    // Kompletni cesta k souboru s upravenym nazvem souboru
    $this->completeFileName = $this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension;
    // Otestovani, zda se podarilo presunout soubor do slozky, zaroven se u toho prejmenuje na upraveny nazev
    // Metoda vraci true
    try
    {
      if(!(move_uploaded_file($this->fileTmpName, $this->completeFileName)))
      {
        throw new FileMoveException("<br><p><strong>Soubor se nepodařilo přesunout do složky. Zkontrolujte, zda složka ".$this->dir." existuje.</strong></p>"); 
      }
      else
      {
        return true;
      } 
    } 
    catch(FileMoveException $fme)
    {
      echo $fme;
    }
  }

  // Metoda, pro konecne ulozeni souboru
  public function saveFile() 
  {
    // Provede se kontrola jmena a provede se presunuti souboru
    if($this->checkName() && $this->moveFile())
    {
      return true;
    }
  }
}