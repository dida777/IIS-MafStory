<?php 

class ToDoListKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny clovek
		if (isset($_SESSION["rodne_cislo"])) {
			$this->hlavicka['titulek'] = 'ToDo List';
			$this->pohled = 'todolist';	
			$this->data["ulohy"] = "";

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

			// prihlaseny je DON
			if ($_SESSION["typ"] == 1) {
				$don = new Don($_SESSION["rodne_cislo"]);
				$aliancia = new Aliancia($don->getAliancia());
				$this->data["ulohy"] = Uloha::getDonUlohy($_SESSION["rodne_cislo"], $aliancia->getIdAliancie());
			} else {
				$this->data["ulohy"] = Uloha::getClenUlohy($_SESSION["rodne_cislo"]);
			}

			// prihlaseny je DON
			if ($_SESSION["typ"] == 1) {
				if (isset($parametry[0]) && ($parametry[0] == "new_work"))
					$this->new_work();
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

	public function new_work() {
		// iba pre prihlasenych
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 1) {
			$this->pohled = 'new_work';
			$this->data["success"] = "";
			$this->hlavicka['titulek'] = 'Zadať novú úlohu';
			$this->data["don"] = new Don($_SESSION["rodne_cislo"]);
			$familia = $this->data["don"]->getNazovFamilie();
			$this->data["zoz_vykon"] = Don::getZoznamVykonavatelov($familia);
			$this->data["uzemia"] = Uzemie::getUzemia();

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

			if (!empty($_POST)){
				try {
					$success = Uloha::insertUloha($_POST, $_SESSION["rodne_cislo"]);
					if ($success != 0)
						$this->data["success"] = "Nová úloha bola úspešne zadaná!";
				} catch (Exception $e) {
					if (strpos($e->getMessage(), 'Duplicate') !== false){
					 	$this->data["success"] = "Špecifické meno úlohy už existuje.";
					} elseif (strpos($e->getMessage(), 'uzemie') !== false){
					 	$this->data["success"] = "Zadané územie neexistuje.";
					} elseif (strpos($e->getMessage(), 'clen') !== false){
					 	$this->data["success"] = "Zadaný vykonávateľ neexistuje.";
					} else
						$this->data["success"] = "Chyba pri zadávaní, skúste znovu.";
				}
			}						
		} else
			$this->pohled = 'chyba';
	}

	public function zacatUlohu() {
		// iba pre prihlasenych
		if (isset($_SESSION["rodne_cislo"])) {
			Uloha::updateCasZaciatku($_POST["specificke_meno"], $_POST["cas_zaciatku"]);
			$this->presmeruj("todolist");
		} else
			$this->pohled = 'chyba';
	}

	public function ukoncitUlohu() {	
		// iba pre prihlasenych	
		if (isset($_SESSION["rodne_cislo"])) {
			Uloha::updateCasKonca($_POST["specificke_meno"], $_POST["cas_konca"], $_POST["uspesnost"], $_POST["komentar"]);
			$this->presmeruj("todolist");
		} else
			$this->pohled = 'chyba';
	}
}