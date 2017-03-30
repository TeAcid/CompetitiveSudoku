<?php
include "pregledovalnik.php";

class Parser
{
	public $CurrentToken;
	public $Scan;
	public $Stevec = 8;

	//Konstruktor
	public function __construct($s)
	{
		$this->Scan = $s;
	}
	
	//Metoda, s katero se začne parsanje
	public function parse()
	{
		$this->CurrentToken = $this->Scan->nextTokenImp();
		return $this->FEN();
	}
	
	public function FEN()
	{
		//echo $this->CurrentToken->Lexeme . " ";
		if(!$this->Scan->isEndOfFile($this->Scan->j))
		{
			if($this->ZADNJA_VRSTICA())
			{
				$this->CurrentToken = $this->Scan->nextTokenImp();
				return $this->FEN();
			}
			else if($this->VRSTICA() && $this->ZADNJA_VRSTICA() != 4)
			{
				$this->CurrentToken = $this->Scan->nextTokenImp();
				return $this->FEN();
			}
			else if($this->OSEM())
			{
				$this->CurrentToken = $this->Scan->nextTokenImp();
				return $this->FEN();
			}
			else
			{
				return false;
			}
		}
		else
		{
			//echo nl2br("\nPARSANJE SE JE ZAKLJUČILO!");
			return true;
		}
	}
	
	public function OSEM()
	{
			//echo nl2br($this->Scan->j . "OSEM\n" . $this->CurrentToken->Lexeme);
			//echo $this->CurrentToken->Lexeme;
		if($this->CurrentToken->Type == 2)
		{
			$this->CurrentToken = $this->Scan->nextTokenImp();
			
			if($this->CurrentToken->Lexeme == "/" && $this->Scan->nextTokenImp()->Type != 4)
			{
				$this->Scan->j -= 1;
				return true;
			}
			else if($this->CurrentToken->Type == 4)
			{
				return true;
			}
			else
			{
				$this->Scan->j -= 1;
			}
		}

		return false;
	}

	//Preverjanje sintakse prve in zadnje vrstice
	public function ZADNJA_VRSTICA()
	{
		//echo nl2br("\n" . $this->CurrentToken->Lexeme . "ZADNJA\n");
		//V prvi vrstici se lahko pojavi le številka ali P
		if($this->CurrentToken->Type == 1)
		{
			$jTemp = $this->Scan->j;
			$bwTemp = 0;
			//V tem delu se preveri, če je kombinacija P-jev in številk ustrezna
			//Recimo, da se ne pojavi nekaj kot 2P8 (ne mora biti 10 mest praznih)

			//Prvo se preveri primer, ko je P na začetku
			if($this->CurrentToken->Lexeme == "p" || $this->CurrentToken->Lexeme == "P")
			{
				$this->CurrentToken = $this->Scan->nextTokenImp();

				if($this->CurrentToken->Lexeme == 7)
				{
					$this->CurrentToken = $this->Scan->nextTokenImp();
					
					if($this->CurrentToken->Lexeme == "/")
					{
						$bwTemp = $this->Scan->j;
						$this->CurrentToken = $this->Scan->nextTokenImp();
						if($this->CurrentToken->Type != 4)
						{
							$this->Scan->j = $bwTemp - 1;
							$this->CurrentToken = $this->Scan->nextTokenImp();
							return true;
						}
						else
						{
							$this->Scan->j = $jTemp - 1;
							$this->CurrentToken = $this->Scan->nextTokenImp();
							return 4;
						}
					}
					else if($this->CurrentToken->Type == 4)
					{
						return true;
					}
				}
			}
			//Potem pa primeri, ko je 7 na začetku
			else if($this->CurrentToken->Lexeme == 7)
			{
				$this->CurrentToken = $this->Scan->nextTokenImp();
				
				if($this->CurrentToken->Lexeme == "p" || $this->CurrentToken->Lexeme == "P")
				{
					$this->CurrentToken = $this->Scan->nextTokenImp();
					
					if($this->CurrentToken->Lexeme == "/")
					{
						$bwTemp = $this->Scan->j;
						$this->CurrentToken = $this->Scan->nextTokenImp();
						if($this->CurrentToken->Type != 4)
						{
							$this->Scan->j = $bwTemp - 1;
							$this->CurrentToken = $this->Scan->nextTokenImp();
							return true;
						}
						else
						{
							$this->Scan->j = $jTemp - 1;
							$this->CurrentToken = $this->Scan->nextTokenImp();
							return 4;
						}
					}
					else if($this->CurrentToken->Type == 4)
					{
						return true;
					}	
				}
			}
			//Potem pa še primeri, ko je druga številka na začetku
			else if(is_numeric($this->CurrentToken->Lexeme) && ($this->CurrentToken->Lexeme >= 1 && $this->CurrentToken->Lexeme <= 6))
			{
				$st = $this->CurrentToken->Lexeme;	
				$this->CurrentToken = $this->Scan->nextTokenImp();
				//echo $this->Scan->j . " ";
				
				if($this->CurrentToken->Lexeme == "p" || $this->CurrentToken->Lexeme == "P")
				{
					$this->CurrentToken = $this->Scan->nextTokenImp();
					//echo $this->Scan->j . " ";
					if(is_numeric($this->CurrentToken->Lexeme) && ($this->CurrentToken->Lexeme == 8	- ($st + 1)))
					{
						$this->CurrentToken = $this->Scan->nextTokenImp();
											
						if($this->CurrentToken->Lexeme == "/")
						{
							$bwTemp = $this->Scan->j;
							$this->CurrentToken = $this->Scan->nextTokenImp();
							if($this->CurrentToken->Type != 4)
							{
								$this->Scan->j = $bwTemp - 1;
								$this->CurrentToken = $this->Scan->nextTokenImp();
								//echo "TEST";
								return true;
							}
							else
							{
								$this->Scan->j = $jTemp - 1;
								$this->CurrentToken = $this->Scan->nextTokenImp();
								return 4;
							}
						}
						else if($this->CurrentToken->Type == 4)
						{
							return true;
						}	
					}
				}
			}
			else
			{
				return false;
			}
			
			$this->Scan->j = $jTemp - 1;
			$this->CurrentToken = $this->Scan->nextTokenImp();
			//echo $this->CurrentToken->Lexeme . " ";
		}
		
		return false;
	}
	
