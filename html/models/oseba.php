<?php
  class Oseba {
    // to so zaenkrat vse spremenljivke kere man v bazi tudi kak stolpce
    public $id;
    public $ime;
    public $priimek;
	public $enaslov;
	public $upime;
	public $geslo;
	public $ELO;

    public function __construct($id, $ime, $priimek,$upime, $geslo, $enaslov, $ELO) {
      $this->id      = $id;
      $this->ime  = $ime;
      $this->priimek = $priimek;
	  $this->upime=$upime;
	  $this->enaslov=$enaslov;
	  $this->geslo = $geslo;
	  $this->ELO = $ELO;
    }

	//funkcija s kero izpišemo vse aktivne uporabnike (ime san samo spremeno, pa pusto potli za klepet :D)
/*    public static function aktiven() {
      $list = [];
      $db = Db::getInstance();
      $result = mysqli_query($db,'SELECT * FROM oseba');

		while($row = mysqli_fetch_assoc($result)){
			 $list[] = new Oseba($row['ID'], $row['ime'], $row['priimek'],$row['upime'], $row['geslo'], $row['enaslov']);
		}
      // we create a list of Post objects from the database results
        return $list;
    }
*/
		//funckija kera dobi ID uporabnika, pa ga najde, za izpis podatkov
    public static function najdi($id) {
      $id = intval($id);
      $db = Db::getInstance();
      $result = mysqli_query($db,"SELECT * FROM oseba where ID=$id");
	  $row = mysqli_fetch_assoc($result);
      return new Oseba($row['ID'], $row['ime'], $row['priimek'],$row['upime'], $row['geslo'], $row['enaslov'], $row['ELO']);
    }
	
	//funkcija za registracijo uporabnika
	//kak parametre damo podatke kere pošlemo iz osebe_controller.php -> shrani() funkcije, $geslo_hash pa je pač hash za geslo kero shranimo v podatkovno bazo
	public static function dodaj($ime,$priimek,$upime,$geslo,$enaslov) {
	  $geslo_hash = password_hash($geslo, PASSWORD_DEFAULT);
      $db = Db::getInstance();
	  
	  $queryCheck = "SELECT * FROM oseba WHERE upime = '$upime'";
	  $check = mysqli_query($db, $queryCheck) or die(mysqli_error($db));
	  
	  if(mysqli_num_rows($check) == 0)
	  {
		mysqli_query($db,"INSERT INTO oseba(ime, priimek, upime, enaslov, geslo, ELO) VALUES ('$ime', '$priimek', '$upime', '$enaslov', '$geslo_hash', 1000)");
		$id=mysqli_insert_id($db);
	  
		//tu je return ID, ka se te zove v osebe_controller.php stran uspesnoDodal.php, pa mamo link do profila uporabnika, zato nucamo njegove podatke(vbistvi samo ID)
		return Oseba::najdi($id);
	  }
	  else
	  {
		return false;
	  }
    }
	
	//funkcija za prijavo uporabnika
	//parametre dobimo iz osebe_controller.php -> prijava()
	public static function prijavi($upime, $geslo)
	{
		$db = Db::getInstance();
		//začnemo sejo, dobimo podatke iz PB (recimo ka nemreta meti istoga imena, kak je že v večini primerov gnesden)
		//Db::sessionStart();
		$result = mysqli_query($db, "SELECT ID, upime, geslo FROM oseba WHERE upime='$upime'");
	
		$row = mysqli_fetch_array($result);
		//tu dobimo isti hash, s kerin smo koderali (ali kak se tumi pravi) geslo, zato ka ga te v if stavki ponucamo za primerjavo
		
		//primerjamo podatke keri so v bazi pa vpisani podatki, password_verify pa je kak san že prej napisao za primerjavo vpisanoga gesla pa hash_gesla iz baze
		if($row[1] == $upime && password_verify($geslo, $row[2]))
		{
			//če smo vpisali prave podatke, shranimo v sejo ID uporabnika (mogoče bi ime?)
			$_SESSION["id"]=$row[0];
			//dobimo id, pa zovemo uspesnaPrijava.php v keroj izpišemo ka smo se prijavili, pa povezava do "home" je not
			//$oseba = Oseba::najdi($row[0]);
			$query = mysqli_query($db, "INSERT INTO osebaAktivna (osebaID) VALUES ('$row[0]')");
			
			error_reporting(E_ALL);
		    require_once('views/osebe/uspesnaPrijava.php');
		}
		else
		{
			//če nejsmo vnesli pravih podatkov, zovemo stran napakaPrijava.php, v keroj je izpis o ton ka smo napačne podatki dali, pa link za nazaj (torej na stran prijavi.php)
		     require_once('views/osebe/napakaPrijava.php');
		}
	}
	
	//funckija za odjavo uporabnika
	//uničimo sejo
	//id pa not dobimo iz osebe_controller.php -> odjavi(), nucali pa mo ga za klepet, kda mo gledali če je dosegljiv oz. ni dosegljiv
	public static function odjavi($id)
	{
		//Db::sessionStart();
		session_destroy();
		$db = Db::getInstance();
		$query = mysqli_query($db, "DELETE FROM osebaAktivna WHERE osebaID = '$id'");
	}
	
	//funkcija za urejanje
	//podatke dobimo iz osebe_controller.php -> uredi()
	//kodiramo spet geslo, pa posodobimo podatke
	//vrnemo id za link do profila kot pri prijavi
	public static function uredi($id,$ime, $priimek, $upime, $geslo, $enaslov)
	{
		$geslo_hash = password_hash($geslo, PASSWORD_DEFAULT);
		$db = Db::getInstance();
		mysqli_query($db, "UPDATE oseba SET ime='$ime', priimek='$priimek', upime='$upime', geslo='$geslo_hash', enaslov='$enaslov' WHERE ID=$id");
		return Oseba::najdi($id);
	}
  }
?>