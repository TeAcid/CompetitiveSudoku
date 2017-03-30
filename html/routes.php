<?php
//funkcija, ki kliče kontrolerje in hkrati vključuje njihovo kodo
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'strani':
        $controller = new StraniController();
      break;
      case 'osebe':
        require_once('models/oseba.php');
        $controller = new OsebeController();
      break;
	  case 'igra':
        require_once('models/igra.php');
        $controller = new IgraController();
      break;
    }

    $controller->{ $action }();
  }
	//tu je pri array osebe dodanih par strani, na kere se te sklicuje pod action
   $controllers = array('strani' => ['domov', 'napaka'],
                       'osebe' => ['profil', 'dodaj','shrani', 'prijava', 'odjavi','uredi', 'urejanje', 'prijatelji', 'obvestila'],
					   'igra' => ['zacetna', 'napaka', 'racunalnik', 'igralec', 'ucenje', 'game', 'replay', 'glej', 'igrajSudoku']);
  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('strani', 'napaka');
    }
  } else {
    call('strani', 'napaka');
  }
?>