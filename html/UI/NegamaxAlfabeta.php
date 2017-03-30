<?php
ob_start();
include "validacija.php";
//error_reporting(1);
//include "../funkcije.php";
if(isset($_POST['fen']))
{
	//Ustvari se nov fen objekt
	$fenRacunalnikStart = new Fen();
	//Fen se pretvori v polje
	$fenRacunalnikStart->fenToPolje($_POST['fen']);
	$poljeStartRacunalnik = $fenRacunalnikStart->getPolje();

	$novoStanje = NegamaxAlfabeta($poljeStartRacunalnik, "MAX", 1, -99999, 99999, 8, 0, 0, 0);
	$poljeEndRacunalnik = $novoStanje->getStanje();
	//ob_start in ob_end_clean sta za to, da se samo izpiše polje
	ob_end_clean();
	echo json_encode($poljeEndRacunalnik);
	
	//Preveri se, če je  fen pravilen in se doda v bazo
	$ScannerRacunalnik = new Scanner($_POST['fen']);
	$ParserRacunalnik = new Parser($ScannerRacunalnik);
	if($ParserRacunalnik->parse())
	{
		//Pretvorimo še vrnjeno stanje v fen
		//Ustvari se nov fen objekt
		$fenRacunalnikEnd = new Fen();
		//Polje se pretvori v fen
		$fenRacunalnikEnd->poljeToFen($poljeEndRacunalnik, "b");
		$fenEndRacunalnik = $fenRacunalnikEnd->getNotacija();

		//Preveri se, če je tudi ta fen v redu
		$ScannerRacunalnikEnd = new Scanner($fenEndRacunalnik);
		$ParserRacunalnikEnd = new Parser($ScannerRacunalnikEnd);
		if($ParserRacunalnikEnd->parse())
		{
			Db::sessionStart();
			$db = Db::getInstance();
			$result = mysqli_query($db,"CALL newPoteza('$_POST[fen]', '$fenEndRacunalnik', '$_SESSION[id]', 'true')");
			$_SESSION['fenRacunalnikStart'] = $_POST['fen'];
			$_SESSION['fenRacunalnikEnd'] = $fenEndRacunalnik;
		}
		else
		{
			echo "Napaka!";
		}
	}
	else
	{
		echo "Napaka!";
	}
}

//=============================TEST=========================================
/*$polje = array (
array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
array ( 2, 0, 0, 0, 2, 0, 2, 0 ),
array ( 0, 2, 0, 0, 0, 0, 0, 2 ),
array ( 2, 0, 2, 1, 0, 2, 0, 0 ),
array ( 1, 0, 1, 0, 0, 1, 0, 0 ),
array ( 0, 1, 0, 0, 0, 0, 0, 0 ),
array ( 0, 0, 0, 1, 0, 0, 1, 1 ),
array ( 0, 0, 0, 0, 0, 0, 0, 0 ), );

$test = NegamaxAlfabeta($polje, "MAX", 1, -99999, 99999, 8, 0, 0);
Igranje::izrisi_polje($test->getStanje());*/

class StanjeIgre
{
	private $OcenaStanja;
	private $Stanje = [[]];
	private $IgralecNaPotezi;
	private $SeznamMožnihPotez = [];
	private $stevilo_belih = 8;
	private $stevilo_crnih = 8;
	
	public function __construct($S, $I)
	{
		//$this->OcenaStanja = -INF;
		$this->Stanje = $S;
		$this->IgralecNaPotezi = $I;
	}
	
	//Get/Set metode
	public function getOcenaStanja()
	{
		return $this->OcenaStanja;
	}
	public function setOcenaStanja($O)
	{
		$this->OcenaStanja = $O;
	}
	
	public function getStanje()
	{
		return $this->Stanje;
	}
	public function setStanje($S)
	{
		$this->Stanje = $S;
	}
	
	public function getIgralec()
	{
		return $this->IgralecNaPotezi;
	}
	public function setIgralec($I)
	{
		$this->IgralecNaPotezi = $I;
	}
	
