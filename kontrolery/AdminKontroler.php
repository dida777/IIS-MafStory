<?php 

class AdminKontroler extends Kontroler {
	public function zpracuj($parametry) {
		//len ADMIN
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 2) {
			$this->hlavicka['titulek'] = 'Edit don';
			$this->pohled = 'admin';	

			$this->data["msg_hladanyDon"] = "";
			$this->data["hladanyDon"] = NULL;

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
			
			$this->data["zoznamDonov"] = Don::getZoznamDonov();

			if (!empty($_POST) && isset($_POST["hladany_don"])) {
				if (($this->data["hladanyDon"] = Don::getDon($_POST["hladany_don"])) == NULL)
					$this->data["msg_hladanyDon"] = "Don nenájdený.";
			}
			
			if (isset($parametry[0]) && ($parametry[0] == "new_don"))
				$this->new_don();
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