<?php
error_reporting(0);
include "../connection.php";

if(isset($_POST['zmagovalec']))
{
	$db = Db::getInstance();
	//ID igre
	$igraID = $_POST['igraID'];
	
	//Podatki iz igre
	$query_igra = mysqli_query($db, "SELECT * FROM IgreProtiOsebi WHERE ID = $igraID");
	$igra = mysqli_fetch_array($query_igra);
	
	//ID igralca 1
	$igralec1ID = $igra['igralec1ID'];
	//ID igralca 2
	$igralec2ID = $igra['igralec2ID'];
	
	//Podatki igralca 1
	$query_igralec1 = mysqli_query($db, "SELECT * FROM oseba WHERE ID = $igralec1ID");
	$igralec1 = mysqli_fetch_array($query_igralec1);
	
	//Podatki igralca 2
	$query_igralec2 = mysqli_query($db, "SELECT * FROM oseba WHERE ID = $igralec2ID");
	$igralec2 = mysqli_fetch_array($query_igralec2);
	
	//Razlika ELO med dvema igralcoma
	$razlikaELO = $igralec1['ELO'] - $igralec2['ELO'];
	
	//Če je razlika manjša od 0, potem jo množimo z -1 da dobimo pozitivno vrednost
	if($razlikaELO < 0)
	{
		$razlikaELO = $razlikaELO * (-1);
	}
	
	//Čas trajanja igre v minutah
	$zacetek_igre = $igra['zacetek_igre'];
	$konec_igre = $igra['konec_igre'];
	 
	$zacetek = strtotime($zacetek_igre);
	$konec = strtotime($konec_igre);
	$trajanjeIgre = ($konec - $zacetek)/60;
	
	$stevilo_potez = $igra['stevilo_potez']/2;
	
	//če je zmagovalec igralec 1
	if($igra['zmagovalec'] == $igralec1['ID'])
	{
		if($razlikaELO <= 50)
		{
			//14 - 14
			$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+14 WHERE ID = $igralec1ID");
			$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-14 WHERE ID = $igralec2ID");
		}
		else if($razlikaELO > 50 && $razlikaELO <= 100)
		{
			//16 - 12
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+12 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-12 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+16 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-16 WHERE ID = $igralec2ID");				
			}
		}
		else if($razlikaELO > 100 && $razlikaELO <= 150)
		{
			//18 - 10
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+10 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-10 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+18 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-18 WHERE ID = $igralec2ID");				
			}
		}
		else if($razlikaELO > 150 && $razlikaELO <= 200)
		{
			//20 - 8
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+8 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-8 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+20 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-20 WHERE ID = $igralec2ID");				
			}
		}
		else if($razlikaELO > 200 && $razlikaELO <= 250)
		{
			//22 - 6
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+6 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-6 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+22 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-22 WHERE ID = $igralec2ID");				
			}
		}
		else if($razlikaELO > 250 && $razlikaELO <= 300)
		{
			//24 - 4
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+4 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-4 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+24 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-24 WHERE ID = $igralec2ID");				
			}
		}
		else
		{
			//26 - 2
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+2 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-2 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+26 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-26 WHERE ID = $igralec2ID");				
			}
		}
		
		if($trajanjeIgre <= 1)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 10 WHERE ID = $igralec1ID");
		}
		if($trajanjeIgre > 1 && $trajanjeIgre <= 3)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 7 WHERE ID = $igralec1ID");
		}
		if($trajanjeIgre > 3 && $trajanjeIgre <= 5)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 4 WHERE ID = $igralec1ID");
		}
		if($trajanjeIgre >5 && $trajanjeIgre <= 7)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 2 WHERE ID = $igralec1ID");
		}
		
		if($stevilo_potez <= 10)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 10 WHERE ID = $igralec1ID");
		}
		if($stevilo_potez <= 15)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 8 WHERE ID = $igralec1ID");
		}
		if($stevilo_potez <= 20)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 6 WHERE ID = $igralec1ID");
		}
		if($stevilo_potez <= 25)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 4 WHERE ID = $igralec1ID");
		}
		if($stevilo_potez <= 30)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 2 WHERE ID = $igralec1ID");
		}		
	}
	//če je zmagovalec igralec 2
	else
	{
		if($razlikaELO <= 50)
		{
			//14 - 14
			$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-14 WHERE ID = $igralec1ID");
			$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+14 WHERE ID = $igralec2ID");
		}
		else if($razlikaELO > 50 && $razlikaELO <= 100)
		{
			//16 - 12
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-16 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+16 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-12 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+12 WHERE ID = $igralec2ID");				
			}
		}
		else if($razlikaELO > 100 && $razlikaELO <= 150)
		{
			//18 - 10
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-18 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+18 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-10 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+10 WHERE ID = $igralec2ID");				
			}
		}
		else if($razlikaELO > 150 && $razlikaELO <= 200)
		{
			//20 - 8
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-20 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+20 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-8 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+8 WHERE ID = $igralec2ID");				
			}
		}
		else if($razlikaELO > 200 && $razlikaELO <= 250)
		{
			//22 - 6
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-22 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+22 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-6 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+6 WHERE ID = $igralec2ID");				
			}
		}
		else if($razlikaELO > 250 && $razlikaELO <= 300)
		{
			//24 - 4
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-24 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+24 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-4 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+4 WHERE ID = $igralec2ID");				
			}
		}
		else
		{
			//26 - 2
			if($igralec1['ELO'] > $igralec2['ELO'])
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-26 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+26 WHERE ID = $igralec2ID");
			}
			else
			{
				$query1 = mysqli_query($db, "UPDATE oseba SET ELO = ELO-2 WHERE ID = $igralec1ID");
				$query2 = mysqli_query($db, "UPDATE oseba SET ELO = ELO+2 WHERE ID = $igralec2ID");				
			}
		}

		if($trajanjeIgre <= 1)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 10 WHERE ID = $igralec2ID");
		}
		if($trajanjeIgre > 1 && $trajanjeIgre <= 3)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 7 WHERE ID = $igralec2ID");
		}
		if($trajanjeIgre > 3 && $trajanjeIgre <= 5)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 4 WHERE ID = $igralec2ID");
		}
		if($trajanjeIgre >5 && $trajanjeIgre <= 7)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 2 WHERE ID = $igralec2ID");
		}

		if($stevilo_potez <= 10)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 10 WHERE ID = $igralec2ID");
		}
		if($stevilo_potez <= 15)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 8 WHERE ID = $igralec2ID");
		}
		if($stevilo_potez <= 20)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 6 WHERE ID = $igralec2ID");
		}
		if($stevilo_potez <= 25)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 4 WHERE ID = $igralec2ID");
		}
		if($stevilo_potez <= 30)
		{
			$query = mysqli_query($db, "UPDATE oseba SET ELO = ELO + 2 WHERE ID = $igralec2ID");
		}		
	}
}

