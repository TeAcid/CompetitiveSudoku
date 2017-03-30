<?php
$polje = array ( // igralno polje
array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
array ( 2, 2, 2, 2, 2, 2, 2, 2 ),
array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
array ( 0, 0, 0, 0, 0, 0, 0, 0 ),
array ( 1, 1, 1, 1, 1, 1, 1, 1 ),
array ( 0, 0, 0, 0, 0, 0, 0, 0 ), );
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
		<center><h2>Igraš proti računalniku</h2></center>
		<?php
		//Preveri se, če je bila napravljena poteza 
		if(isset($_POST['poteza']))
		{
			Igranje::izrisi_polje(json_decode($_POST['poteza']));
		}
		//Na začetku je izrisana začetna postavittev
		else
		{
			Igranje::izrisi_polje($polje);
		}
		?>
		<br/>
		</div>
		<div class="col-sm-3">
			<div class="row">
				</br></br>
				<h4>Poteze</h4>	
				<center><table class="table table-condensed" id="potezeRacunalnik">
					<thead>
						<tr>
							<th>#</th>
							<th>Iz</th>
							<th>Na</th>
						</tr>
					</thead>
					<tbody>
						<!--<tr>
							<td>1</td>
							<td>[7,3]</td>
							<td>[6,3]</td>
						</tr>
						<tr>
							<td>2</td>
							<td>[7,5]</td>
							<td>[5,5]</td>
						</tr>-->
					</tbody>
				</table></center>
			</div>
			<!--<div class="row">
				<center><h4>Klepet</h4></center>
				<table class="table table-responsive">
					<tr>
						<td>
							<p>gregor1: zdravo!</p>
							<p>gregor2: pozdrav</p>
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="sporocilo" style="width: 80%;" disabled><button type="submit" name="Sporocilo" style="width: 20%;" disabled><center><span class="glyphicon glyphicon-envelope"></span></center></button>
						</td>
					</tr>
				</table>
			</div>-->
		</div>
	</div>
</div>