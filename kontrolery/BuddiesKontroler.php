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
			
			if (!empty($_POST)){
				try {
					$success = Osoba::insertOsoba($_POST);
					if ($success != 0)
						$this->data["success"] = "Nový člen bol úspešne vložený!";
					else
						$this->data["success"] = "Chyba pri vkladaní, skúste znovu.";
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