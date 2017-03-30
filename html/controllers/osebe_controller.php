<?php
  class OsebeController {
	  //funckija za prikaz profila uporabnika
    public function profil() {
     //če nemamo ID-ja (nejsmo prijavleni), potem izpišemo napako
      if (!isset($_GET['id']))
        return call('strani', 'napaka');

      //sicer pa najdemo osebo z ID-jon pa zovemo stran profil.php v keron so izpisani podatki o uporabniku
      $oseba = Oseba::najdi($_GET['id']);
      require_once('views/osebe/profil.php');		
    }
	
	//funkcija za dodajanje uporabnika
	//izvede se kda kliknemo na gumb registracija
	//zove pa stran dodaj.php, v keron je obrazec za vnos podatkov
	public function dodaj() {
		require_once('views/osebe/dodaj.php');
	}
	
	//funkcija za dodajanje
	//izvede se kda kliknemo na dodaj
	//kličemo funkcijo dodaj v dokumenti oseba.php in vklučimo podatke kere smo vpisali v obrazec
	//kda se izvede, se odpre stran uspesnoDodal.php v keron nas obvesti o uspehi, pa link je do profila uporabnika
	public function shrani() {
		$oseba=Oseba::dodaj($_POST["ime"],$_POST["priimek"],$_POST["upime"],$_POST["geslo"],$_POST["enaslov"]);
		if(!$oseba)
		{
			require_once('views/osebe/napakaRegistracija.php');
		}
		else
		{
			require_once('views/osebe/uspesnoDodal.php');
		}
	}
	
	//funkcija za prijavo
	//izvede se kda kliknemo na gumb prijava na strani prijava.php
	//zove se funkcija prijavi v dokumenti oseba.php, s podatki kere smo vnesli (po kliki pa mamo if else stavek v funkciji, zato se tu ne zgodi nič več)
	public function prijava(){
		$oseba=Oseba::prijavi($_POST['upime'],$_POST['geslo']);
	}
	
	//funkcija za odjavo
	//izvede se če kliknemo na gumb Da
	//v linki mamo tudi ID od uporabnika, za klepet (ka mo znali kda se odjavi in spremenimo te podatke)
	//zove se strani odjavaUspesna.php, v keron je napisano ka smo se uspešno odjavili, pa link do "home"
	public function odjavi(){
		$oseba=Oseba::odjavi($_GET['id']);
		require_once('views/osebe/odjavaUspesna.php');
	}
	
	//funckiaj za urejanje
	//izvede se ko kliknemo na gumb Uredi
	//zove se stran uredi.php, v kateri je izpoljnjen obrazec s trenutnimi podatki
	public function uredi(){
		$oseba=Oseba::najdi($_GET['id']);
		require_once('views/osebe/uredi.php');
	}
	
	//funckija za urejanje
	//izvede se ko kliknemo na gumb Uredi na strani uredi.php
	//zove se funkcija uredi() v dokumentu oseba.php s podatki
	//na koncu še zovemo stran za uspešno ureditev podatkov in link do profila
	public function urejanje(){
		$oseba=Oseba::uredi($_GET['id'],$_POST["ime"],$_POST["priimek"],$_POST["upime"],$_POST["geslo"],$_POST["enaslov"]);
		require_once('views/osebe/urejanjeUspesno.php');
	}
	
	public function prijatelji() {
	  require_once('views/osebe/prijatelji.php');
	}
	
	public function obvestila(){
		require_once('views/osebe/obvestila.php');
	}
  }
?>