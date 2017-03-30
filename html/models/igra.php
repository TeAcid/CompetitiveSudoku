<?php
  class Igra {
    // to so zaenkrat vse spremenljivke kere man v bazi tudi kak stolpce
    public $igralec1;
    public $igralec2;

    public function __construct($igralec1, $igralec2) {
      $this->igralec1  = $igralec1;
      $this->igralec2 = $igralec2;
    }

		//funckija kera dobi ID uporabnika, pa ga najde, za izpis podatkov
    public static function zacetna() {

    }
	
    public static function igralec() {
		$db = Db::getInstance();
		$query = mysqli_query($db, "INSERT INTO lobby(igralecID) VALUES ('$_SESSION[id]')");
    }

    public static function racunalnik() {
		$db = Db::getInstance();
		//Db::sessionStart();
		$result = mysqli_query($db,"CALL newGame('$_SESSION[id]')");
    }
	
	public static function replay() {

    }
  }
?>