<!-- stran za izpis podatkov o uporabniki -->
<center><h1>Profil</h1></center>
<?php if(isset($_SESSION['id']))
{
	if($_SESSION['id'] == $_GET['id'])
	{
?>
<center><a href="?controller=osebe&action=uredi&id=<?php echo $_GET['id']; ?>" class="btn btn-primary">Uredi <span class="glyphicon glyphicon-pencil"></span></a></center>
<?php 
	}
}
?>
<table class="table table-hover telefon">
    <thead>
      <tr>
        <th>Ime</th>
        <th>Priimek</th>
        <th>Uporabniško ime</th>
		<th>Elektronski naslov</th>
		<th>ELO</th>
      </tr>
    </thead>
    <tbody>
	
  <tr>
  <td>
	<?php echo $oseba->ime; ?>
  </td>
  <td>
	<?php echo $oseba->priimek; ?>
  </td>
  <td>
	<?php echo $oseba->upime; ?>
  </td>
  <td>
	<?php echo $oseba->enaslov; ?>
  </td>
  <td>
	<?php echo $oseba->ELO; ?>
  </td>    
 </tr>
    </tbody>
  </table>
  <?php
	if($_SESSION['id'] != $_GET['id'])
	{
  ?>
  <center><button type="button" id="izzovi" class="btn btn-danger">Izzovi <span class="glyphicon glyphicon-screenshot"></span></button></center>
<?php }
	else
	{ ?>
<center><h1>Zgodovina</h1></center>
<table class="table table-hover table-condensed">
    <thead>
      <tr>
        <th>Nasprotnik</th>
        <th>Število potez</th>
		<th>Izid</th>
		<th>Poglej</th>
      </tr>
    </thead>
    <tbody>
	
 <?php
	$db = Db::getInstance();
	$upid = $_GET['id'];
	$result = mysqli_query($db, "SELECT * FROM IgreProtiRacunalniku WHERE Igralec=(SELECT upime FROM oseba WHERE ID='$upid') ORDER BY ID DESC LIMIT 5") or die(mysqli_error($db));
	//(SELECT upime FROM osebe WHERE ID='$_GET[\'id\']')"
	while($row = mysqli_fetch_array($result, MYSQL_ASSOC))
	{
		echo "<tr>";
		echo "<td>";
		echo "Računalnik";
		echo "</td>";
		echo "<td>";
		echo $row["st_potez"];
		echo "</td>";
		echo "<td>";
		echo $row["izid"];
		echo "</td>";
		echo "<td>";
		$igra_id = $row["ID"];
		echo "<a href='index.php?controller=igra&action=replay&player=c&id=" . $igra_id . "' class='btn btn-primary'><span class='glyphicon glyphicon-repeat'></span> Replay</a>";
		echo "</td>";
		echo "</tr>";
	}
	$db = Db::getInstance();
	$upid = $_GET['id'];
	$result = mysqli_query($db, "SELECT * FROM IgreProtiOsebi WHERE igralec1ID='$upid' OR  igralec2ID='$upid' ORDER BY ID DESC LIMIT 5") or die(mysqli_error($db));
	//(SELECT upime FROM osebe WHERE ID='$_GET[\'id\']')"
	while($row = mysqli_fetch_array($result, MYSQL_ASSOC))
	{
		echo "<tr>";
		echo "<td>";
		if($row["igralec1ID"] == $upid)
		{
			$db = Db::getInstance();
			$nas2_id = $row["igralec2ID"];
			$result2 = mysqli_query($db, "SELECT upime FROM oseba WHERE ID='$nas2_id'");
			$row2 = mysqli_fetch_assoc($result2);
			$nas2_ime = $row2["upime"];
			echo "<a href='index.php?controller=osebe&action=profil&id=" . $nas2_id . "'>" . $nas2_ime . "</a>";
		}
		else
		{
			$db = Db::getInstance();
			$nas1_id = $row["igralec1ID"];
			$result1 = mysqli_query($db, "SELECT upime FROM oseba WHERE ID='$nas1_id'");
			$row1 = mysqli_fetch_assoc($result1);
			$nas1_ime = $row1["upime"];
			echo "<a href='index.php?controller=osebe&action=profil&id=" . $nas1_id . "'>" . $nas1_ime . "</a>";
		}
		echo "</td>";
		echo "<td>";
		echo $row["stevilo_potez"];
		echo "</td>";
		echo "<td>";
		if($row["zmagovalec"] == $upid)
		{
			echo "zmaga";
		}
		else
		{
			echo "poraz";
		}
		echo "</td>";
		echo "<td>";
		$igra_id = $row["ID"];
		echo "<a href='index.php?controller=igra&action=replay&player=p&id=" . $igra_id . "' class='btn btn-primary'><span class='glyphicon glyphicon-repeat'></span> Replay</a>";
		echo "</td>";
		echo "</tr>";
	}
?>
    </tbody>
  </table>
  <?php	
	}?>
  <script>
					$(document).ready(function(){
						$("#izzovi").click(function(){
							$.ajax({
								method: "POST",
								url: "funkcije.php",
								data: {"izzovi": true, posiljatelj: "<?php echo $_SESSION['id']; ?>", prejemnik: "<?php echo $_GET['id']; ?>"},
								success: function(data){
									alert(data);
								},
								error: function(data){
									alert(JSON.stringify(data));
								}
							});

						});
					});
					</script>