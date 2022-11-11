// Funkce pro volbu toho, zda se ma prvni radek pouzit jako nazev sloupcu
function names(i, number)
{
  if(i == 1)
  {
    document.getElementById("namesColumn").style.display = "none";
    // Vymazou se hodnoty v polickach, kam se pisou nazvy
    for (y=1; y<= number; y++) {
      document.getElementById('names'+y).value = "";
    }
  }
  else if(i == 0)
  {
    document.getElementById("namesColumn").style.display = "";
  }
}

// Funkce pro volbu toho, zda se ma zmenit poradi sloupecku
function order(i, number)
{
  if(i == 1)
  {
    document.getElementById("orderColumn").style.display = "";
  }
  else if(i == 0)
  {
    document.getElementById("orderColumn").style.display = "none";
    // Vymazou se hodnoty v polickach, kam se pise poradi
    for (y=1; y<= number; y++) {
      document.getElementById('order'+y).value = "";
    }
  }
}
