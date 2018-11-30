<?php

class Don {

	private $rodne_cislo;
	private $nazov_familie;
	private $gps_uzemie;
	private $aliancia;

	public static function getSefFamilie($familia) {
		return Db::dotazJeden("SELECT O.meno, O.priezvisko FROM Don D JOIN Osoba O ON D.rodne_cislo = O.rodne_cislo WHERE D.nazov_familie = ? ", [$familia]);
	}

	function __construct ($rodne_cislo) {
		$data = Db::dotazJeden("SELECT * FROM Don WHERE rodne_cislo = ?", [$rodne_cislo]);
		if($data != NULL) {
			$this->rodne_cislo = $data["rodne_cislo"];
			$this->nazov_familie = $data["nazov_familie"];
			$this->gps_uzemie = $data["gps_uzemie"];
			$this->aliancia = $data["aliancia"];
		}
	}

	public function getRodneCislo() {
		return $this->rodne_cislo;
	}

	public function setRodneCislo( $rodne_cislo) {
		$this->rodne_cislo = $rodne_cislo;
	}

	public function getNazovFamilie() {
		return $this->nazov_familie;
	}

	public function setNazovFamilie( $nazov_familie) {
		$this->nazov_familie = $nazov_familie;
	}

	public function getGpsUzemie() {
		return $this->gps_uzemie;
	}

	public function setGpsUzemie( $gps_uzemie) {
		$this->gps_uzemie = $gps_uzemie;
	}

	public function getAliancia() {
		return $this->aliancia;
	}

	public function setAliancia( $aliancia) {
		$this->aliancia = $aliancia;
	}

}