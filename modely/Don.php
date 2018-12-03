<?php

class Don {

	private $rodne_cislo;
	private $nazov_familie;
	private $gps_uzemie;
	private $aliancia;
	private $zvolal_zraz;

	function __construct ($rodne_cislo) {
		$data = Db::dotazJeden("SELECT * FROM Don WHERE rodne_cislo = ?", [$rodne_cislo]);
		if($data != NULL) {
			$this->rodne_cislo = $data["rodne_cislo"];
			$this->nazov_familie = $data["nazov_familie"];
			$this->gps_uzemie = $data["gps_uzemie"];
			$this->aliancia = $data["aliancia"];
			$this->zvolal_zraz = $data["zvolal_zraz"];
		}
	}

	public static function insertDon($new_don) {
		foreach (Db::dotazVsechny("SELECT nazov_familie FROM Don") as $every) {
			$family_names[] = $every["nazov_familie"];
		}

		$notuniq_family_name = in_array($new_don["nazov_familie"], $family_names); // kontroluje unikatnost nazvu rodiny

		if (!$notuniq_family_name) {
			try {
				Osoba::insertOsoba($new_don);
			} catch (Exception $e) {
				if (strpos($e->getMessage(), 'Duplicate') != false){
					return "Rodné číslo už existuje.";
					
				}
			}
			
			return Db::dotaz("INSERT INTO Don (rodne_cislo, nazov_familie, gps_uzemie, , aliancia, zvolal_zraz) VALUES (?, ?, ?, ?, ?)", [$new_don["rodne_cislo"], $new_don["nazov_familie"], $new_don["gps_uzemie"], NULL, NULL]);
		} else
			return "Názov famílie už existuje.";
	}

	public static function getDon($hladany_don){ // hladany don = rodne cislo, nazov familie
		$donovia;
		if ($hladany_don != "admin") {
			if (is_numeric($hladany_don)) {
				$donovia = Db::dotazJeden("SELECT rodne_cislo, nazov_familie FROM Don WHERE rodne_cislo = ?", [$hladany_don]);
			} else {
				$donovia = Db::dotazJeden("SELECT rodne_cislo, nazov_familie FROM Don WHERE nazov_familie = ?", [$hladany_don]);
			}
		} else
			$donovia = NULL;
		return $donovia;
	}

	public static function getZoznamDonov(){ // zoznam vsetkych donov
		return Db::dotazVsechny("SELECT rodne_cislo, nazov_familie FROM Don");
	}

	public static function getIdZraz(){
		return Db::dotazVsechny("SELECT zvolal_zraz FROM Don WHERE zvolal_zraz IS NOT NULL");
	}

	public static function getAllFamilia($rod_cislo){
		return Db::dotazVsechny("SELECT nazov_familie FROM Don WHERE aliancia IS NULL AND rodne_cislo != ?", [$rod_cislo]);
	}

	public static function deleteZraz($r_cislo_dona, $id_zrazu){
		try {
			Db::dotaz("UPDATE Don SET zvolal_zraz = ? WHERE rodne_cislo = ?", [NULL, $r_cislo_dona]);
			Zraz::delZrazu($id_zrazu);
		} catch (Exception $e) {
			return 0;
		}	
		return 1;
	}

	public static function deleteAliancia($r_cislo_dona, $id_aliancie){
		$r_cisla_donov = Db::dotazVsechny("SELECT D.rodne_cislo FROM Don D WHERE D.aliancia = ? ", [$id_aliancie]);
		
		try {
			foreach ($r_cisla_donov as $jeden_don) {
				Db::dotaz("UPDATE Don SET aliancia = ? WHERE rodne_cislo = ?", [NULL, $jeden_don["rodne_cislo"]]);
			}
			Aliancia::delAliance($id_aliancie);
		} catch (Exception $e) {
			return 0;
		}	
		return 1;
	}

	public static function getSefFamilie($familia) {
		return Db::dotazJeden("SELECT O.meno, O.priezvisko FROM Don D JOIN Osoba O ON D.rodne_cislo = O.rodne_cislo WHERE D.nazov_familie = ? ", [$familia]);
	}

	public static function getZoznamVykonavatelov($familia) {
		return Db::dotazVsechny("SELECT O.meno, O.priezvisko, O.rodne_cislo FROM Clen C JOIN Osoba O ON C.rodne_cislo = O.rodne_cislo WHERE C.familia = ? ", [$familia]);
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

	public function getZvolalZraz() {
		return $this->zvolal_zraz;
	}

	public function setZvolalZraz( $zvolal_zraz) {
		$this->zvolal_zraz = $zvolal_zraz;
	}

}