<?php

class Zraz {

	private $id_zrazu;
	private $datum_cas;
	private $usporiadatel;
	private $gps_miesta;

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

	public function getIdZrazu() {
		return $this->id_zrazu;
	}

	public function setIdZrazu( $id_zrazu) {
		$this->id_zrazu = $id_zrazu;
	}
	
	public function getDatumCas() {
		return $this->datum_cas;
	}

	public function setDatumCas( $datum_cas) {
		$this->datum_cas = $datum_cas;
	}

	public function getUsporiadatel() {
		return $this->usporiadatel;
	}

	public function setUsporiadatel( $usporiadatel) {
		$this->usporiadatel = $usporiadatel;
	}

	public function getGpsMiesta() {
		return $this->gps_miesta;
	}

	public function setGpsMiesta( $gps_miesta) {
		$this->gps_miesta = $gps_miesta;
	}