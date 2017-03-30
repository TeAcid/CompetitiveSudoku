<?php
//Token class 
class Token
{
	public $Lexeme;
	public $Type;
	public $Row;
	public $Column;
	public $EOF;
	
	//Konstruktor
	public function __construct($l, $t, $r, $c, $e)
	{
		$this->Lexeme = $l;
		$this->Type   = $t;
		$this->Row    = $r;
		$this->Column = $c;
		$this->EOF    = $e;
	}
}

//Scanner class
class Scanner
{
	const ST_STANJ = 6;
	public $Avtomat = [[]];
	public $KoncnaStanja = [];
	public $Row = 1;
	public $Column = 0;
	public $Stanje;
	public $j = 0;
	
	//Konstruktor
	public function __construct($s)
	{
		$this->initAvtomat();
		$this->Stanje = $s;
	}
	
	//Metoda za inicializacijo this->Avtomata
	public function initAvtomat()
	{
		//Prvo inicializiramo this->Avtomat
		for($i = 0; $i < self::ST_STANJ; $i++)
		{
			for($j = 0; $j < 256; $j++)
			{
				$this->Avtomat[$i][$j] = -1;
			}
		}
		
		//Določijo se prehodi
		for($i = 1; $i <= 7; $i++)
		{
			$this->Avtomat[0][$i] = 1;
		}
		
		$this->Avtomat[0][ord('p')] = $this->Avtomat[0][ord('P')]  = 1;	
		$this->Avtomat[0][8] = 2;
		$this->Avtomat[0][ord('/')] = 3;
		$this->Avtomat[0][ord('w')] = $this->Avtomat[0][ord('b')] = 4;
		//Presledki in nova vrstica
		$this->Avtomat[0][ord(' ')] = $this->Avtomat[0][ord('\r')] = $this->Avtomat[0][ord('\t')] = $this->Avtomat[0][ord('\n')] = 5;
		
		//Inicializiramo končna stanja
		for($i = 0; $i < self::ST_STANJ; $i++)
		{
			$this->KoncnaStanja[$i] = -1;
		}
		
		//Mesta, kjer je stanje končno, zapolnimo z 1
		$this->KoncnaStanja[1] = 1;
		$this->KoncnaStanja[2] = 1;
		$this->KoncnaStanja[3] = 1;
		$this->KoncnaStanja[4] = 1;
		$this->KoncnaStanja[5] = 1;
	}
	
	//Metoda, ki preveri, če je stanje končno
	public function isKončnoStanje($CurrentState)
	{
		if($this->KoncnaStanja[$CurrentState] == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Metoda, ki vrne naslednje stanje
	public function getNextState($CurrentState, $_char)
	{
		if(!$this->isEndOfFile($this->j))
		{
			$index = 0;
			if(is_numeric($_char))
			{
				$index = $_char;
			}
			else
			{
				$index = ord($_char);
			}

			if($this->Avtomat[$CurrentState][$index] != -1)
			{
				return $this->Avtomat[$CurrentState][$index];
			}
		}

		return -1;
	}
	
	//Metoda, ki preveri ali je EOF
	public function isEndOfFile($len)
	{
		if($len >= strlen($this->Stanje) || $this->j < 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Metoda, ki vrne token
	public function nextTokenImp()
	{
		$TmpState = 0;
		$CurrentState = 0;
		$Lexeme = "";
		$EOF = "";

		do
		{
			//Trenutno stanje se shrani v TmpState
			if(!$this->isEndOfFile($this->j))
			{
				$TmpState = $this->getNextState($CurrentState, $this->Stanje[$this->j]);
			}
			else
			{
				$TmpState = -1;
			}

			//Preveri se, če obstaja prehod
			if($TmpState != -1)
			{
				$this->Column++;
				
				//Preverimo, če je naslednji znak nova vrstica 
				if($this->Stanje[$this->j] == '\n' || $this->Stanje[$this->j] == '\r')
				{
					$this->Row++;
					$this->Column = 0;
				}
				
				$EOF = false;
				
				//Stanje iz TmpState shrani v CurrentState
				$CurrentState = $TmpState;
				$Lexeme = $Lexeme . $this->Stanje[$this->j];

				//Pomaknemo se na naslenji znak
				$this->j++;
			}
			else
			{
				$EOF = true;

				//Preverimo, če je trenutno stanje končno
				if($this->isKončnoStanje($CurrentState))
				{
					//Če je stanje končno, se ustvari nov Token
					$token = new Token($Lexeme, $CurrentState, $this->Row, $this->Column, $EOF);
					
					//Če je tip Tokena nova vrstica ali presledek, se 
					//pomaknemo na naslednji Token
					if($token->Type == 5)
					{
						return $this->nextTokenImp();
					}
					else
					{
						return $token;
					}
				}
				else
				{	
					return new Token($Lexeme, -1, $this->Row, $this->Column, $EOF);
				}
			}
		}
		while(true);
	}
}
?>