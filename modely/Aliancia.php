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

	public static function insertAliancie( $post, $nazov_familie_dona){
		$post["familie_v_aliancii"][] = $nazov_familie_dona;
		Db::dotaz("INSERT INTO Aliancia (nazov_aliancie, datum_vzniku) VALUES (?, ?)", [$post["nazov_aliancie"], $post["datum_vzniku"]]); 
		foreach ($post["familie_v_aliancii"] as $jedna_familia) {
			Db::dotaz("UPDATE Don SET aliancia = LAST_INSERT_ID() WHERE nazov_familie = ?",[$jedna_familia]);
		}
		return 1;
	}

	public static function delAliance( $cislo_aliancie){
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