	public function getSeznamMožnihPotez()
	{
		return $this->SeznamMožnihPotez;
	}
	public function setSeznamMožnihPotez($S)
	{
		$this->SeznamMožnihPotez = $S;
	}
	
	public function getSteviloFigur()
	{
		$st = 0;
		for($i = 0; $i < 8; $i++)
		{
			for($j = 0; $j < 8; $j++)
			{
				if($this->Stanje[$i][$j] == 1)
				{
					$st++;
				}
			}
		}
		
		return $st;
	}
	
	public function nobenaFiguraNapadena()
	{
		for($i = 0; $i < 8; $i++)
		{
			for($j = 0; $j < 8; $j++)
			{
				if($this->Stanje[$i][$j] == 2)
				{
					if($j == 7)
					{
						if($this->Stanje[$i + 1][$j - 1] == 1)
						{
							return false;
						}
					}
					else if($j == 0)
					{
						if($this->Stanje[$i + 1][$j + 1] == 1)
						{
							return false;
						}
					}
					else
					{
						if($this->Stanje[$i + 1][$j - 1] == 1 || $this->Stanje[$i + 1][$j + 1] == 1)
						{
							return false;
						}
					}
				}
			}
		}
		
		return true;
	}
	
	public function vseFigureKrite()
	{
		$stevec = 0;
		for($i = 0; $i < 8; $i++)
		{
			for($j = 0; $j < 8; $j++)
			{
				if($this->Stanje[$i][$j] == 2)
				{
					if($j == 7)
					{
						if($this->Stanje[$i - 1][$j - 1] == 2)
						{
							$stevec++;
						}
					}
					else if($j == 0)
					{
						if($this->Stanje[$i - 1][$j + 1] == 2)
						{
							$stevec++;
						}
					}
					else
					{
						if($this->Stanje[$i - 1][$j - 1] == 2 || $this->Stanje[$i - 1][$j + 1] == 2)
						{
							$stevec++;
						}
					}
				}
			}
		}
		
		return $stevec;
	}
	