	//Preverjanje sintakse sredinskih vrstic
	public function VRSTICA()
	{	
		//echo nl2br($this->Scan->Stanje[$this->Scan->j] . "VRSTICA ");
		//Preveri se, če je Token / ali P
		if($this->CurrentToken->Type == 1 || $this->CurrentToken->Lexeme == "/")
		{
			//echo $this->CurrentToken->Lexeme;
			//Če je Leksem numeričen
			if(is_numeric($this->CurrentToken->Lexeme))
			{
				//Od števca odštejemo vrednost Lexema
				$this->Stevec -= $this->CurrentToken->Lexeme;
				//echo $this->Stevec . "-hi- ";
				//Pomaknemo se naprej
				$this->CurrentToken = $this->Scan->nextTokenImp();
			}
			else
			{						
				//Če Leksem ni numeričen, se preveri, če gre za / in če je števec hkrati == 0
				if($this->CurrentToken->Lexeme == "/")
				{
					//echo "HI" . $this->Stevec;
					if($this->Stevec == 0)
					{
						//Če je, vrnemo true
						$this->Stevec = 8;
						//echo "HI";
						return true;
					}
					else
					{
						$this->Stevec = 8; 
						$this->Scan->j -= (8 - $this->Stevec);
						return false;
					}
				}

				//Števec zmanjšamo za 1
				$this->Stevec--;
				//echo $this->Stevec . "- ";
				//Premaknemo se naprej
				$this->CurrentToken = $this->Scan->nextTokenImp();
			}
	
			//Če je števec manj od 0, je napaka
			if($this->Stevec < 0)
			{
				$this->Stevec = 8;
				$this->Scan->j -= (8 - $this->Stevec);
				return false;
			}
			
			return $this->VRSTICA();
		}

		$this->Scan->j -= (8 - $this->Stevec);
		$this->Stevec = 8;
		return false;
	}
}

/*
$testArray = array
(
	"6p1/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "3p4/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "7p/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w",
	"p7/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "8/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "7p8/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w",
	"7pp/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "pp7/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "7pp7/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w",
	"6p3/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "6p/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "p1/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", 
	"6p1/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "6p1/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "6p2/2pp23p/8/8/8/8/PPPPPPPP/3p4 w",
	"6p1/2pp2p3/8/8/8/8/PPPPPPPP/3p4 w", "6p1/6pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "6p1/2ppP2pp/8/8/8/8/PPPPPPPP/3p4 w",
	"6p1/2ppPPpp/8/8/8/8/PPPPPPPP/3p4 w", "6p1/2pp2pp/8/8/8/8/PPPPPPPP/3p4 w", "6p1/3p2pp/8/8/8/8/PPPPPPPP/3p4 w",
	"6p1/8/8/8/8/8/PPPPPPPP/3p4 w", "6p1/7/8/8/8/8/PPPPPPPP/3p4 w", "6p1/3p4/8/8/8/8/PPPPPPPP/3p4/ w"
);

foreach($testArray as $s)
{
	$scanTest = new Scanner($s);
	$test = new Parser($scanTest);

	if($test->parse())
	{
		echo nl2br("\nSTRING JE PRAVILEN");
	}
	else
	{
		echo "NI PRAVILNO";
	}
	
	echo nl2br("\n\n");
}
*/
?>