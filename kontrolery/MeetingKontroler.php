<?php 

class MeetingKontroler extends Kontroler {
	public function zpracuj($parametry) {
		// moze vidiet iba prihlaseny
		if (isset($_SESSION["rodne_cislo"])) {
			if($_SESSION["typ"] == 1){ //don
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
			
			} elseif($_SESSION["typ"] == 2){ //admin
				$this->hlavicka['titulek'] = 'Edit meetings';
				$this->pohled = 'meeting_admin';

				$don = new Don($_SESSION["rodne_cislo"]);

				$idcka_zrazov = Don::getIdZraz();
				$this->data["pocet_zrazov"] = count($idcka_zrazov);

				foreach ($idcka_zrazov as $zvolalZraz) {
					$this->data["zraz_donov"] = new Zraz($zvolalZraz["zvolal_zraz"]);
					$this->data["info_miesta"][] = $this->data["zraz_donov"]->getGpsMiesta();
					$this->data["info_id"][] = $this->data["zraz_donov"]->getIdZrazu();
					$this->data["info_datumcas"][] = $this->data["zraz_donov"]->getDatumCas();
					$this->data["usporiadatel"][] = Osoba::getOsoba($this->data["zraz_donov"]->getUsporiadatel());
				}

				if (isset($parametry[0]) && $parametry[0] == "edit_zraz") {
					$this->meeting_admin_edit();	
				}

				

			} else
				$this->pohled = 'chyba';
		}else
			$this->pohled = 'chyba';
	}

	public function meeting_admin_edit() {
		if (isset($_SESSION["rodne_cislo"]) && $_SESSION["typ"] == 2) {
			$this->hlavicka['titulek'] = 'Editing meeting';
			$this->pohled = 'meeting_admin_edit';
			$this->data["uzemia"] = Uzemie::getUzemia();
			$this->data["success"] = "";
			$this->data["dat_zraz"] = "";
			$this->data["gps_zraz"] = "";

			if (!empty($_POST) && isset($_POST["id_zrazu"])) { // v $POST mam id_zrazu
				$this->data["zraz_new"] = new Zraz($_POST["id_zrazu"]);
				$this->data["usporiadatel_zraz"] = $this->data["zraz_new"]->getUsporiadatel();
				$this->data["id_zraz"] = $this->data["zraz_new"]->getIdZrazu();
				$this->data["dat_zraz"] = $this->data["zraz_new"]->getDatumCas();
				$this->data["gps_zraz"] = $this->data["zraz_new"]->getGpsMiesta();

			}

			if (!empty($_POST) && isset($_POST["id_zraz"]) && isset($_POST["datum_cas"]) && ($_POST["datum_cas"] != $this->data["dat_zraz"])){
				if(Zraz::updateCas($_POST["id_zraz"], $_POST["datum_cas"]) != 0)
					$this->data["success"] = "Informácie boli upravené.";
				else
					$this->data["success"] = "Informácie sa nepodarilo upraviť.2";
			}

			if(!empty($_POST) && isset($_POST["id_zraz"]) && isset($_POST["gps_miesta"]) && ($this->data["gps_zraz"] != $_POST["gps_miesta"])){
				if(Zraz::updateMiesto($_POST["id_zraz"], $_POST["gps_miesta"]) != 0)
					$this->data["success"] = "Informácie boli upravené.";
				else
					$this->data["success"] = "Informácie sa nepodarilo upraviť.1";
			}

		}else
			$this->pohled = 'chyba';
	}
}