if(isset($_POST['iskanje']))
{
	$id = $_POST['id'];
	$ELO = array();
	$db = Db::getInstance();
	
	$up = mysqli_query($db, "SELECT * FROM oseba WHERE ID = $id");
	$uporabnik = mysqli_fetch_array($up);
	
	$query = mysqli_query($db, "SELECT * FROM oseba WHERE ID <> $id");
	
	if(mysqli_num_rows($query) > 0)
	{
		while($result = mysqli_fetch_array($query))
		{
			if(($result['ELO'] - $uporabnik['ELO']) < 0)
			{
				$ELO[] = array(($result['ELO'] - $uporabnik['ELO'])*(-1), $result['upime']);
			}
			else
			{
				$ELO[] = array($result['ELO'] - $uporabnik['ELO'], $result['upime']);
			}
		}
		//$min = min( array_map("max", $ELO) );
		array_multisort($ELO, SORT_ASC);
		// echo $ELO[0][1];
	}
	
	if(isset($_POST['izziv']))
	{
		$vrni = true;
		for($i=0; $i<5; $i++)
		{
			if($vrni)
			{
				$upime = $ELO[$i][1];
				$query = mysqli_query($db, "SELECT ID FROM oseba WHERE upime = '$upime'");
				$result = mysqli_fetch_array($query);
				
				// $preveriStanje = mysqli_query($db, "SELECT * FROM IgreProtiOsebi WHERE aktivna = 'da' AND (igralec1ID = $result[0] OR igralec2ID = $result[0])");
				$preveriStanje = mysqli_query($db, "SELECT * FROM lobby WHERE igralecID = $result[0]");
				$preveriAktivnost = mysqli_query($db, "SELECT * FROM osebaAktivna WHERE osebaID = $result[0]");
				
				if(mysqli_num_rows($preveriStanje) > 0 AND mysqli_num_rows($preveriAktivnost) > 0)
				{
					echo $result[0];
					$vrni = false;
				}
			}
		}
	}
	else
	{
		echo "<table class='table table-striped table-condensed'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>Uporabnik</th>";
		echo "<th>Razlika ELO (+/-)</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach ($ELO as $array){
			$query = mysqli_query($db, "SELECT ID FROM oseba WHERE upime = '$array[1]'");
			$result = mysqli_fetch_array($query);
			echo  "<tr><td><a href='index.php?controller=osebe&action=profil&id=" . $result[0] ."'>" . $array[1] . "</a></td><td>" . $array[0] . "</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
}
?>