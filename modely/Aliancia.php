<?php

class Aliancia {

	private $id_aliancie;
	private $nazov_aliancie;
	private $datum_vzniku;

	function __construct ($id_aliancie) {
		$data = Db::dotazJeden("SELECT * FROM Aliancia WHERE id_aliancie = ?", [$id_aliancie]);
		if($data != NULL) {
			$this->id_aliancie = $data["id_aliancie"];
			$this->nazov_aliancie = $data["nazov_aliancie"];
			$this->datum_vzniku = $data["datum_vzniku"];
		}
	}

	public static function delAliance($cislo_aliancie){
		var_dump($cislo_aliancie);
		return Db::dotaz("DELETE FROM Aliancia WHERE id_aliancie = ?", [$cislo_aliancie]);
	}

	public function getIdAliancie() {
		return $this->id_aliancie;
	}

	public function setIdAliancie( $id_aliancie) {
		$this->id_aliancie = $id_aliancie;
	}
	
	public function getNazovAliancie() {
		return $this->nazov_aliancie;
	}

	public function setNazovAliancie( $nazov_aliancie) {
		$this->nazov_aliancie = $nazov_aliancie;
	}

	public function getDatumVzniku() {
		return $this->datum_vzniku;
	}

	public function setDatumVzniku( $datum_vzniku) {
		$this->datum_vzniku = $datum_vzniku;
	}
}