<?php 

class ToDoListKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny clovek
		if (isset($_SESSION["rodne_cislo"])) {
			$this->hlavicka['titulek'] = 'ToDo List';
			$this->pohled = 'todolist';	
			$this->data["ulohy"] = "";

			// prihlaseny je DON
			if ($_SESSION["typ"] == 1) {
				$don = new Don($_SESSION["rodne_cislo"]);
				$aliancia = new Aliancia($don->getAliancia());
				$this->data["ulohy"] = Uloha::getDonUlohy($_SESSION["rodne_cislo"], $aliancia->getIdAliancie());
			} else {
				$this->data["ulohy"] = Uloha::getClenUlohy($_SESSION["rodne_cislo"]);
			}


			if (isset($parametry[0])) {
				switch ($parametry[0]) {
					case "zacat":
						$this->zacatUlohu();
						break;
					case "ukoncit":
						$this->ukoncitUlohu();
				}
			}

		} else
			$this->pohled = 'chyba';
	}

	public function zacatUlohu() {
		Uloha::updateCasZaciatku($_POST["specificke_meno"], $_POST["cas_zaciatku"]);
		$this->presmeruj("todolist");
	}

	public function ukoncitUlohu() {		
		Uloha::updateCasKonca($_POST["specificke_meno"], $_POST["cas_konca"], $_POST["uspesnost"], $_POST["komentar"]);
		$this->presmeruj("todolist");
	}
}