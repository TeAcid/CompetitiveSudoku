<h3>Seznam prijateljev: </h3>
<?php
require_once("connection.php");
$db = Db::getInstance();

$result = mysqli_query($db, "SELECT * FROM oseba");
echo "<table>";
while($prijatelji = mysqli_fetch_array($result))
{
	$id = $prijatelji['ID'];
	$query = mysqli_query($db, "SELECT * FROM osebaAktivna WHERE osebaID = '$id'");
	$r = mysqli_fetch_array($query);
	if($r['osebaID'] == $prijatelji['ID'])
	{
		echo "<tr><td><img src='../../slike/zelena.png' width='40' height='40' alt='zelena'/></td><td><b><a href='?controller=osebe&action=profil&id=".$prijatelji['ID']."'> ". $prijatelji['upime'] . "</a></b></td></tr>";
	}
	else
	{
		echo "<tr><td><img src='../../slike/rdeca.png' width='40' height='40' alt='rdeca'/></td><td><b><a href='?controller=osebe&action=profil&id=".$prijatelji['ID']."'> ". $prijatelji['upime'] . "</a></b></td></tr>";
	}
}
echo "</table>";

?>