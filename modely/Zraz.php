<?php

class Zraz {

	private $id_zrazu;
	private $datum_cas;
	private $usporiadatel;
	private $gps_miesta;

	function __construct () {
		$data = Db::dotazVsechny("SELECT * FROM Zraz WHERE id_zrazu = id_zrazu");
		if($data != NULL) {
			$this->id_zrazu = $data["id_zrazu"];
			$this->datum_cas = $data["datum_cas"];
			$this->usporiadatel = $data["usporiadatel"];
			$this->gps_miesta = $data["gps_miesta"];
		}
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