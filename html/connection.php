<?php
  class Db {
    private static $instance = NULL;
	private static $session = NULL;
	
    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
      if (!isset(self::$instance)) {
       
        self::$instance = mysqli_connect("localhost", "root", "ivkriv1995", "Projekt");
      }
      return self::$instance;
    }
	//tu sem dodal funckijo sessionStart, da jo pokličemo ko želimo da se začne
	public static function sessionStart(){
	if(!isset(self::$session)){
		self::$session = session_start();
	}
		return self::$session;
	}
  }
?>