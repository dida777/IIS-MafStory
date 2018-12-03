<?php 

class MeetingKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny DON alebo ADMIN
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] != 0) {
			$this->hlavicka['titulek'] = 'Meeting';
			$this->pohled = 'meeting';	
			$this->data["r_cislo"] = $_SESSION["rodne_cislo"];
			$this->data["uzemia"] = Uzemie::getUzemia();
			$this->data["success"] = "";

			$don = new Don($_SESSION["rodne_cislo"]);
			$this->data["uz_zadany"] = $don->getZvolalZraz();


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

			if (isset($_POST) && isset($_POST["new_zraz"])){
				try {
					$success = Zraz::insertZraz($_POST);
					if ($success != 0)
						$this->data["success"] = "Zraz bol zadaný.";
				} catch (Exception $e) {
					// var_dump($e->getMessage());
					if (strpos($e->getMessage(), 'uzemie') !== false)
					 	$this->data["success"] = "Zadané územie neexistuje.";
					else
						$this->data["success"] = "Chyba pri zadávaní, skúste znovu.";
				}
			}

			if (isset($_POST) && isset($_POST["del_zraz"])) {
					try {
						$delete = Don::deleteZraz($_SESSION["rodne_cislo"], $this->data["uz_zadany"]);
						if ($delete != 0)
							$this->data["success"] = "Zraz bol zrušený.";
					} catch (Exception $e) {
						$this->data["success"] = "Zraz sa napodarilo zrušiť!";
					}
					
				}
		}
		else
			$this->pohled = 'chyba';
	}
}