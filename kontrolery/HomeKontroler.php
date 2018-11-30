<?php

class HomeKontroler extends Kontroler {

	public function zpracuj($parametry) {
		$this->hlavicka['titulek'] = 'Vitajte!';
		$this->pohled = 'home';
		$this->data["msg"] = "";
		$this->data["aliancia"] = "";

		// spracovanie prihlasovacieho formulara
		if(!empty($_POST) && isset($_POST["rodne_cislo"]) && isset($_POST["heslo"])) {
			$osoba = new Osoba($_POST['rodne_cislo']);
			if (($_POST["heslo"] == $osoba->getHeslo()) && ($_POST["heslo"] != NULL)){
				$_SESSION["rodne_cislo"] = $osoba->getRodneCislo();
				$_SESSION["typ"] = $osoba->getTyp();
			} else {
				$this->data["msg"] = "Wrong password!";
			}
		}


		// odhlasenie
		if (isset($parametry[0]) && $parametry[0] == "logout") {
			unset($_SESSION["rodne_cislo"]);
			$this->presmeruj("home");
		}

		// po prihlaseni uzivatela
		if (isset($_SESSION["rodne_cislo"])) {
			$this->pohled = 'menu';

			// prihlaseny je DON
			if ($_SESSION["typ"] == 1) {
				$don = new Don($_SESSION["rodne_cislo"]);
				$aliancia = new Aliancia($don->getAliancia());

				$this->data["nazovFamilie"] = $don->getNazovFamilie();
				$this->data["aliancia"] = $aliancia;
				$this->data["ulohy"] = Uloha::getDonUlohy($_SESSION["rodne_cislo"], $aliancia->getIdAliancie());

				// zmena hodnosti clenov
				if(!empty($_POST) && isset($_POST["rodne_cislo"]) && isset($_POST["hodnost"])) {
					Clen::zmenaHodnosti($_POST["rodne_cislo"], $_POST["hodnost"]);
				}

			} else { // prihlaseny je CLEN
				$clen = new Clen($_SESSION["rodne_cislo"]);
				$this->data["nazovFamilie"] = $clen->getFamilia();
				$this->data["ulohy"] = Uloha::getClenUlohy($_SESSION["rodne_cislo"]);
			}

			$this->data["sefFamilie"] = Don::getSefFamilie($this->data["nazovFamilie"]);			
			$this->data["zoznamClenov"] = Clen::getZoznamClenov($this->data["nazovFamilie"]);		
		}
	}
}