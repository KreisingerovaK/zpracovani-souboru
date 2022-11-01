# zpracovaní souborů
Jedná se o malý projekt, který zpracovává soubory, které může uživatel nahrát a uloží se do složky upload. 

Je to psané v čistým PHP a pro frontend byl použit bootstrap.

Projekt umí zobrazit csv soubory, u kterých si může uživatel zadat jaké jsou oddělovače, může případně přeskočit první řádek v souboru 
(pokud je tam například hlavička, kterou uživatel nechce použít), může zadat svou vlastní hlavičku (momentálně je to omezené na 5 sloupců) 
a pořadí, ve kterém se mají sloupečky zobrazit (může si je zpřeházet). 

Krom csv souborů umí zobrazit jpg obrázky, které momentálně pouze uloží a zobrazí. 

V projektu byl dán důraz na univerzálnost a znovupoužitelnost kódu, kdy třída pro uložení souboru je univerzální a třídy, které mají soubory zpracovat,
z ní dědí. 
