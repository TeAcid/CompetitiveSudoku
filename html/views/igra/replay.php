<?php
if(isset($_POST['polje_izpis']))
{
	$fenPolje = new Fen();
	$polje = $_POST['polje_izpis'];
}
else
{
	$polje = array ( // igralno polje
	array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
	array ( 2, 2, 2, 2, 2, 2, 2, 2 ),
	array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
	array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
	array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
	array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
	array ( 1, 1, 1, 1, 1, 1, 1, 1 ),
	array ( 0, 0, 0, 0, 0, 0, 0, 0 ), );
}

$db = Db::getInstance();
$id_igra = $_GET["id"];
$result = mysqli_query($db, "SELECT Od, Do FROM Poteze WHERE TK_ID_Igra='$id_igra'") or die;
$poteze = array();
$id = 0;
while ($row = mysqli_fetch_assoc($result))
{
	$poteze[$id] = $row['Od'] . ":" . $row['Do'];
	$id++;
}
?>
<script>
$(document).ready(function(){
	var polje= <?php echo json_encode($poteze); ?>;
	ZgodovinaIgre(polje);
});
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
		<center><h2>Zgodovina igre</h2></center>
		<div id ="igralno_polje">
		<?php
		Igranje::izrisi_polje($polje);
		?>
		</div>
		<br/>
		</div>
		<div class="col-sm-3">
			<div class="row">
				</br></br>
				<center><h4>Poteze</h4></center>
				<center><table class="table table-condensed" id="potezeRacunalnik">
					<thead>
						<tr>
							<th>#</th>
							<th>Iz</th>
							<th>Na</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table></center>
			</div>
		<button type="button" id="prev" class="btn btn-success">Prejšnja</button>
		<button type="button" id="next" class="btn btn-success">Naslednja</button>
		</div>
	</div>
</div>