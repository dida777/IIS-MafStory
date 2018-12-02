<?php 

class MeetingKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny don
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 1) {
			$this->hlavicka['titulek'] = 'Meeting';
			$this->pohled = 'meeting';	
			$this->data["r_cislo"] = $_SESSION["rodne_cislo"];
			$this->data["uzemia"] = Uzemie::getUzemia();
			$this->data["success"] = "";


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

			$this->data["uzemia"] = Uzemie::getUzemia();

			if (!empty($_POST)){
				try {
					$success = Zraz::insertZraz($_POST);
					if ($success != 0)
						$this->data["success"] = "Zraz bol zadaný.";
				} catch (Exception $e) {
					var_dump($e->getMessage());
					$this->data["success"] = "Chyba pri zadávaní, skúste znovu.";
				}
			}
		}
		else
			$this->pohled = 'chyba';
	}
}