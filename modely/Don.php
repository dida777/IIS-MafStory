<?php

class Don {

	private $rodne_cislo;
	private $nazov_familie;
	private $gps_uzemie;
	private $aliancia;

	function __construct ($rodne_cislo) {
		$data = Db::dotazJeden("SELECT * FROM Don WHERE rodne_cislo = ?", [$rodne_cislo]);
		if($data != NULL) {
			$this->rodne_cislo = $data["rodne_cislo"];
			$this->nazov_familie = $data["nazov_familie"];
			$this->gps_uzemie = $data["gps_uzemie"];
			$this->aliancia = $data["aliancia"];
		}
	}

	public static function getZadavatelZraz(){
		return Db::dotazVsechny("SELECT D.rodne_cislo FROM Don JOIN Zraz ON rodne_cislo = usporiadatel");
	}

	public static function getAllFamilia($rod_cislo){
		return Db::dotazVsechny("SELECT nazov_familie FROM Don WHERE aliancia IS NULL AND rodne_cislo != ?", [$rod_cislo]);
	}

	public static function deleteAliancia($r_cislo_dona, $id_aliancie){
		$r_cisla_donov = Db::dotazVsechny("SELECT D.rodne_cislo FROM Don D WHERE D.aliancia = ? ", [$id_aliancie]);
		
		try {
			foreach ($r_cisla_donov as $jeden_don) {
				Db::dotaz("UPDATE Don SET aliancia = ? WHERE rodne_cislo = ?", [NULL, $jeden_don["rodne_cislo"]]);
			}
			var_dump($id_aliancie);
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

}