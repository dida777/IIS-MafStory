<?php
// Výchozí kontroler pro ITnetworkMVC
abstract class Kontroler
{

	// Pole, jehož indexy jsou poté viditelné v šabloně jako běžné proměnné
    protected $data = array();
	// Název šablony bez přípony
    protected $pohled = "";
	// Hlavička HTML stránky
	protected $hlavicka = array('titulek' => '', 'klicova_slova' => '', 'popis' => '');

	// Ošetří proměnnou pro výpis do HTML stránky
	private function osetri($x = null)
	{
		if (!isset($x))
			return null;
		elseif (is_string($x))
			return htmlspecialchars($x, ENT_QUOTES);
		elseif (is_array($x))
		{
			foreach($x as $k => $v)
			{
				$x[$k] = $this->osetri($v);
			}
			return $x;
		}
		else 
			return $x;
	}
	
	// Vyrenderuje pohled
    public function vypisPohled()
    {
        if ($this->pohled)
        {
            extract($this->osetri($this->data));
			extract($this->data, EXTR_PREFIX_ALL, "");
            require("pohledy/" . $this->pohled . ".phtml");
        }
    }
	
	// Přesměruje na dané URL
	public function presmeruj($url)
	{
		header("Location: /$url");
		header("Connection: close");
        exit;
	}

	// Hlavní metoda controlleru
    abstract function zpracuj($parametry);

}
//source www.itnetwork.cz
