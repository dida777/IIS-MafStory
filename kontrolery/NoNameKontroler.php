<?php 

class NoNameKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny don
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 1) {
			$this->hlavicka['titulek'] = 'No Name';
			$this->pohled = 'noname';	
		}
		else
			$this->pohled = 'chyba';
	}
}