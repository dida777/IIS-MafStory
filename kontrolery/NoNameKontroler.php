<?php 

class NoNameKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny don
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 1) {
			$this->hlavicka['titulek'] = 'No Name';
			$this->pohled = 'noname';	

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
		}
		else
			$this->pohled = 'chyba';
	}
}