<?php
error_reporting(0);
include "zmaga.php";
include "../PPJ/fen.php";
include "../connection.php";

//Preveri se, če je poteza pravilna
if(isset($_POST['poteza']) && isset($_POST['fen']))
{
	if(isset($_POST['player']))
	{
		//Ustvari se nov fen objekt
		$fenPlayerStart = new Fen();
		//Fen se pretvori v polje
		$fenPlayerStart->fenToPolje($_POST['fen']);
		$poljeStartPlayer = $fenPlayerStart->getPolje();
		$poteza = $_POST['poteza'];
		//if(!isset($_POST['player'])){echo $poteza;}
		$check = validiraj($poljeStartPlayer, $poteza);
		if ($check->Valid == true)
		{
			if($check->Polje == "zmaga")
			{
				echo "zmaga";
			}
			else if($check->Polje == "remi")
			{
				echo "remi";
			}
			else
			{
				echo "true";
			}
		

		//Preveri se, če je  fen pravilen in se doda v bazo
			$ScannerPlayer = new Scanner($_POST['fen']);
			$ParserPlayer = new Parser($ScannerPlayer);
			if($ParserPlayer->parse())
			{
				//Pretvorimo še vrnjeno stanje v fen
				//Ustvari se nov fen objekt
				$fenPlayerEnd = new Fen();
				//Iz poteze in polja se prvo pridobi novo polje
				$poljeEndPlayer = $fenPlayerEnd->getNewPolje($poljeStartPlayer, $poteza, true); 
				//Polje se pretvori v fen
				$fenPlayerEnd->poljeToFen($poljeEndPlayer, "w");
				$fenEndPlayer = $fenPlayerEnd->getNotacija();
				
				//Preveri se, če je tudi ta fen v redu
				$ScannerPlayerEnd = new Scanner($fenEndPlayer);
				$ParserPlayerEnd = new Parser($ScannerPlayerEnd);

				if($ParserPlayerEnd->parse())
				{
					Db::sessionStart();
					$db = Db::getInstance();
					$fen = $_POST['fen'];
					$player = $_SESSION['id'];
					$result = mysqli_query($db,"CALL newPoteza('$fen', '$fenEndPlayer', '$player', 'false')");
					$_SESSION['fenPlayerStart'] = $_POST['fen'];
					$_SESSION['fenPlayerEnd'] = $fenEndPlayer;
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
	}
	if(isset($_POST['igralec']) && isset($_POST['igralec1']))
		{
				//Ustvari se nov fen objekt
			$fenIgralec1Start = new Fen();
			//Fen se pretvori v polje
			$fenIgralec1Start->fenToPolje($_POST['fen']);
			$poljeStartIgralec1 = $fenIgralec1Start->getPolje();
			$poteza = $_POST['poteza'];
			//if(!isset($_POST['player'])){echo $poteza;}
			$check = validiraj($poljeStartIgralec1, $poteza);
			if ($check->Valid == true)
			{
				if($check->Polje == "zmaga")
				{
					echo "zmaga";
				}
				else if($check->Polje == "remi")
				{
					echo "remi";
				}
				else
				{
					echo "true";
				}
				$ScannerIgralec1 = new Scanner($_POST['fen']);
				$ParserIgralec1 = new Parser($ScannerIgralec1);
				
				if($ParserIgralec1->parse())
				{
						$fenIgralec1End = new Fen();
						$poljeEndIgralec1 = $fenIgralec1End->getNewPolje($poljeStartIgralec1, $poteza, true);
						$fenIgralec1End->poljeToFen($poljeEndIgralec1, 'w');
						$fenEndIgralec1 = $fenIgralec1End->getNotacija();
						
						$ScannerIgralec1End = new Scanner($fenEndIgralec1);
						$ParserIgralec1End = new Parser($ScannerIgralec1End);
						
						if($ParserIgralec1End->parse())
						{
							Db::sessionStart();
							$db = Db::getInstance();
							$fen = $_POST['fen'];
							$id = $_POST['id'];
							$query = mysqli_query($db, "SELECT * FROM IgreProtiOsebi WHERE ID = $id"); 
							$result = mysqli_fetch_array($query);
							$igralec = $result['igralec1ID'];
							$ime = mysqli_query($db, "SELECT * FROM oseba WHERE ID = $igralec");
							$uporabnik = mysqli_fetch_array($ime);
							$upime = $uporabnik['upime'];
							$result = mysqli_query($db, "INSERT INTO potezeOseba(TK_ID_igra, OD, DO, KDO) VALUES ($id, '$fen', '$fenEndIgralec1', '$upime')");
							$_SESSION['fenIgralec1Start'] = $_POST['fen'];
							$_SESSION['fenIgralec1End'] = $fenEndIgralec1;
						}
						else
						{
							echo "Napaka - prvic igralec1";
						}
				}
				else
				{
					echo "napaka - drugic igralec1";
				}
			}
			else
			{
				echo "napaka - tretjic igralec1";
			}
		}
	if(isset($_POST['igralec']) && isset($_POST['igralec2']))
	{
		//Ustvari se nov fen objekt
		$fenIgralec2Start = new Fen();
		//Fen se pretvori v polje
		$fenIgralec2Start->fenToPolje($_POST['fen']);
		$poljeStartIgralec2 = $fenIgralec2Start->getPolje();
		$poteza = $_POST['poteza'];
		//if(!isset($_POST['player'])){echo $poteza;}
		$check = validiraj($poljeStartIgralec2, $poteza);
			if ($check->Valid == true)
			{
				if($check->Polje == "zmaga")
				{
					echo "zmaga";
				}
				else if($check->Polje == "remi")
				{
					echo "remi";
				}
				else
				{
					echo "true";
				}
				$ScannerIgralec2 = new Scanner($_POST['fen']);
				$ParserIgralec2 = new Parser($ScannerIgralec2);
				
				if($ParserIgralec2->parse())
				{
						$fenIgralec2End = new Fen();
						$poljeEndIgralec2 = $fenIgralec2End->getNewPolje($poljeStartIgralec2, $poteza, false);
						$fenIgralec2End->poljeToFen($poljeEndIgralec2, 'b');
						$fenEndIgralec2 = $fenIgralec2End->getNotacija();
						
						$ScannerIgralec2End = new Scanner($fenEndIgralec2);
						$ParserIgralec2End = new Parser($ScannerIgralec2End);
						
						if($ParserIgralec2End->parse())
						{
							Db::sessionStart();
							$db = Db::getInstance();
							$fen = $_POST['fen'];
							$id = $_POST['id'];
							$query = mysqli_query($db, "SELECT * FROM IgreProtiOsebi WHERE ID = $id"); 
							$result = mysqli_fetch_array($query);
							$igralec = $result['igralec2ID'];
							$ime = mysqli_query($db, "SELECT * FROM oseba WHERE ID = $igralec");
							$uporabnik = mysqli_fetch_array($ime);
							$upime = $uporabnik['upime'];
							$result = mysqli_query($db, "INSERT INTO potezeOseba(TK_ID_igra, OD, DO, KDO) VALUES ($id, '$fen', '$fenEndIgralec2', '$upime')");
							$_SESSION['fenIgralec2Start'] = $_POST['fen'];
							$_SESSION['fenIgralec2End'] = $fenEndIgralec2;
						}
						else
						{
							echo "Napaka";
						}					
				}
				else
				{
					echo "Napaka";
				}
			}
			else
			{
				echo "Napaka";
			}	
	}
}

class Response
{
    public $Polje;
    public $Valid;
			
	public function __construct($polje,$valid)
	{
		$this->Polje = $polje;
		$this->Valid = $valid;
	}
}

function konec($polje) // funkcija ki kliče funkcijo zmaga, ter v primeru zmagovalca izpiše (to se zgodi samo za valid poteze)
{
	$konec = zmaga($polje);
	if ($konec->Zmaga == true)
	{
		if($konec->Zmagovalec == 1) // zmaga beli igralec
		{
			return true;
		}
		else if($konec->Zmagovalec == 2) // zmaga črni igralec
		{
			return true;
		}
		else
		{
			return "remi";
		}
	}
	else // igra se še ni končala
	{
		return false;
	}
}

function validiraj($polje,$poteza) {
    // delitev poteze na dva dela
    $del = explode("-", $poteza);
    $prvi = intval($del[0]);
    $drugi = intval($del[1]);

    // dobimo koordinate
    $y1 = $prvi % 10;
    $x1 = ($prvi - $y1)/10;
    $y2 = $drugi % 10;
    $x2 = ($drugi - $y2)/10;

    // shranimo si tudi startno in ciljno vrednost ter preverimo da je v dovoljenih okvirih
	if(($x1 <= 8 && $x1 >= 1) && ($y1 <= 8 && $y1 >= 1) && ($x2 <= 8 && $x2 >= 1) && ($y2 <= 8 && $y2 >= 1))
	{
		$start = $polje[$x1-1][$y1-1];
		$cilj = $polje[$x2-1][$y2-1];
	}
	else
	{
		$start = 0;
		$cilj = 0;
	}

    switch ($start)
    {
        case 1:
//----------------------------------------------BELE FIGURICE----------------------------------------------
            if ($y1 == $y2) // če gre za premik naravnost
            {
                if ($x1 == 7 && ($x1 - $x2) == 2 && $cilj == 0 && $polje[$x1 - 2][$y1 - 1] == 0) // če gre za premik za dve polji
                {
                    $polje[$x2 - 1][$y2 - 1] = $polje[$x1 - 1][$y1 - 1];
                    $polje[$x1 - 1][$y1 - 1] = 0;

                    if(konec($polje) == true)
					{
						$odziv = new Response("zmaga", true);
						return $odziv;
					}
					else if(konec($polje) == "remi")
					{
						$odziv = new Response("remi", true);
						return $odziv;
					}
					
					$odziv = new Response($polje,true);
					
                    return $odziv;
                }
                else if ($x1-$x2 == 1 && $cilj == 0) // če gre za premik za eno polje
                {
                    $polje[$x2 - 1][$y2 - 1] = $polje[$x1 - 1][$y1 - 1];
                    $polje[$x1 - 1][$y1 - 1] = 0;

                    
                    if(konec($polje) == true)
					{
						$odziv = new Response("zmaga", true);
						return $odziv;
					}
					else if(konec($polje) == "remi")
					{
						$odziv = new Response("remi", true);
						return $odziv;
					}
					
					$odziv = new Response($polje,true);
					
                    return $odziv;
                }
                else
                {
                    $odziv = new Response($polje,false);
					
                    return $odziv;
                }
            }
            else // ce pa diagonalno pojemo kmeta drugega igralca
            {
                if (($y1 - $y2 == 1 || $y2 - $y1 == 1) && ($x1-$x2 == 1) && $cilj == 2) // premik diagonalno
                {
                    $polje[$x2 - 1][$y2 - 1] = $polje[$x1 - 1][$y1 - 1];
                    $polje[$x1 - 1][$y1 - 1] = 0;

					
                    if(konec($polje) == true)
					{
						$odziv = new Response("zmaga", true);
						return $odziv;
					}
					else if(konec($polje) == "remi")
					{
						$odziv = new Response("remi", true);
						return $odziv;
					}
					
					$odziv = new Response($polje,true);
					
                    return $odziv;
                }
                else
                {
                    $odziv = new Response($polje,false);
					
                    return $odziv;
                }
            }
            break;
        case 2:
//----------------------------------------------ČRNE FIGURICE----------------------------------------------
            if ($y1 == $y2) // če gre za premik naravnost
            {
                if ($x1 == 2 && ($x2 - $x1) == 2 && $cilj == 0 && $polje[$x1][$y1 - 1] == 0) // če gre za premik za dve polji
                {
                    $polje[$x2 - 1][$y2 - 1] = $polje[$x1 - 1][$y1 - 1];
                    $polje[$x1 - 1][$y1 - 1] = 0;
                    
					if(konec($polje) == true)
					{
						$odziv = new Response("zmaga", true);
						return $odziv;
					}
					else if(konec($polje) == "remi")
					{
						$odziv = new Response("remi", true);
						return $odziv;
					}
					
                    $odziv = new Response($polje,true);
					
                    return $odziv;
                }
                else if ($x2 - $x1 == 1 && $cilj == 0) // če gre za premik za eno polje
                {
                    $polje[$x2 - 1][$y2 - 1] = $polje[$x1 - 1][$y1 - 1];
                    $polje[$x1 - 1][$y1 - 1] = 0;

                    if(konec($polje) == true)
					{
						$odziv = new Response("zmaga", true);
						return $odziv;
					}
					else if(konec($polje) == "remi")
					{
						$odziv = new Response("remi", true);
						return $odziv;
					}
					
					$odziv = new Response($polje,true);
					
                    return $odziv;
                }
                else
                {
                    $odziv = new Response($polje,false);
					
                    return $odziv;
                }
            }
            else // ce pa diagonalno pojemo kmeta drugega igralca
            {
                if (($y1 - $y2 == 1 || $y2 - $y1 == 1) && ($x2 - $x1 == 1) && $cilj == 1) // premik diagonalno
                {
                    $polje[$x2 - 1][$y2 - 1] = $polje[$x1 - 1][$y1 - 1];
                    $polje[$x1 - 1][$y1 - 1] = 0;

					if(konec($polje) == true)
					{
						$odziv = new Response("zmaga", true);
						return $odziv;
					}
					else if(konec($polje) == "remi")
					{
						$odziv = new Response("remi", true);
						return $odziv;
					}
					
                    $odziv = new Response($polje,true);
					
                    return $odziv;
                }
                else
                {
                    $odziv = new Response($polje,false);
					
                    return $odziv;
                }
            }
            break;
        default:
            $odziv = new Response($polje,false);
			
            return $odziv;
            break;
    }
}
?>
