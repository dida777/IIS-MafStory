<?php
// Controller pro zpracování článku

class ChybaKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
		// Hlavička požadavku
		header("HTTP/5.0 404 Not Found");
		// Hlavička stránky
		$this->hlavicka['titulek'] = 'Chyba 404';
		// Nastavení šablony
		$this->pohled = 'chyba';
    }
}
//source www.itnetwork.cz
