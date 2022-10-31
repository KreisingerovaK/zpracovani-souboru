<?php 

class FileNameException extends Exception {
  function __toString()
  {
     return "FileNameException ".$this->getCode().": ".$this->getMessage()."<br>"." v ".$this->getFile()." na řádku ".$this->getLine()."<br>"; 
  }
}


class FileMoveException extends Exception {
  function __toString()
  {
     return "FileMoveException ".$this->getCode().": ".$this->getMessage()."<br>"." v ".$this->getFile()." na řádku ".$this->getLine()."<br>"; 
  }
}

class FileExistException extends Exception {
    function __toString()
    {
       return "FileExistException ".$this->getCode().": ".$this->getMessage()."<br>"." v ".$this->getFile()." na řádku ".$this->getLine()."<br>"; 
    }
}