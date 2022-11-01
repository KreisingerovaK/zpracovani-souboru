<?php
require_once('classFileExceptions.php'); 
require_once('classSaveFile.php'); 

// Trida pro zpracovani jpg souboru
// Dedi z tridy SaveFile, tedy z tridy, ktera uklada soubory
class FileJPG extends SaveFile
{

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
      if($this->fileExtension != "jpg")
      {
        throw new FileExtensionException("<br><p><strong>Soubor není správného formátu. Musíte nahrát jpg soubor.</strong></p>");
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

  // Funkce, ktera kontroluje, zda se jedna o falesny obrazek
  public function checkImg()
  {
    try{
      if(getimagesize($this->fileTmpName))
      {
        return true;
      }
      else
      {
        throw new FileFakeImgException("<br><p><strong>Nahrajte jiný obrázek.</strong></p>");
      }
    }
    catch(FileFakeImgException $ffie)
    {
      echo $ffie;
    }
  } 

  // Funkce, ktera obrazek zobrazi
  public function displayImg()
  {
    echo "<img src='".$this->fileNameDir."' class='img-fluid' alt='nahrany obrazek'>";
  }
}