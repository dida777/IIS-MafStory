<?php

class Uzemie {

	private $gps;
	private $hodnota;

	/*function __construct ($rodne_cislo) {
		$data = Db::dotazJeden("SELECT * FROM Osoba WHERE rodne_cislo = ?", [$rodne_cislo]);
		if($data != NULL) {
			$this->rodne_cislo = $data["rodne_cislo"];
			$this->heslo = $data["heslo"];
			$this->meno = $data["meno"];
			$this->priezvisko = $data["priezvisko"];
			$this->vek = $data["vek"];
		} else {
			echo "dačo je napiču, vypis chybovu hlasku";
		}
	}*/

	public function getGps() {
		return $this->gps;
	}

	public function setGps( $gps) {
		$this->gps = $gps;
	}
	
	public function getHodnota() {
		return $this->hodnota;
	}

	public function setHodnota( $hodnota) {
		$this->hodnota = $hodnota;
	}