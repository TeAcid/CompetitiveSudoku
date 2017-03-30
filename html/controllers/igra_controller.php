<?php
  class IgraController {
    public function zacetna() {
      require_once('views/igra/zacetna.php');
    }

    public function napaka() {
      require_once('views/strani/napaka.php');
    }
	
	public function racunalnik() {
	  Igra::racunalnik();
      require_once('views/igra/racunalnik.php');
    }
	
	public function igralec() {
		Igra::igralec();
      require_once('views/igra/igralec.php');
    }
	
	public function ucenje() {
	  require_once('views/igra/učenje.php');
	}
	
	public function game(){
		require_once('views/igra/game.php');
	}
	
	public function replay(){
		require_once('views/igra/replay.php');
	}
	
	public function glej(){
		require_once('views/igra/glej.php');
	}
	
	public function igrajSudoku() {
      require_once('views/igra/igrajSudoku.php');
    }
  }
?>