<?php
  class StraniController {
    public function domov() {
      $gregor1 = 'Gregor Ivajnšič';
      $gregor2  = 'Gregor Ivanič';
	  $gregor3 = 'Gregor Kramar';
      require_once('views/strani/domov.php');
    }

    public function napaka() {
      require_once('views/strani/napaka.php');
    }
  }
?>