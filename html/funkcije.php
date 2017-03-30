<?php
require_once("connection.php");

class Igranje
{
	public static function izrisi_polje($polje) //funkcija za izris polja
	{
		echo "<center><table style= 'border-style: solid; border-width: 1px; border-color: black;'>";
		
		echo "<tr>";
		for ($i = 0; $i < 9; $i++) // izpis prvih vrstic z številkami
		{
			if($i == 0)
			{
				echo "<td style='border-style: solid; border-width: 1px; border-color: black; text-align: center;'><div class='content'><b></b></div></td>";
			}
			else
			{
				echo "<td style='text-align: center;'><div class='content'><b style='font-size: 3vw; vertical-align: middle;'>";echo $i;echo "</b></div></td>";
			}
		}
		echo "</tr>";
		
		for($i = 0; $i < 8; $i++){
			echo "<tr>";
			
			for($y = 0; $y < 9; $y++){ // izpis drugih vrstic z številkami
				if($y == 0)
				{
					echo "<td style= 'text-align: center; background-color: white;'><div class='content'><b style='font-size: 3vw; vertical-align: middle;'>";echo $i+1;echo "</b></div>";
				}
				else
				{
					if(($i+$y) % 2 == 0){ //za vsa temna polja
						if($polje[$i][$y-1] == 1) // če je za to polje v polju vrednost ena damo belo figurico
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $y;echo "><div class='content bela'><img src='../../slike/white.png' alt='white' height='100%'/></div>";
						}
						else if ($polje[$i][$y-1] == 2) // če je za to polje v polju vrednost dva damo črno figurico
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $y;echo "><div class='content crna'><img src='../../slike/black.png' alt='black' height='100%'/></div>";
						}
						else // če pa nobeno pa pustimo prazno
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $y;echo "><div class='content'></div>";
						}
					}
					else{
						if($polje[$i][$y-1] == 1) // če je za to polje v polju vrednost ena damo belo figurico
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $y;echo "><div class='content bela'><img src='../../slike/white.png' alt='white' height='100%'/></div>";
						}
						else if ($polje[$i][$y-1] == 2) // če je za to polje v polju vrednost dva damo črno figurico
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $y;echo "><div class='content crna'><img src='../../slike/black.png' alt='black' height='100%'/></div>";
						}
						else // če pa nobeno pa pustimo prazno
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $y;echo "><div class='content'></div>";
						}
					}
				}
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</table></center>";
	}
	
	public static function izrisi_polje_tutorial($polje)
	{
		echo "<table style= 'border-style: solid; border-width: 1px; border-color: black;'>";	
		for($i = 0; $i < 8; $i++)
		{
			echo "<tr>";
			
			for($j = 0; $j < 8; $j++)
			{
				if($i % 2 == 0)
				{
					if($j % 2 == 0)
					{
						if($polje[$i][$j] == 1) // če je za to polje v polju vrednost ena damo belo figurico
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $j;echo "><div class='content bela'><img src='../../slike/white.png' alt='white' height='100%'/></div>";
						}
						else if ($polje[$i][$j] == 2) // če je za to polje v polju vrednost dva damo črno figurico
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $j;echo "><div class='content crna'><img src='../../slike/black.png' alt='black' height='100%'/></div>";
						}
						else // če pa nobeno pa pustimo prazno
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $j;echo "><div class='content'></div>";
						}
					}
					else
					{
						if($polje[$i][$j] == 1) // če je za to polje v polju vrednost ena damo belo figurico
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $j;echo "><div class='content bela'><img src='../../slike/white.png' alt='white' height='100%'/></div>";
						}
						else if ($polje[$i][$j] == 2) // če je za to polje v polju vrednost dva damo črno figurico
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $j;echo "><div class='content crna'><img src='../../slike/black.png' alt='black' height='100%'/></div>";
						}
						else // če pa nobeno pa pustimo prazno
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $j;echo "><div class='content'></div>";
						}
					}
				}
				else
				{
					if($j % 2 == 0)
					{
						if($polje[$i][$j] == 1) // če je za to polje v polju vrednost ena damo belo figurico
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $j;echo "><div class='content bela'><img src='../../slike/white.png' alt='white' height='100%'/></div>";
						}
						else if ($polje[$i][$j] == 2) // če je za to polje v polju vrednost dva damo črno figurico
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $j;echo "><div class='content crna'><img src='../../slike/black.png' alt='black' height='100%'/></div>";
						}
						else // če pa nobeno pa pustimo prazno
						{
							echo "<td style='border-style: solid; border-width: 1px; border-color: #222222; background-color: #d8b58f;' id=";echo $i+1;echo $j;echo "><div class='content'></div>";
						}
					}
					else
					{
						if($polje[$i][$j] == 1) // če je za to polje v polju vrednost ena damo belo figurico
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $j;echo "><div class='content bela'><img src='../../slike/white.png' alt='white' height='100%'/></div>";
						}
						else if ($polje[$i][$j] == 2) // če je za to polje v polju vrednost dva damo črno figurico
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $j;echo "><div class='content crna'><img src='../../slike/black.png' alt='black' height='100%'/></div>";
						}
						else // če pa nobeno pa pustimo prazno
						{
							echo "<td style= 'border-style: solid; border-width: 1px; border-color: #222222; background-color: #8c6238;' id=";echo $i+1;echo $j;echo "><div class='content'></div>";
						}
					}
				}
			}
			
			echo "</tr>";
		}
		echo "</table>";
	}
	
	public static function SummonSudoku($niz)
	{
		echo "<table>";
		for($i = 0; $i < 9; $i++)
		{
			echo "<tr>";
			for($j = 0; $j < 9; $j++)
			{	
				if($niz[$i * 9 + $j] == 0)
				{
					echo "<td class='sudokuTile'></td>";
				}
				else
				{
					echo "<td class='praznoPolje'>"; echo $niz[$i * 9 + $j]; echo "</td>";
				}
			}
			echo "</tr>";
		}
		echo "</table>";
	}
}

