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
			$this->data["success"] = "";
			$osoba = new Osoba($_SESSION['rodne_cislo']);
			$this->data["info_meno"] = $osoba->getMeno();
			$this->data["info_priezvisko"] = $osoba->getPriezvisko();
			$this->data["info_vek"] = $osoba->getVek();

			// prihlaseny je DON
			if ($_SESSION["typ"] == 1) {
				$don = new Don($_SESSION["rodne_cislo"]);
				$this->data["aliancia"] = new Aliancia($don->getAliancia());
				// $zadavatelia_zrazov = Don::getZadavatelZraz();
				// var_dump($zadavatelia_zrazov);
				// $this->data["zraz_donov"] = new Zraz();
				// $this->data["usporiadatel"] = Osoba::getOsoba($this->data["zraz_donov"]->getUsporiadatel());
				// var_dump($this->data["zraz_donov"]);
				$idcko_aliancie = $this->data["aliancia"]->getIdAliancie();
				$this->data["info_uzemie"] = $don->getGpsUzemie();
				$this->data["nazovFamilie"] = $don->getNazovFamilie();
				$this->data["ulohy"] = Uloha::getDonUlohy($_SESSION["rodne_cislo"], $idcko_aliancie);

				if (isset($parametry[0]) && ($parametry[0] == "add_aliancia"))
					$this->add_aliancia($this->data["nazovFamilie"]);

				// zmena hodnosti clenov
				if(!empty($_POST) && isset($_POST["rodne_cislo"]) && isset($_POST["hodnost"])) {
					Clen::zmenaHodnosti($_POST["rodne_cislo"], $_POST["hodnost"]);
				}

				// zrusit alianciu
				if (isset($_POST) && isset($_POST["del_aliancia"])) {
					try {
						$delete = Don::deleteAliancia($_SESSION["rodne_cislo"], $idcko_aliancie);
						if ($delete != 0) {
							$this->pohled = 'zrusena_aliancia';
						}
					} catch (Exception $e) {
						$this->data["success"] = "Alianciu sa napodarilo zrušiť!";
					}
					
				}

			} else { // prihlaseny je CLEN
				$clen = new Clen($_SESSION["rodne_cislo"]);
				$this->data["info_hodnost"] = $clen->getHodnost();
				$this->data["info_pokr_vazba"] = $clen->getPokrvnaVazba();

				$this->data["nazovFamilie"] = $clen->getFamilia();
				$this->data["ulohy"] = Uloha::getClenUlohy($_SESSION["rodne_cislo"]);
			}

			$this->data["sefFamilie"] = Don::getSefFamilie($this->data["nazovFamilie"]);			
			$this->data["zoznamClenov"] = Clen::getZoznamClenov($this->data["nazovFamilie"]);		
		}
	}

	public function add_aliancia($nazov_fmilie) {
		// iba pre prihlasenych donov
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 1) {
			$this->pohled = 'add_aliancia';
			$this->data["success"] = "";
			$this->hlavicka['titulek'] = 'Zadať novú alianciu';
			$this->data["nazovFamilie"] = $nazov_fmilie;
			$this->data["cartels"] = Don::getAllFamilia($_SESSION["rodne_cislo"]);

			if(!empty($_POST) && isset($_POST["nazov_aliancie"])) {
				if (isset($_POST["familie_v_aliancii"])) {
					if(Aliancia::insertAliancie($_POST, $nazov_fmilie) != 0)
					$this->data["success"] = "Aliancia bola vytvorená.";
				} else
					$this->data["success"] = "Musíte vybrať aspoň jednu famíliu.";
			}

			// Auto - logout
			$timeout = 600; // Number of seconds until it times out.
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


		}
	}
}