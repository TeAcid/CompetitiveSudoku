<?php
/*
// poteza in polje za testne namene
$polje = array (
array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
array ( 0, 0, 1, 0, 0, 0, 0, 0 ),
array ( 0, 0, 0, 0, 0, 0, 2, 0 ),
array ( 0, 0, 0, 0, 0, 0, 1, 0 ),
array ( 0, 2, 0, 0, 2, 0, 0, 0 ),
array ( 0, 1, 0, 0, 1, 0, 0, 0 ),
array ( 0, 0, 0, 0, 0, 0, 0, 0 ), );
	
$prejeto = zmaga($polje); // primer klica funkcije

if ($prejeto->Zmaga == true) // testni nameni
{
	echo '<script language="javascript">';
	echo 'alert("Dobljen true.")';
	echo '</script>';
}
if ($prejeto->Zmaga == false)
{
	echo '<script language="javascript">';
	echo 'alert("Dobljen false.")';
	echo '</script>';
}
*/
class Zmaga
{
    public $Zmagovalec;
    public $Zmaga;
			
	public function __construct($zmagovalec,$zmaga) // konstruktor
	{
		$this->Zmagovalec = $zmagovalec;
		$this->Zmaga = $zmaga;
	}
}

function zmaga($polje) {

    // mozne poteze obeh igralcev in absolutni zmagovalec, ki igralec postane če pride na drugo stran igralnega polja
    $mozne_crni = 0;
    $mozne_beli = 0;
	$absolutni_zmagovalec = 0;
	
	// preverjanje ce je kdo prisel na drugo stran in z tem zmagal
	for ($j = 1; $j < 9; $j++)
	{
		if ($polje[0][$j-1] == 1)
		{
			$absolutni_zmagovalec = 1;
		}
		else if($polje[7][$j-1] == 2)
		{
			$absolutni_zmagovalec = 2;
		}
	}

    for ($i = 1; $i < 9; $i++ ) // grem skozi vse vrstice
    {
        for ($j = 1; $j < 9; $j++ ) // in vse stolpce
        {
            switch ($polje[$i-1][$j-1]) // ter switch stavek za vsako polje
            {
                case 1:
                    //----------------------------------------------BELE FIGURICE----------------------------------------------
                    if ($polje[$i - 2][$j - 1] == 0) // ce beli lahko gre naprej z to figuro
                    {
                        $mozne_beli++;
                    }
                    if($j == 1) // omejitve da ne grem out-of-bound - levi rob
                    {
                        if ($polje[$i - 2][$j] == 2) // če lahko poje kmeta na desni diagonali
                        {
                            $mozne_beli++;
                        }
                    }
                    else if ($j == 8) // omejitve da ne grem out-of-bound - desni rob
                    {
                        if ($polje[$i - 2][$j - 2] == 2) // če lahko poje kmeta na levi diagonali
                        {
                            $mozne_beli++;
                        }
                    }
                    else
                    {
                        if ($polje[$i - 2][$j] == 2 || $polje[$i - 2][$j - 2] == 2) // preverjanje ce lahko poje kmeta na desni ali na levi diagonali
                        {
                            $mozne_beli++;
                        }
                    }
                    break;
                case 2:
                    //----------------------------------------------ČRNE FIGURICE----------------------------------------------
                    if ($polje[$i][$j - 1] == 0) // ce crni lahko gre naprej z to figuro
                    {
                        $mozne_crni++;
                    }
                    if ($j == 1) // omejitve da ne grem out-of-bound - levi rob
                    {
                        if ($polje[$i][$j] == 1) // če lahko poje kmeta na desni diagonali
                        {
                            $mozne_crni++;
                        }
                    }
                    else if ($j == 8) // omejitve da ne grem out-of-bound - levi rob
                    {
                        if ($polje[$i][$j - 2] == 1) // če lahko poje kmeta na levi diagonali
                        {
                            $mozne_crni++;
                        }
                    }
                    else
                    {
                        if ($polje[$i][$j] == 1 || $polje[$i][$j - 2] == 1) // preverjanje ce lahko poje kmeta na desni ali na levi diagonali
                        {
                            $mozne_crni++;
                        }
                    }
                    break;
                        default:
                    break;
            }
        }
    }

	if($absolutni_zmagovalec == 1)
	{
		$odziv = new Zmaga(1,true); //beli je prisel na drugo stran
			
		return $odziv;
	}
	else if ($absolutni_zmagovalec == 2)
	{
		$odziv = new Zmaga(2,true); //crni je prisel na drugo stran
			
		return $odziv;
	}
	else
	{
		if ($mozne_beli == 0 && $mozne_crni == 0)
		{
			$odziv = new Zmaga(0,true); //vrnemo odziv, zmagovalec je 0, zmaga pa je true, ker je igra končana
			
			return $odziv;
		}
		else if ($mozne_beli == 0 && $mozne_crni != 0)
		{
			$odziv = new Zmaga(2,true); //vrnemo odziv, zmagovalec je 2, zmaga pa je true, ker je igra končana
			
			return $odziv;
		}
		else if ($mozne_beli != 0 && $mozne_crni == 0)
		{
			$odziv = new Zmaga(1,true); //vrnemo odziv, zmagovalec je 1, zmaga pa je true, ker je igra končana
			
			return $odziv;
		}
		else
		{
			$odziv = new Zmaga(0,false); //vrnemo odziv, zmagovalec je 0, zmaga pa je false, ker igra še ni končana
			
			return $odziv;
		}
	}
}
