<?php 

class BuddiesKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny clovek
		if (isset($_SESSION["rodne_cislo"])) {
			$this->hlavicka['titulek'] = 'Buddies';
			$this->pohled = 'buddies';		
			$this->data["msg_hladanaOsoba"] = "";
			$this->data["hladanaOsoba"] = NULL;

			$timeout = 600; // Number of seconds until it times out.

			// Check if the timeout field exists.
			if(isset($_SESSION['timeout'])) {
				// See if the number of seconds since the last
				// visit is larger than the timeout period.
				$duration = time() - (int)$_SESSION['timeout'];
				if($duration > $timeout) {
					// Destroy the session and restart it.
					session_destroy();
					$this->presmeruj("home");
					session_start();
				}
			}
			
			$this->data["zoznamOsob"] = Osoba::getZoznamOsob();

			if (!empty($_POST) && isset($_POST["hladana_osoba"])) {
				if (($this->data["hladanaOsoba"] = Osoba::getOsoba($_POST["hladana_osoba"])) == NULL)
					$this->data["msg_hladanaOsoba"] = "Osoba nenájdená.";
			}
			
			// prihlaseny je DON alebo ADMIN
			if ($_SESSION["typ"] != 0) {
				if (isset($parametry[0]) && ($parametry[0] == "new_buddy"))
					$this->new_buddy();
			}

			if ($_SESSION["typ"] == 2) {
				if (isset($parametry[0]) && ($parametry[0] == "new_don"))
					$this->new_don();
				if (isset($parametry[0]) && ($parametry[0] == "edit_person"))
					$this->edit_person();
			}
		} else
			$this->pohled = 'chyba';	
	}

	public function edit_person() {
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 2) { //Admin
			$this->pohled = 'edit_person';
			$this->hlavicka['titulek'] = 'Upraviť osobu';
			$this->data["success"] = "";
			$this->data["person"] = "";
			$this->data["pokrvna_vazba"] = "";
			$this->data["hodnost"] = "";
			$this->data["nazov_familie"] = "";
			$this->data["gps_uzemie"] = "";
			$this->data["aliancia"] = "";
			$this->data["zvolal_zraz"] = "";

			if (!empty($_POST) && isset($_POST["rodne_cislo"])){ //rodne cislo odoby v post
				$this->data["person"] = Osoba::getOsoba($_POST["rodne_cislo"]);
				if ($this->data["person"][0]["typ"] == 1) {
					$don = new Don($this->data["person"][0]["rodne_cislo"]);
					$this->data["nazov_familie"] = $don->getNazovFamilie();
					$this->data["gps_uzemie"] = $don->getGpsUzemie();
					$this->data["aliancia"] = $don->getAliancia();
					$this->data["zvolal_zraz"] = $don->getZvolalZraz();

					$this->data["uzemie"] = Uzemie::getUzemiaBezDona();

					if(!empty($_POST) && isset($_POST["rodne_cislo"]) && isset($_POST["gps_uzemie"]) && ($this->data["gps_uzemie"] != $_POST["gps_uzemie"]))
						if(Don::zmenaUzemia($_POST["rodne_cislo"], $_POST["gps_uzemie"]) != 0)
							$this->data["success"] = "Informácie boli upravené.";
						else
							$this->data["success"] = "Informácie sa nepodarilo upraviť.";

				} else {
					$clen = new Clen($this->data["person"][0]["rodne_cislo"]);
					$this->data["pokrvna_vazba"] = $clen->getPokrvnaVazba();
					$this->data["hodnost"] = $clen->getHodnost();

					if(!empty($_POST) && isset($_POST["rodne_cislo"]) && isset($_POST["hodnost"]) && ($this->data["hodnost"] != $_POST["hodnost"]))
						if(Clen::zmenaHodnosti($_POST["rodne_cislo"], $_POST["hodnost"]) != 0)
							$this->data["success"] = "Informácie boli upravené.";
						else
							$this->data["success"] = "Informácie sa nepodarilo upraviť.";
					
					if(!empty($_POST) && isset($_POST["rodne_cislo"]) && isset($_POST["pokrvna_vazba"]) && ($this->data["pokrvna_vazba"] != $_POST["pokrvna_vazba"]))
						if(Clen::zmenaPokrvnaVazba($_POST["rodne_cislo"], $_POST["pokrvna_vazba"]) != 0)
							$this->data["success"] = "Informácie boli upravené.";
						else
							$this->data["success"] = "Informácie sa nepodarilo upraviť.";
				}
			}

		} else
			$this->pohled = 'chyba';	
	}

	public function new_buddy() {
		// moze vidiet iba prihlaseny DON alebo ADMIN
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] != 0) {
			$this->pohled = 'new_buddy';
			$this->data["success"] = "";
			$this->hlavicka['titulek'] = 'Pridať člena';
			$this->data["don"] = new Don($_SESSION["rodne_cislo"]);

			$timeout = 600; // Number of seconds until it times out.

			// Check if the timeout field exists.
			if(isset($_SESSION['timeout'])) {
				// See if the number of seconds since the last
				// visit is larger than the timeout period.
				$duration = time() - (int)$_SESSION['timeout'];
				if($duration > $timeout) {
					// Destroy the session and restart it.
					session_destroy();
					$this->presmeruj("home");
					session_start();
				}
			}
			
			if ($_SESSION["typ"] == 2) { //admin
				$this->data["zoznamDon"] = Don::getZoznamDonov();
			}

			if (!empty($_POST)){
				try {
					$success = Clen::insertClen($_POST);
					if ($success != 0)
						$this->data["success"] = "Nový člen bol úspešne vložený!";
					elseif ($success == "Rodné číslo už existuje.") 
						$this->data["success"] = $success;
					else
						$this->data["success"] = "Chyba pri vkladaní, skúste znovu.";
				} catch (Exception $e) {
					if (strpos($e->getMessage(), 'Duplicate') != false){
					 	$this->data["success"] = "Rodné číslo už existuje.";
					} else
						$this->data["success"] = "Chyba pri vkladaní, skúste znovu.";
				}						
			}
		} else
			$this->pohled = 'chyba';	
	}

	public function new_don() {
		// moze vidiet iba prihlaseny ADMIN
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 2) {
			$this->pohled = 'new_don';
			$this->data["success"] = "";
			$this->hlavicka['titulek'] = 'Pridať Dona';

			$this->data["uzemia"] = Uzemie::getUzemiaBezDona();

			$timeout = 600; // Number of seconds until it times out.

			// Check if the timeout field exists.
			if(isset($_SESSION['timeout'])) {
				// See if the number of seconds since the last
				// visit is larger than the timeout period.
				$duration = time() - (int)$_SESSION['timeout'];
				if($duration > $timeout) {
					// Destroy the session and restart it.
					session_destroy();
					$this->presmeruj("home");
					session_start();
				}
			}
			
			if (!empty($_POST)){
				try {
					$success = Don::insertDon($_POST);
					if ($success != 0)
						$this->data["success"] = "Nový don bol úspešne vložený!";
					elseif (($success == "Rodné číslo už existuje.") || ($success == "Názov famílie už existuje."))
						$this->data["success"] = $success;
					else
						$this->data["success"] = "Chyba pri vkladaní, skúste znovu.";
				} catch (Exception $e) {
					if (strpos($e->getMessage(), 'Duplicate') != false){
					 	$this->data["success"] = "Rodné číslo už existuje.";
					} else
						$this->data["success"] = "Chyba pri vkladaní, skúste znovu.";
				}						
			}
		} else
			$this->pohled = 'chyba';	
	}
}