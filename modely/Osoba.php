<?php

class Osoba {

	private $rodne_cislo;
	private $heslo;
	private $meno;
	private $priezvisko;
	private $vek;
	private $typ; // 1 - don, 0 - clen

	public static function getOsoba($hladana_osoba){ // hladana osoba = rodne cislo, meno, priezvisko
		$osoby;
		if (is_numeric($hladana_osoba)) {
			$osoby = Db::dotazVsechny("SELECT rodne_cislo, meno, priezvisko, vek, typ FROM Osoba WHERE rodne_cislo = ?", [$hladana_osoba]);
		} else {
			$osoby = Db::dotazVsechny("SELECT rodne_cislo, meno, priezvisko, vek, typ FROM Osoba WHERE (meno = ? || priezvisko = ?)", [$hladana_osoba, $hladana_osoba]);
		}
		return $osoby;
	}

	public static function insertOsoba($new_buddy){
		$typ = 0;
		Db::dotaz("INSERT INTO Osoba (rodne_cislo, heslo, meno, priezvisko, vek, typ) VALUES (?, ?, ?, ?, ?, ?)", [$new_buddy["rodne_cislo"], $new_buddy["heslo"], $new_buddy["meno"], $new_buddy["priezvisko"], $new_buddy["vek"], $typ]);
		return Clen::insertClen($new_buddy);
	}

	public static function getZoznamOsob(){ // hladana osoba = rodne cislo, meno, priezvisko
		return Db::dotazVsechny("SELECT rodne_cislo, meno, priezvisko, vek, typ FROM Osoba");
	}

	function __construct ($rodne_cislo = NULL) {
		$data = Db::dotazJeden("SELECT * FROM Osoba WHERE rodne_cislo = ?", [$rodne_cislo]);
		if($data != NULL) {
			$this->rodne_cislo = $data["rodne_cislo"];
			$this->heslo = $data["heslo"];
			$this->meno = $data["meno"];
			$this->priezvisko = $data["priezvisko"];
			$this->vek = $data["vek"];
			$this->typ = $data["typ"];
		}
	}

	public function getRodneCislo() {
		return $this->rodne_cislo;
	}

	public function setRodneCislo( $rodne_cislo) {
		$this->rodne_cislo = $rodne_cislo;
	}

	public function getHeslo() {
		return $this->heslo;
	}

	public function getMeno() {
		return $this->meno;
	}

	public function setMeno( $meno) {
		$this->meno = $meno;
	}

	public function getPriezvisko() {
		return $this->priezvisko;
	}

	public function setPriezvisko( $priezvisko) {
		$this->priezvisko = $priezvisko;
	}

	public function getVek() {
		return $this->vek;
	}

	public function setVek( $vek) {
		$this->vek = $vek;
	}


	public function getTyp() {
		return $this->typ;
	}

	public function setTyp( $typ) {
		$this->typ = $typ;
	}

}