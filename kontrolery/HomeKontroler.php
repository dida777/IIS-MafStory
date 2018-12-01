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
				$_SESSION['session_time'] = time(); //got the login time for user in second 
			} else {
				$this->data["msg"] = "Wrong password!";
			}
		}


		// odhlasenie
		if (isset($parametry[0]) && $parametry[0] == "logout") {
			unset($_SESSION["rodne_cislo"]);
			$this->presmeruj("home");
		}

		$timeout = 600; // Number of seconds until it times out.

		// Check if the timeout field exists.
		if(isset($_SESSION['timeout'])) {
			// See if the number of seconds since the last
			// visit is larger than the timeout period.
			$duration = time() - (int)$_SESSION['timeout'];
			if($duration > $timeout) {
				// Destroy the session and restart it.
				session_destroy();
				session_start();
			}
		}
 
		// Update the timout field with the current time.
		$_SESSION['timeout'] = time();

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