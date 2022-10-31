<?php
require_once('classFileExceptions.php'); 

class SaveFile 
{
  protected $fileName;
  protected $fileExtension;
  protected $fileNameExtension;
  protected $fileTmpName;
  protected $completeFileName;
  protected $dir;
  protected $increment;

  function __construct($name, $tmpName)
  {
    $this->fileTmpName   = $tmpName;
    $this->dir           = dirname(__FILE__).'\\upload\\';
    $this->fileName      = basename($name);
    $this->fileExtension = pathinfo($this->fileName, PATHINFO_EXTENSION); // nacte pouze priponu 
    $this->fileName      = pathinfo($this->fileName, PATHINFO_FILENAME); // nacte pouze jmeno souboru
    $this->fileName      = iconv("utf-8", "us-ascii//TRANSLIT", $this->fileName); // odstrani diakritiku
    $this->fileName      = preg_replace('~[^-a-z0-9_]+~', '', $this->fileName); // odstrani transkripci 
    $this->fileExtension = strtolower($this->fileExtension); // vechna pismena v pripone budou mala 

  }

  protected function checkName()
  {
    $this->increment = '';
    while (file_exists($this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension))
    {
      $this->increment++;
      try
      {
        if($this->increment > 100)
        {
          throw new FileNameException();
        }
      } 
      catch(FileNameException $fme)
      {
        echo "<p><strong>Byl překročen limit o vytvoření neexistujícího názvu.</strong></p>";
      }
    }
    if(!file_exists($this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension))
    {
      return true;
    }
  }

  protected function moveFile()
  {
    $this->fileNameExtension = '\\upload\\'.$this->fileName.$this->increment.".".$this->fileExtension;
    $this->completeFileName = $this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension;
    try
    {
      if(!(move_uploaded_file($this->fileTmpName, $this->completeFileName)))
      {
        throw new FileMoveException(); 
      }
      else
      {
        return true;
      } 
    } 
    catch(FileMoveException $fme)
    {
      echo "<br><p><strong>Soubor se nepodařilo přesunout do složky. Zkontrolujte, zda složka ".$this->dir." existuje.</strong></p>";
    }
  }

  public function saveFile() 
  {
    if($this->checkName() && $this->moveFile())
    {
      return true;
    }
  }
}