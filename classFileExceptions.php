<?php 

// Vyjimka pro prekroceni limitu u jmena
class FileNameException extends Exception {
  function __toString()
  {
     return "FileNameException: ".$this->getMessage()." v ".$this->getFile()." na řádku <strong>".$this->getLine()."</strong><br>"; 
  }
}

// Vyjimka pro presunuti souboru
class FileMoveException extends Exception {
  function __toString()
  {
     return "FileMoveException: ".$this->getMessage()." v ".$this->getFile()." na řádku <strong>".$this->getLine()."</strong><br>"; 
  }
}

// Vyjimka pro existenci souboru
class FileExistException extends Exception {
    function __toString()
    {
       return "FileExistException: ".$this->getMessage()." v ".$this->getFile()." na řádku <strong>".$this->getLine()."</strong><br>"; 
    }
}

// Vyjimka pro kontrolu, zda byl nahran soubor
class FileUploadException extends Exception {
  function __toString()
  {
     return "FileUploadException: ".$this->getMessage()." v ".$this->getFile()." na řádku <strong>".$this->getLine()."</strong><br>"; 
  }
}

// Vyjimka pro kontrolu, zda je spravna pripona
class FileExtensionException extends Exception {
  function __toString()
  {
     return "FileExtensionException: ".$this->getMessage()." v ".$this->getFile()." na řádku <strong>".$this->getLine()."</strong><br>"; 
  }
}