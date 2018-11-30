<?php 

class BuddiesKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny clovek
		if (isset($_SESSION["rodne_cislo"])) {
			$this->hlavicka['titulek'] = 'Buddies';
			$this->pohled = 'buddies';		
			$this->data["msg_hladanaOsoba"] = "";
			$this->data["hladanaOsoba"] = NULL;
			
			$this->data["zoznamOsob"] = Osoba::getZoznamOsob();

			if (!empty($_POST) && isset($_POST["hladana_osoba"])) {
				if (($this->data["hladanaOsoba"] = Osoba::getOsoba($_POST["hladana_osoba"])) == NULL)
					$this->data["msg_hladanaOsoba"] = "Osoba nenájdená.";
			}
			
			// prihlaseny je DON
			if ($_SESSION["typ"] == 1) {
				if (isset($parametry[0]) && ($parametry[0] == "new_buddy"))
					$this->new_buddy();
			}
		} else
			$this->pohled = 'chyba';	
	}

	public function new_buddy() {
		// moze vidiet iba prihlaseny clovek
		if (isset($_SESSION["rodne_cislo"])) {
			$this->pohled = 'new_buddy';
			$this->data["success"] = "";
			$this->hlavicka['titulek'] = 'Pridať člena';
			$this->pohled = 'new_buddy';
			$this->data["don"] = new Don($_SESSION["rodne_cislo"]);
			if (!empty($_POST)){
				try {
					$success = Osoba::insertOsoba($_POST);
					if ($success != 0)
						$this->data["success"] = "Nový člen bol úspešne vložený!";
				} catch (Exception $e) {
					if (strpos($e->getMessage(), 'Duplicate') !== false){
					 	$this->data["success"] = "Rodné číslo už existuje.";
					} else
						$this->data["success"] = "Chyba pri vkladaní, skúste znovu.";
				}						
			}
		} else
			$this->pohled = 'chyba';	
	}
}