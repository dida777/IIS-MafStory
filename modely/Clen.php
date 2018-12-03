<?php

class Clen {

	private $rodne_cislo;
	private $familia;
	private $hodnost;
	private $pokrvna_vazba;

	function __construct ($rodne_cislo = NULL) {
		$data = Db::dotazJeden("SELECT * FROM Clen WHERE rodne_cislo = ?", [$rodne_cislo]);
		if($data != NULL) {
			$this->rodne_cislo = $data["rodne_cislo"];
			$this->familia = $data["familia"];
			$this->hodnost = $data["hodnost"];
			$this->pokrvna_vazba = $data["pokrvna_vazba"];
		}
	}

	public static function getZoznamClenov($familia) {
		return Db::dotazVsechny("SELECT C.rodne_cislo, meno, priezvisko, hodnost FROM Clen C JOIN Osoba O ON C.rodne_cislo = O.rodne_cislo WHERE C.familia = ?", [$familia]);
	}

	public static function insertClen($new_buddy) {
		$success = "";
		try {
			Osoba::insertOsoba($new_buddy);
		} catch (Exception $e) {
			if (strpos($e->getMessage(), 'Duplicate') != false){
				$success = "Rodné číslo už existuje.";
				return $success;
			}
		}
		return Db::dotaz("INSERT INTO Clen (rodne_cislo, familia, hodnost, pokrvna_vazba) VALUES (?, ?, ?, ?)", [$new_buddy["rodne_cislo"], $new_buddy["nazov_familie"], $new_buddy["hodnost"], $new_buddy["pokrvna_vazba"]]);
	}

	public static function zmenaHodnosti($rodne_cislo, $hodnost) {
		return Db::dotaz("UPDATE Clen SET hodnost = ? WHERE rodne_cislo = ?", [$hodnost, $rodne_cislo]);
	}
	public static function zmenaPokrvnaVazba($rodne_cislo, $pokrvna_vazba) {
		return Db::dotaz("UPDATE Clen SET pokrvna_vazba = ? WHERE rodne_cislo = ?", [$pokrvna_vazba, $rodne_cislo]);
	}

	public function getRodneCislo() {
		return $this->rodne_cislo;
	}

	public function setRodneCislo( $rodne_cislo) {
		$this->rodne_cislo = $rodne_cislo;
	}
	
	public function getHodnost() {
		return $this->hodnost;
	}

	public function setHodnost( $hodnost) {
		$this->hodnost = $hodnost;
	}

	public function getFamilia() {
		return $this->familia;
	}

	public function setFamilia( $familia) {
		$this->familia = $familia;
	}

	public function getPokrvnaVazba() {
		return $this->pokrvna_vazba;
	}

	public function setPokrvnaVazba( $pokrvna_vazba) {
		$this->pokrvna_vazba = $pokrvna_vazba;
	}
}