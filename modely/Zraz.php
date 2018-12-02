<?php

class Zraz {

	private $id_zrazu;
	private $datum_cas;
	private $usporiadatel;
	private $gps_miesta;

	function __construct ($id_zrazu) {
		$data = Db::dotazJeden("SELECT * FROM Zraz_donov WHERE id_zrazu = ?", [$id_zrazu["zvolal_zraz"]]);
		if($data != NULL) {
			$this->id_zrazu = $data["id_zrazu"];
			$this->datum_cas = $data["datum_cas"];
			$this->usporiadatel = $data["usporiadatel"];
			$this->gps_miesta = $data["gps_miesta"];
		}
	}

	public static function delZrazu($id_zraz) {
		return Db::dotaz("DELETE FROM Zraz_donov WHERE id_zrazu = ?", [$id_zraz]);
	}

	public static function insertZraz($infos) {
		Db::dotaz("INSERT INTO Zraz_donov (datum_cas, usporiadatel, gps_miesta) VALUES (?, ?, ?) ",[$infos["datum_cas"], $infos["usporiadatel"], $infos["gps_miesta"]]);
		return Db::dotaz("UPDATE Don SET zvolal_zraz = LAST_INSERT_ID() WHERE rodne_cislo = ?", [$infos["usporiadatel"]]);
	}

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
}