	public function nePustiNaprostnikaMimo()
	{
		for($i = 0; $i < 8; $i++)
		{
			if($this->Stanje[2][$i] == 1)
			{
				if($i == 0)
				{
					if($this->Stanje[1][$i] == 0 || $this->Stanje[1][$i + 1] == 0 /*|| $this->Stanje[1][$i + 1] == 2*/)
					{
						return true;
					}
				}
				else if($i == 7)
				{
					if($this->Stanje[1][$i] == 0 || $this->Stanje[1][$i - 1] == 0 /*|| $this->Stanje[1][$i - 1] == 2*/)
					{
						return true;
					}
				}
				else
				{
					if($this->Stanje[1][$i] == 0 || $this->Stanje[1][$i + 1] == 0 || $this->Stanje[1][$i - 1] == 0 /*|| $this->Stanje[1][$i - 1] == 2 || $this->Stanje[1][$i + 1] == 2*/)
					{
						return true;
					}
				}
			}
		}
		
		for($i = 0; $i < 8; $i++)
		{
			if($this->Stanje[3][$i] == 1)
			{
				if($i == 0)
				{
					if($this->Stanje[2][$i] == 0 || $this->Stanje[2][$i + 1] == 0 /* || $this->Stanje[1][$i + 1] == 2*/)
					{
						return true;
					}
				}
				else if($i == 7)
				{
					if($this->Stanje[2][$i] == 0 || $this->Stanje[2][$i - 1] == 0 /* || $this->Stanje[1][$i - 1] == 2*/)
					{
						return true;
					}
				}
				else
				{
					if($this->Stanje[2][$i] == 0 || $this->Stanje[2][$i + 1] == 0 || $this->Stanje[2][$i - 1] == 0 /*|| $this->Stanje[2][$i + 1] == 2 || $this->Stanje[2][$i - 1] == 2*/)
					{
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	public function figuraNapadenaVPrvihVrstah()
	{
		for($i = 2; $i < 3; $i++)
		{
			if($this->Stanje[3][$j] == 1)
			{
				if($j == 7)
				{
					if($this->Stanje[1][$j - 1] == 2)
					{
						return true;
					}
				}
				else if($j == 0)
				{
					if($this->Stanje[1][$j + 1] == 2)
					{
						return true;
					}
				}
				else
				{
					if($this->Stanje[1][$j - 1] == 2 || $this->Stanje[1][$j + 1] == 2)
					{
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	public function vseFigureBlokirane()
	{
		$stevec = 0;
		for($i = 0; $i < 8; $i++)
		{
			for($j = 0; $j < 8; $j++)
			{
				if($this->Stanje[$i][$j] == 1)
				{
					if($this->Stanje[$i - 1][$j] == 2)
					{
						$stevec++;
					}
				}
			}
		}
		
		return $stevec;
	}
	
	public function vseFigureNapadene()
	{
		$stevec = 0;
		for($i = 0; $i < 8; $i++)
		{
			for($j = 0; $j < 8; $j++)
			{
				if($this->Stanje[$i][$j] == 2)
				{
					if($j == 7)
					{
						if($this->Stanje[$i + 1][$j - 1] == 1)
						{
							$stevec++;
						}
					}
					else if($j == 0)
					{
						if($this->Stanje[$i + 1][$j + 1] == 1)
						{
							$stevec++;
						}
					}
					else
					{
						if($this->Stanje[$i + 1][$j - 1] == 1 || $this->Stanje[$i + 1][$j + 1] == 1)
						{
							$stevec++;
						}
					}
				}
			}
		}
		
		return $stevec;
	}
	
	//Metoda, ki izračuna oceno stanja
	public function Hevristika($st, $stBlokiranih, $stKritih)
	{
		$val = 0;
		
		//Tukaj se preverja, koliko kmetov je še na začetnni poziciji
		$stevec = 0;
		for($i = 0; $i < 8; $i++)
		{
			if($this->Stanje[1][$i] == 2)
			{
				$stevec++;
			}
		}
		
		$stFigur = 0;
		//Tukaj se preveri, če je nasprotnik tik pred zmago (predzadnja vrstica)
		for($i = 0; $i < 8; $i++)
		{			
			if($this->Stanje[6][$i] == 2)
			{
				$val = 9999;
				break;
			}
			else
			{
				$stFigur++;
			}
		}
		
		$zmaga = zmaga($this->Stanje);
		//Največjo prioriteto ima to, da zmaga
		if($zmaga->Zmaga == "true")
		{
			$val = 10000;
		}
		else if($stFigur == 8)
		{				
			if($st > $this->getSteviloFigur() && $this->nobenaFiguraNapadena() && !$this->nePustiNaprostnikaMimo())
			{
				$val = 9000;
			}
			else
			{
				$stFigur = 0;
				for($i = 0; $i < 8; $i++)
				{			
					if($this->Stanje[5][$i] == 2 && $this->Stanje[6][$i - 1] != 1 && $this->Stanje[6][$i + 1] != 1)
					{
						$val = 9001;
						break;
					}
				}
			}
		}
		
		if($val == 0)
		{
			if($stevec == 7 && $this->nobenaFiguraNapadena())
			{
				$val = rand(10, 1000);
			}
			else if($stevec == 7 && !$this->nobenaFiguraNapadena())
			{
				$val = rand(-9999, -1000);
			}
			else
			{
				if($this->nePustiNaprostnikaMimo())
				{
					$val = rand(-1000, -100);
				}
				else if($this->figuraNapadenaVPrvihVrstah())
				{
					$val = rand(1002, 1020);
				}
				else
				{
					if($this->vseFigureBlokirane() > $stBlokiranih)
					{
						$val = rand(980, 1001);
					}
					else if($this->vseFigureKrite() > $stKritih)
					{
						$val = rand(980, 1001);
					}
					else
					{
						$val = rand(10, 1000);
					}
				}
			}
		}
		
		if($stBlokiranih < $this->vseFigureBlokirane() && $stNapadenih < $this->vseFigureNapadene())
		{
			$val = rand(-12000, -10000);
		}
		
		$this->OcenaStanja = $val;
		return $this;
	}
	
	public function DodajVSeznamPotez($currI, $currJ, $newI, $newJ, $stevec, $ig)
	{
		//Preveri se, če $i ni out of bounds
		if($newI > -1 && $newI < 8 && $newJ > - 1 && $newJ < 8)
		{
			$poteza = "";
			$poteza = $poteza . ($currI + 1) . ($currJ + 1) . "-" . ($newI + 1) . ($newJ + 1);

			//Če je poteza veljavna, se doda med seznam možnih potez
			$odziv = validiraj($this->Stanje, $poteza);
			if($odziv->Valid == true)
			{
				//Novo stanje dodamo v polje
				$temp = $this->Stanje[$newI][$newJ];
				$this->Stanje[$currI][$currJ] = 0;
				$this->Stanje[$newI][$newJ] = $ig;
				$this->SeznamMožnihPotez[$stevec] = $this->Stanje;
				
				//Postavimo nazaj na prejšnjo stanje
				$this->Stanje[$currI][$currJ] = $ig;
				$this->Stanje[$newI][$newJ] = $temp;
				return true;
			}
		}

		return false;
	}
	
	//Metoda, ki najde vse možne poteze iz trenutnega 
	//stanja
	public function Poteze()
	{
		$stevec = 0;
	
		//V primeru, da je na potezi beli (1)
		if($this->IgralecNaPotezi == "MIN")
		{
			//Gremo skozi celo polje
			for($i = 0; $i < 8; $i++)
			{
				for($j = 0; $j < 8; $j++)
				{
					//Če smo naleteli na belo figuro...
					if($this->Stanje[$i][$j] == 1)
					{
						//Klic metode DodajVSeznamPotez - Veljavne poteze doda
						//v seznam možnih potez
						//1. Pomik naprej (i = i - 1)
						$odziv = $this->DodajVSeznamPotez($i, $j, $i - 1, $j, $stevec, 1);
						if($odziv)
						{
							$stevec++;
						}
						//2. Pomik diagonalno levo (i = i - 1, j = j - 1)
						$odziv = $this->DodajVSeznamPotez($i, $j, $i - 1, $j - 1, $stevec, 1);
						if($odziv)
						{
							$stevec++;
						}
						//3. Pomik diagonalno desno (i = i - 1, j = j + 1)
						$odziv = $this->DodajVSeznamPotez($i, $j, $i - 1, $j + 1, $stevec, 1);
						if($odziv)
						{
							$stevec++;
						}
						//4. Pomik za dva naprej (i = i - 2)
						$odziv = $this->DodajVSeznamPotez($i, $j, $i - 2, $j, $stevec, 1);
						if($odziv)
						{
							$stevec++;
						}
					}
				}
			}
		}
		//V primeru, da je na potezi črni (2)
		else
		{
			//Gremo skozi celo polje
			for($i = 0; $i < 8; $i++)
			{
				for($j = 0; $j < 8; $j++)
				{
					//Če smo naleteli na črno figuro...
					if($this->Stanje[$i][$j] == 2)
					{
						//Klic metode DodajVSeznamPotez - Veljavne poteze doda
						//v seznam možnih potez
						//1. Pomik naprej (i = i + 1)
						$odziv = $this->DodajVSeznamPotez($i, $j, $i + 1, $j, $stevec, 2);
						if($odziv)
						{
							$stevec++;
						}
						//2. Pomik diagonalno levo (i = i + 1, j = j - 1)
						$odziv = $this->DodajVSeznamPotez($i, $j, $i + 1, $j - 1, $stevec, 2);
						if($odziv)
						{
							$stevec++;
						}
						//3. Pomik diagonalno desno (i = i + 1, j = j + 1)
						$odziv = $this->DodajVSeznamPotez($i, $j, $i + 1, $j + 1, $stevec, 2);
						if($odziv)
						{
							$stevec++;
						}
						//4. Pomik za dva naprej (i = i + 2)
						$odziv = $this->DodajVSeznamPotez($i, $j, $i + 2, $j, $stevec, 2);
						if($odziv)
						{
							$stevec++;
						}
					}
				}
			}
		}
	}
	
	//Metoda, ki preveri, če je trenutno stanje končno
	public function JeList()
	{
		$list = zmaga($this->Stanje);
		if($list->Zmaga == "true")
		{
			return true;
		}
		else if($list->Zmaga == "remi")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

//Funkcija, ki negira trenutnega igralca
function Neg($ig)
{
	if($ig == "MIN")
	{
		$ig = "MAX";
	}
	else if($ig == "MAX")
	{
		$ig = "MIN";
	}
	
	return $ig;
}

//Vhodi metode NegamaxAlfabeta: 
//P - Trenutni položaj, ig - Igralec na potezi
//d - Preostala globina, ALFA - Spodnja meja ocene, BETA - Zgornja meja ocene
//Note: MIN - beli (1), MAX - črni (2)
function NegamaxAlfabeta($P, $ig, $d, $ALFA, $BETA, $STF, $STB, $STK, $STN)
{
	//Ustvarimo nov objekt - To je tudi objekt, ki ga metoda vrne
	$Stanje = new StanjeIgre($P, $ig);

	//Metoda prvo preveri, če je stanje list (torej končno stanje igre) ali 
	//pa če smo dosegli največjo podano globino
	if ($Stanje->JeList() || $d == 0)
	{
		//echo "YES";
		//Vrnemo hevristiko vozlišča drevesa
		return $Stanje->Hevristika($STF, $STB, $STK, $STN);
	}

	$ocena = -100000;
	$poteza = NULL;
	//V seznam shranimo vse možno poteze v 
	//trenutnem stanju
	$Stanje->Poteze();

	$M = $Stanje->getSeznamMožnihPotez();
	//Negiran igralec
	$ig = Neg($ig);
	//Trenutno število figur na polju
	$stFigur = $Stanje->getSteviloFigur();
	$stBlokiranih = $Stanje->vseFigureBlokirane();
	$stKritih = $Stanje->vseFigureKrite();
	$stNapadenih = $Stanje->vseFigureNapadene();
	
	foreach($M as $m)
	{
		//Izvedemo potezo m V položaju P in shranimo v P1
		$P1 = $m;
		
		//echo $ig . "lel";
		//Za izvedeno potezo rekurzivno kličemo meodo NegamaxAlfabeta
		$S = NegamaxAlfabeta($P1, $ig, $d - 1, -$BETA, -$ALFA, $stFigur, $stBlokiranih, $stKritih, $stNapadenih);
		//echo $S->getOcenaStanja() . "\n";
		//var_dump($S->getOcenaStanja());
		//echo $S->getOcenaStanja();
		//Preveri se, če je vrnjena ocena večja od trenutne
		if($S->getOcenaStanja() > $ocena)
		{
			$ocena = $S->getOcenaStanja();
			$poteza = $m;

			//Preverimo, če je ocena večja od spodnje meje
			if($ocena > $ALFA)
			{
				//Če je, se v ALFA shrani ocena
				$ALFA = $ocena;

				//Preverimo, če je spodnja meja večja od zgornje
				if($ALFA >= $BETA)
				{
					$Stanje->setOcenaStanja($ocena);
					$Stanje->setStanje($poteza);
					//V primeru, da je, se vrne objekt
					return $Stanje;
				}
			}
		}	
	}
	
	$Stanje->setOcenaStanja($ocena);
	$Stanje->setStanje($poteza);
	return $Stanje;
}
?>