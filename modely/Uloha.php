<?php

class Uloha {

	private $specificke_meno;
	private $popis_cinnosti;
	private $vykonavatel;
	private $zadavatel_don;
	private $zadavatel_aliancia;
	private $gps_miesta;
	private $cas_zaciatku;
	private $cas_konca;
	private $uspesnost;
	private $komentar;

	function __construct ($data) {
		if($data != NULL) {
			$this->specificke_meno = $data["specificke_meno"];
			$this->popis_cinnosti = $data["popis_cinnosti"];
			$this->vykonavatel = $data["vykonavatel"];
			$this->zadavatel_don = $data["zadavatel_don"];
			$this->zadavatel_aliancia = $data["zadavatel_aliancia"];
			$this->gps_miesta = $data["gps_miesta"];
			$this->cas_zaciatku = $data["cas_zaciatku"];
			$this->cas_konca = $data["cas_konca"];
			$this->uspesnost = $data["uspesnost"];
			$this->komentar = $data["komentar"];
		} 
	}

	public static function updateCasZaciatku($specificke_meno, $cas_zaciatku) {
		Db::dotaz("UPDATE Uloha SET cas_zaciatku = ? WHERE specificke_meno = ?", [$cas_zaciatku, $specificke_meno]);
	}

	public static function updateCasKonca($specificke_meno, $cas_konca) {
		Db::dotaz("UPDATE Uloha SET cas_konca = ? WHERE specificke_meno = ?", [$cas_konca, $specificke_meno]);
	}

	public static function getDonUlohy($don, $aliancia) {
		$data = [];
		if ($don != NULL) {
			$data = Db::dotazVsechny("SELECT * FROM Uloha WHERE zadavatel_don = ?", [$don]);
		}

		if ($aliancia != NULL) {
			$data = array_merge($data, Db::dotazVsechny("SELECT * FROM Uloha WHERE zadavatel_aliancia = ?", [$aliancia]));
		}
		return $data;
	}

	public static function getClenUlohy($clen) {
		if ($clen != NULL) {
			return Db::dotazVsechny("SELECT * FROM Uloha WHERE vykonavatel = ?", [$clen]);
		}
	}

	public function getSpecifickeMeno() {
		return $this->specificke_meno;
	}

	public function setSpecifickeMeno( $specificke_meno) {
		$this->specificke_meno = $specificke_meno;
	}

	public function getPopisCinnosti() {
		return $this->popis_cinnosti;
	}

	public function setPopisCinnosti( $popis_cinnosti) {
		$this->popis_cinnosti = $popis_cinnosti;
	}

	public function getVykonavatel() {
		return $this->priezvisko;
	}

	public function setVykonavatel( $vykonavatel) {
		$this->vykonavatel = $vykonavatel;
	}

	public function getZadavatelDon() {
		return $this->zadavatel_don;
	}

	public function setZadavatelDon( $zadavatel_don) {
		$this->zadavatel_don = $zadavatel_don;
	}

	public function getZadavatelAliancia() {
		return $this->zadavatel_aliancia;
	}

	public function setZadavatelAliancia( $zadavatel_aliancia) {
		$this->zadavatel_aliancia = $zadavatel_aliancia;
	}

	public function getGpsMiesta() {
		return $this->gps_miesta;
	}

	public function setGpsMiesta( $gps_miesta) {
		$this->gps_miesta = $gps_miesta;
	}

	public function getCasZaciatku() {
		return $this->cas_zaciatku;
	}

	public function setCasZaciatku( $cas_zaciatku) {
		$this->cas_zaciatku = $cas_zaciatku;
	}

	public function getCasKonca() {
		return $this->cas_konca;
	}

	public function setCasKonca( $cas_konca) {
		$this->cas_konca = $cas_konca;
	}

	public function getUspesnost() {
		return $this->uspesnost;
	}

	public function setUspesnost( $uspesnost) {
		$this->uspesnost = $uspesnost;
	}

	public function getKomentar() {
		return $this->komentar;
	}

	public function setKomentar( $komentar) {
		$this->komentar = $komentar;
	}
}