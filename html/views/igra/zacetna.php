<div class="container-fluid">
	<div class="col-sm-6">
		<center>
			<form action="?controller=igra&action=racunalnik" method="POST" id="formRacunalnik" class="col-md-6 col-md-offset-3">
			<table>
				<tr>
					<td>
						<center><h3>Igraj z računalnikom</h3></center>
					</td>
				</tr>
				<tr>
					<td>
						<center><img src="../../slike/icon_computer.jpg" width="200" height="200" alt="igraj_z_racunalnikom"/></center>
					</td>
				</tr>
				<tr>
					<td>
						<center><button class="btn btn-primary btn-lg" type="submit" name="Racunalnik">Igraj</button></center>
					</td>
				</tr>
			</table>
			</form>
		</center>
	</div>
	<div class="col-sm-6">
		<center>
			<form action="?controller=igra&action=igralec" method="POST" id="formIgralec" class="col-md-6 col-md-offset-3">
			<table>
				<tr>
					<td>
						<center><h3>Igraj z drugimi igralci</h3></center>
					</td>
				</tr>
				<tr>
					<td>
						<center><img src="../../slike/icon_user.jpg" width="200" height="200" alt="igraj_z_drugim_igralcem"/></center>
					</td>
				</tr>
				<tr>
					<td>
						<center><button class="btn btn-primary btn-lg" type="submit" name="Igralec">Igraj</button></center>
					</td>
				</tr>
			</table>
			</form>
		</center>
	</div>
</div>
	<h2> Igralci, ki so ti po točkah najbližje </h2>
	<div id="igralci"> </div>
<script>
$(document).ready(function(){
	$.ajax({
		method: "POST",
		url: "UI/ranking.php",
		data: {'iskanje': true, 'id': <?php echo $_SESSION['id']; ?>},
		success: function(data){
			$("#igralci").html(data);
			// alert(data);
		}
	});	
	
	window.setInterval(function(){	
		$.ajax({
			method: "POST",
			url: "UI/ranking.php",
			data: {'iskanje': true, 'id': <?php echo $_SESSION['id']; ?>},
			success: function(data){
				$("#igralci").html(data);
			}
		});
	}, 10000);
});
</script>