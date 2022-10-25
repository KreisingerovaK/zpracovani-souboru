<?php

class File 
{
  private $fileName;
  private $fileExtension;
  private $fileTmpName;
  private $dir;
  private $increment;

  function __construct($name, $tmpName)
  {
    $this->fileTmpName = $tmpName;
    $this->dir = dirname(__FILE__).'\\upload\\';
    $this->fileName = basename($name);
    $this->fileExtension = pathinfo($this->fileName, PATHINFO_EXTENSION); // nacte pouze priponu 
    $this->fileName = pathinfo($this->fileName, PATHINFO_FILENAME); // nacte pouze jmeno souboru
    $this->fileName = iconv("utf-8", "us-ascii//TRANSLIT", $this->fileName); // odstrani diakritiku
    $this->fileName = preg_replace('~[^-a-z0-9_]+~', '', $this->fileName); // odstrani transkripci 
    $this->fileExtension = strtolower($this->fileExtension); // vechna pismena v pripone budou mala 

  }

  private function checkName()
  {
    $this->increment = '';
    while (file_exists($this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension))
    {
      $this->increment++;
      if($this->increment > 100)
      {
        die("Byl překročen limit o vytvoření neexistujícího názvu");
      }
    }
    if(!file_exists($this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension))
    {
      return true;
    }
  }

  private function moveFile()
  {
    $completeFileName = $this->dir.$this->fileName.$this->increment.'.'.$this->fileExtension;
    if(move_uploaded_file($this->fileTmpName, $completeFileName))
    {
      return true;
      echo "test";
    } 
    else
    {
      return false;
    }
  }

  public function saveFile() 
  {
    if($this->checkName() && $this->moveFile())
    {
      return true;
    }
    else
    {
      return false;
    }
  }

}