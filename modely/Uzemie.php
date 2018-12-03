<?php

class Uzemie {

	private $gps;
	private $hodnota;

	function __construct ($gps) {
		$data = Db::dotazJeden("SELECT * FROM Uzemie WHERE gps = ?", [$gps]);
		if($data != NULL) {
			$this->gps = $data["gps"];
			$this->hodnota = $data["hodnota"];
		}
	}

	public static function getUzemiaBezDona(){
		return Db::dotazVsechny("SELECT U.gps, U.hodnota FROM Uzemie U LEFT JOIN Don D ON (U.gps = D.gps_uzemie) WHERE D.gps_uzemie IS NULL");
	}

	public static function getUzemia(){
		return Db::dotazVsechny("SELECT * FROM Uzemie");
	}

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
}