if(isset($_POST["izris"]))
{
	$tezavnost = "easy";
	if(isset($_POST["tezavnost"]))
	{
		$tezavnost = $_POST["tezavnost"];
	}
	
	$db = Db::getInstance();
	$result = mysqli_query($db, "SELECT * FROM templates WHERE tezavnost = '$tezavnost'");
	
	//rezultati se shranijo v polje
	$results = "";
	$i = 0;
	if(mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$results[$i] = $row;
			$i++;
		}
	}
	mysqli_free_result($result);
	
	//Izbira naključnega
	$len = sizeof($results);
	$num = rand(0, $len - 1);
	Igranje::SummonSudoku($results[$num]["izris"]);
	echo "<span>" . $results[$num]["resitev"];
}
//Za globalni chat
/*if(isset($_POST['upime']) && isset($_POST['chat']))
{
	$db = Db::getInstance();
	$result = mysqli_query($db, "CALL novoSporocilo('$_POST[upime]', '$_POST[chat]')") or die("Napaka" . mysqli_error($db));
}

if(isset($_POST['chat']))
{
	$db = Db::getInstance();
	$result = mysqli_query($db, "SELECT UpIme, Sporocilo, Datum FROM GlobalChat ORDER BY datum ASC LIMIT 30");
	if(mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$db = Db::getInstance();
			$up_ime = $row["UpIme"];
			$result1 = mysqli_query($db, "SELECT ID FROM oseba WHERE upime='$up_ime'");
			$row1 = mysqli_fetch_assoc($result1);
			$up_id = $row1["ID"];
			$loceno = explode(" ", $row["Datum"]);
			$date = explode("-", $loceno[0]);
			$datum = $loceno[1] . " " . $date[2] . "." . $date[1] . "." . $date[0];
			echo "<div class='well well-sm' id='globalChatSporocilo'>";
			echo "<b><a href='index.php?controller=osebe&action=profil&id=" .  $up_id . "'>" . $row["UpIme"] . "</a></b></br><i>" . $datum . "</i><br/>" . $row["Sporocilo"]  . "</br>";
			echo "</div>";
		}

		mysqli_free_result($result);
	}
}

//Za izziv
if(isset($_POST['izzovi']))
{
	$db = Db::getInstance();
	$posiljatelj = $_POST['posiljatelj'];
	$prejemnik = $_POST['prejemnik'];
	
	if(isset($_POST['lobby']))
	{
		$query = mysqli_query($db, "INSERT INTO izziv (posiljatelj, prejemnik, stanje, lobby) VALUES ('$posiljatelj', '$prejemnik', 1, 'da')");
	}
	else
	{
		$query = mysqli_query($db, "INSERT INTO izziv (posiljatelj, prejemnik, stanje) VALUES ('$posiljatelj', '$prejemnik', 1)");
		if($query)
		{
			echo "Poslali ste izziv!";
		}
		else
		{
			echo "Napaka";
		}
	}
}

if(isset($_POST['igraj']))
{
	$posiljatelj = $_POST['igralec'];
	$prejemnik = $_POST['prejemnik'];
	$db = Db::getInstance();
	
	$preveri = mysqli_query($db, "SELECT * FROM IgreProtiOsebi WHERE aktivna = 'da' AND ((igralec1ID = $posiljatelj AND igralec2ID = $prejemnik) OR (igralec1ID = $prejemnik AND igralec2ID = $posiljatelj))");
	if(mysqli_num_rows($preveri) > 0)
	{
		$result = mysqli_fetch_array($preveri);
		echo $result['ID'];
	}
	else
	{
		$query = mysqli_query($db, "INSERT INTO IgreProtiOsebi (igralec1ID, igralec2ID, aktivna) VALUES ($posiljatelj, $prejemnik, 'da')");
		$last_id = mysqli_insert_id($db);
		echo $last_id;
		$query = mysqli_query($db, "INSERT INTO potezeOseba (TK_ID_igra, OD, DO, KDO) VALUES ('$last_id', '8/pppppppp/8/8/8/8/PPPPPPPP/8 w', '8/pppppppp/8/8/8/8/PPPPPPPP/8 w', 'zacetek')");
	}
}

//prikaz izziva osebi
if(isset($_POST['izziv']))
{
	$db = Db::getInstance();
	$uporabnik = $_POST['uporabnik'];
	
	if(isset($_POST['lobby']))
	{
		$query = mysqli_query($db, "SELECT DISTINCT * FROM izziv WHERE prejemnik = $uporabnik AND lobby = 'da' AND stanje = 1");
		if(mysqli_num_rows($query) > 0)
		{
			echo true;
		}
		else
		{
			echo false;
		}
	}
	else
	{
		$query = mysqli_query($db, "SELECT DISTINCT posiljatelj, stanje FROM izziv WHERE prejemnik = $uporabnik");
		
		if(mysqli_num_rows($query) > 0)
		{
			while($iz = mysqli_fetch_array($query))
			{
				if($iz[1] == 1)
				{
					$id = $iz[0];
					$result = mysqli_query($db, "SELECT upime FROM oseba WHERE ID = $id");
					$ime = mysqli_fetch_array($result);
					echo "<ul>";
					echo "<li>" . $ime[0] . "</li>";
					echo "<button class='btn btn-success' type='submit' id='gumbOK' name='$id'>Sprejmi </button> <button class=' btn btn-danger' type='submit' id='gumbNO' name='$id'>Zavrni </button> ";
					echo "</ul>";
				}
			}
		}
		else
		{
			echo "Nimate novega izziva.";
		}	
		mysqli_free_result($query);
	}
}

//Zavrnitev igre
if(isset($_POST['izbris']))
{
	$db = Db::getInstance();
	$prejemnik = $_POST['prejemnik'];
	
	if(isset($_POST['lobby']))
	{
		$query = mysqli_query($db, "DELETE FROM lobby WHERE igralecID = $prejemnik");
	}
	else
	{
		$posiljatelj = $_POST['posiljatelj'];
		$query = mysqli_query($db, "DELETE FROM izziv WHERE posiljatelj = $posiljatelj AND prejemnik = $prejemnik");
	}
}

//Sprejem igre
if(isset($_POST['novaIgra']))
{
	$db = Db::getInstance();
	$igralec1 = $_POST['igralec1'];
	$igralec2 = $_POST['igralec2'];
	
	$query = mysqli_query($db, "INSERT INTO IgreProtiOsebi (igralec1ID, igralec2ID, aktivna) VALUES ($igralec1, $igralec2, 'da')");
	
	if($query)
	{
		$last_id = mysqli_insert_id($db);
		echo $last_id;
		$query = mysqli_query($db, "INSERT INTO potezeOseba (TK_ID_igra, OD, DO, KDO) VALUES ('$last_id', '8/pppppppp/8/8/8/8/PPPPPPPP/8 w', '8/pppppppp/8/8/8/8/PPPPPPPP/8 w', 'zacetek')");
	}
	else
	{
		echo "Napaka";
	}
}

//Sprejem igre, spremenimo stanje za preverjanje če je uporabnik že sprejel ali še ni
if(isset($_POST['sprejmi']))
{
	$db = Db::getInstance();
	$posiljatelj = $_POST['posiljatelj'];
	$prejemnik = $_POST['prejemnik'];
	
	$query = mysqli_query($db, "UPDATE izziv SET stanje=0 WHERE posiljatelj = $posiljatelj AND prejemnik = $prejemnik");
}

//Preverjanje če se je uporabnik že odzval
if(isset($_POST['preveriStanje']))
{
	$db = Db::getInstance();
	$id = $_POST['uporabnik'];
	
	$query = mysqli_query($db, "SELECT * FROM izziv WHERE posiljatelj = $id");

	if(mysqli_num_rows($query) > 0)
	{
		$result = mysqli_fetch_array($query);
		if($result['stanje'] == 0)
		{
			$query = mysqli_query($db, "SELECT * FROM IgreProtiOsebi WHERE igralec2ID = $id ORDER BY ID DESC");
			$last_id = mysqli_fetch_array($query);
			if($last_id['aktivna'] == "da")
			{
				if(isset($_POST['alert']))
				{
					echo $last_id['ID'];
				}
				else
				{
					echo "Oseba je sprejela izziv. <a href='index.php?controller=igra&action=game&id=". $last_id['ID'] . "'><button type='button' class='btn btn-default btn-sm active'><span class='glyphicon glyphicon-screenshot'></span> IGRAJ </button></a>";
				}
			}
			else
			{
				if(isset($_POST['alert']))
				{
					echo -1;
				}
				else
				{
					echo "Nimate novih izzivov.";
				}
			}
		}
		else
		{
			echo "Oseba se še ni odzvala na vaš izziv.";
		}
	}
	else
	{
		echo "Nimate novih izzivov.";
	}
	
	mysqli_free_result($query);
}

if(isset($_POST['zmaga']))
{
	if(isset($_POST['igralec1']))
	{
		$db = Db::getInstance();
		$id = $_POST['id'];
		$result = mysqli_query($db, "SELECT igralec1ID FROM IgreProtiOsebi WHERE ID = $id");
		$igralec = mysqli_fetch_array($result);
		$zmaga = $igralec[0];
		
		mysqli_free_result($result);
		
		$result = mysqli_query($db, "SELECT COUNT(*) FROM potezeOseba WHERE TK_ID_igra = $id");
		$stevilo = mysqli_fetch_array($result);
		$st_potez = $stevilo[0];
		
		$query = mysqli_query($db, "UPDATE IgreProtiOsebi SET aktivna = 'ne', konec_igre = now(), zmagovalec = $zmaga, stevilo_potez = $st_potez WHERE ID = $id");
	}
	
	if(isset($_POST['igralec2']))
	{
		$db = Db::getInstance();
		$id = $_POST['id'];
		
		$result = mysqli_query($db, "SELECT igralec2ID FROM IgreProtiOsebi WHERE ID = $id");
		$igralec = mysqli_fetch_array($result);
		$zmaga = $igralec[0];
		
		mysqli_free_result($result);
		
		$result = mysqli_query($db, "SELECT COUNT(*) FROM potezeOseba WHERE TK_ID_igra = $id");
		$stevilo = mysqli_fetch_array($result);
		$st_potez = $stevilo[0];
		
		$query = mysqli_query($db, "UPDATE IgreProtiOsebi SET aktivna = 'ne', konec_igre = now(), zmagovalec = $zmaga, stevilo_potez = $st_potez WHERE ID = $id");		
	}
}

if(isset($_POST['poraz']))
{
	$db = Db::getInstance();
	$id = $_POST['id'];
	
	$result = mysqli_query($db, "SELECT aktivna FROM IgreProtiOsebi WHERE ID = $id");
	$stanje = mysqli_fetch_array($result);

	if($stanje[0] == "ne")
	{
		echo true;
	}
	else
	{
		echo false;
	}
}

//Za učenje
/*$db = Db::getInstance();
$result = mysqli_query($db,"SELECT * FROM Tutorial");
$arrStanj = "";
$stevec = 0;

if(mysqli_num_rows($result) > 0)
{
	while ($tutorial = mysqli_fetch_assoc($result)) 
	{
		$arrStanj[$stevec] = $tutorial;
		$stevec++;
	}

	mysqli_free_result($result);
}

if(isset($_POST['učenje']))
{
	require_once("PPJ/fen.php");

	$fen = new Fen();
	$fen->fenToPolje($arrStanj[$_POST['učenje']]["Poteza_Od"]);
	$Polje_Od = $fen->GetPolje();
	Igranje::izrisi_polje_tutorial($Polje_Od);
}

if(isset($_POST["preveriTutorial"]) && isset($_POST["idFena"]))
{
	$id = $_POST["idFena"];
	$fen = $_POST["preveriTutorial"];
	//echo $fen . " " . $arrStanj[$id]["Poteza_Do"];
	if($fen == $arrStanj[$id]["Poteza_Do"])
	{
		echo json_encode("true");
	}
	else
	{
		echo json_encode("false");
	}
}

if(isset($_POST['premik']))
{
	require_once("PPJ/fen.php");
	$db = Db::getInstance();
	$id = $_POST['id'];

	$query = mysqli_query($db, "SELECT DO FROM potezeOseba WHERE ID = (SELECT MAX(ID) FROM potezeOseba WHERE TK_ID_igra = $id)");
	$result = mysqli_fetch_array($query);
	
	$fen = new Fen();
	$fen->fenToPolje($result[0]);
	$polje = $fen->GetPolje();
	Igranje::izrisi_polje($polje);
}

if(isset($_POST['preveriPremik']))
{
	$db = Db::getInstance();
	$id = $_POST['id'];
//	$uporabnik = $_POST['uporabnik'];
	$query = mysqli_query($db, "SELECT KDO FROM potezeOseba WHERE ID = (SELECT MAX(ID) FROM potezeOseba WHERE TK_ID_igra = $id)");
	$result = mysqli_fetch_array($query);
	
	echo $result[0];
	
}

if(isset($_POST['fen_poteza']))
{
	require_once("PPJ/fen.php");
	
	$fen = new Fen();
	$fen->fenToPolje($_POST['fen_poteza']);
	$polje = $fen->GetPolje();
	Igranje::izrisi_polje($polje);
}*/
?>