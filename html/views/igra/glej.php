<!-- stran za izpis podatkov o uporabniki -->
<center><h2>Opazuj igre drugih igralcev</h2></center>
 <?php
	$db = Db::getInstance();
	$result = mysqli_query($db, "SELECT ID, igralec1ID, igralec2ID FROM IgreProtiOsebi WHERE aktivna='da'");
	$num_rows = $result->num_rows;

	if ($num_rows > 0)
	{
		echo "<table class='table table-hover'>".
		"<thead>".
		  "<tr>".
			"<th>1. Igralec</th>".
			"<th>2. Igralec</th>".
			"<th>ELO</th>".
			"<th>Opazuj</th>".
		  "</tr>".
		"</thead>".
		"<tbody>";
		
		while($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			$db = Db::getInstance();
			$up_id1 = $row["igralec1ID"];
			$up_id2 = $row["igralec2ID"];
			$result1 = mysqli_query($db, "SELECT upime, ELO FROM oseba WHERE ID='$up_id1'");
			$row1 = mysqli_fetch_assoc($result1);
			$up_ime1 = $row1["upime"];
			$result2 = mysqli_query($db, "SELECT upime, ELO FROM oseba WHERE ID='$up_id2'");
			$row2 = mysqli_fetch_assoc($result2);
			$up_ime2 = $row2["upime"];
			$elo = ($row1["ELO"] + $row2["ELO"])/2;
			echo "<tr>";
			echo "<td>";
			echo "<b><a href='index.php?controller=osebe&action=profil&id=" .  $up_id1 . "'>" . $up_ime1 . "</a></b>";
			echo "</td>";
			echo "<td>";
			echo "<b><a href='index.php?controller=osebe&action=profil&id=" .  $up_id2 . "'>" . $up_ime2 . "</a></b>";
			echo "</td>";
			echo "<td>";
			echo $elo;
			echo "</td>";
			echo "<td>";
			echo "<a href='index.php?controller=igra&action=game&id=" . $row["ID"] . "' class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span> Opazuj</a>";
			echo "</td>";
			echo "</tr>";
		}
	}
	else
	{
		echo "<center>Trenutno ni aktivnih iger!</center>";
	}
?>
    </tbody>
  </table>