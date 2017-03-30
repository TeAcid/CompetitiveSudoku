<?php
include "razpoznavalnik.php";

if(isset($_POST['getRow']))
{
	if(isset($_POST['player']))
	{
		include "../connection.php";
		Db::sessionStart();
		echo $_SESSION['fenPlayerStart'] . ":" . $_SESSION['fenPlayerEnd'];
	}
	else if(isset($_POST['computer']))
	{
		include "../connection.php";
		Db::sessionStart();
		echo $_SESSION['fenRacunalnikStart'] . ":" . $_SESSION['fenRacunalnikEnd'];
	}
	else if(isset($_POST['igralec']))
	{
		if(isset($_POST['igralec1']))
		{
			include "../connection.php";
			Db::sessionStart();
			echo $_SESSION['fenIgralec1Start'] . ":" .$_SESSION['fenIgralec1End'];			
		}
		if(isset($_POST['igralec2']))
		{
			include "../connection.php";
			Db::sessionStart();
			echo $_SESSION['fenIgralec2End'] . ":" .$_SESSION['fenIgralec2Start'];			
		}
	}
	else
	{
		echo "Napaka!";
	}
}

class Fen
{
	public $FenNotacija;
	public $Polje = [[]];

	//Konstructor
	public function __construct(){}
	
	//Get metodi
	public function getPolje()
	{
		if(isset($this->Polje))
		{
			return $this->Polje;
		}
		else
		{
			return false;
		}
	}
	
	public function getNotacija()
	{
		if(isset($this->FenNotacija))
		{
			return $this->FenNotacija;
		}
		else
		{
			return false;
		}
	}
	
	public static function Replace($s)
	{
		//Prvo se zamenjajo številke
		$s = str_replace("1", "0", $s);
		$s = str_replace("2", "00", $s);
		$s = str_replace("3", "000", $s);
		$s = str_replace("4", "0000", $s);
		$s = str_replace("5", "00000", $s);
		$s = str_replace("6", "000000", $s);
		$s = str_replace("7", "0000000", $s);
		$s = str_replace("8", "00000000", $s);
		
		//Potem pa še P-ji
		$s = str_replace("p", 2, $s);
		$s = str_replace("P", 1, $s);
		
		return $s;
	}
	
	//Metodi za pretvorbo
	public function fenToPolje($f)
	{
		//Prvo se odstranita zadnjiva dva znaka iz niza 
		//rezultat se shrani v $str
		$str = substr($f, 0, -2);
		
		//Niz se exploda v polje
		$str = explode("/", $str);

		//Prvo se celo polje napolni z -1
		for($i = 0; $i < 8; $i++)
		{
			for($j = 0; $j < 8; $j++)
			{
				$this->Polje[$i][$j] = -1;
			}
		}
		
		//Nadomestimo P-je z 1/2 in številke z 0
		$str = Fen::Replace($str);
		
		//Potem pa se še napolni ostali del polja
		for($i = 0; $i < 8; $i++)
		{
			for($j = 0; $j < 8; $j++)
			{
				if($str[$i][$j] == 0)
				{
					$this->Polje[$i][$j] = 0;
				}
				else if($str[$i][$j] == 1)
				{
					$this->Polje[$i][$j] = 1;
				}
				else
				{
					$this->Polje[$i][$j] = 2;
				}
			}
		}
	}
	
	public function poljeToFen($p, $bw)
	{
		$str = "";
		$stevec = 0;
		
		//Napolnimo string z ustreznimi vrednostmi
		for($i = 0; $i < 8; $i++)
		{
			for($j = 0; $j < 8; $j++)
			{
				if($p[$i][$j] == 1)
				{
					$str = $str . "P";
				}
				else if($p[$i][$j] == 2)
				{
					$str = $str . "p";
				}
				else if($p[$i][$j] == 0)
				{
					$stevec++;
					
					if($j == 7)
					{
						$str = $str . $stevec;
						$stevec = 0;
					}
					else if($p[$i][$j + 1] == 1 || $p[$i][$j + 1] == 2)
					{
						$str = $str . $stevec;
						$stevec = 0;
					}
				}
				else
				{
					echo "Napaka";
					return false;
				}
			}
			
			$str = $str . "/";
		}
		
		//Dodamo še b oz. w
		$str = substr($str, 0, -1);
		$str = $str . " " . $bw;
		//echo $str;
		
		$this->FenNotacija = $str;
	}
	
	public function getNewPolje($polje, $poteza, $igralec)
	{
		//Poteza se prvo explode-a 
		$arr = explode("-", $poteza);
		
		//Potem se še enkrat razdeli
		$koordinateStart = str_split($arr[0], 1);
		$koordinateEnd = str_split($arr[1], 1);
		
		//odšteje se 1 od vsake koordinate
		$koordinateStart[0]--;
		$koordinateStart[1]--;
		$koordinateEnd[0]--;
		$koordinateEnd[1]--;
		
		if($igralec)
		{
		//Posodobimo polje
		$polje[$koordinateStart[0]][$koordinateStart[1]] = 0;
		$polje[$koordinateEnd[0]][$koordinateEnd[1]] = 1;
		}
		else
		{
		$polje[$koordinateStart[0]][$koordinateStart[1]] = 0;
		$polje[$koordinateEnd[0]][$koordinateEnd[1]] = 2;			
		}
		
		return $polje;
	}
}

/*$test = new Fen();
$test->fenToPolje("p7/2pp1ppp/8/8/8/8/PPPPPPPP/8 w");
$polje = $test->getPolje();
$test->poljeToFen($polje, "w");
$fen = $test->getNotacija();
var_dump($polje);
var_dump($fen);*/
?>