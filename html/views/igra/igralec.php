<html>
<div class="container-fluid">
	<div class="progress" id="CakanjeNasprotnika">
	  <div class="progress-bar progress-bar-striped active" role="progressbar" id="loading"
	  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
	  Počakajte trenutek!
	  </div>
	</div>
	<div class="modal fade bs-example-modal-sm" id="myPleaseWait" tabindex="-1"
		role="dialog" aria-hidden="true" data-backdrop="static">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">
						<span class="glyphicon glyphicon-time">
						</span> Iskanje nasprotnika
					 </h4>
				</div>
				<div class="modal-body">
					<div class="progress">
						<div class="progress-bar progress-bar-info
						progress-bar-striped active"
						style="width: 100%">
						</div>
					</div>
					<div class="btn btn-danger" id="prekini" style="width: 100%">Prekini</div>
				</div>
			</div>
		</div>
	</div>
<script>
$(document).ready(function(){
	var $progress = $('#CakanjeNasprotnika');
	var $progressBar = $('#loading');
	
	setTimeout(function() {
	$progressBar.css('width', '10%');
		setTimeout(function() {
		$progressBar.css('width', '20%');
			setTimeout(function() {
			$progressBar.css('width', '30%');
				setTimeout(function() {
				$progressBar.css('width', '40%');
					setTimeout(function() {
					$progressBar.css('width', '50%');
						setTimeout(function() {
						$progressBar.css('width', '60%');
							setTimeout(function() {
								$progressBar.css('width', '70%');
								setTimeout(function() {
									$progressBar.css('width', '80%');
									setTimeout(function() {
										$progressBar.css('width', '90%');
										setTimeout(function() {
										$progressBar.css('width', '100%');
											setTimeout(function() {
											$progress.css('display', 'none');
											$('#myPleaseWait').modal('show');
												$.ajax({
													method: "POST",
													url: "UI/ranking.php",
													data: {"iskanje": true, 'izziv': true, 'id':<?php echo $_SESSION['id']; ?>},
													success: function(data){
														var id = data;
														$.ajax({
															method: "POST",
															url: "funkcije.php",
															data: {"igraj": true, igralec: "<?php echo $_SESSION['id']; ?>", prejemnik: id},
															success: function(data){
																if(data > 0)
																{
																	window.location.href = "index.php?controller=igra&action=game&id="+ data +"";
																}
															}
														});
													}
												});
											}, 1000);
										}, 1000);	
									}, 1000);
								}, 1000);
							}, 1000);
						}, 1000);
					}, 1000);
				}, 1000);
			}, 1000);
		}, 1000);
	}, 1000);
		
	$.ajax({
		method: "POST",
		url: "funkcije.php",
		data: {"preveriStanje": true, uporabnik: "<?php echo $_SESSION['id']; ?>", 'alert': true},
		success: function(data){
			if(data > 0)
			{
				$('#myPleaseWait').modal('hide');
				window.location.href = "index.php?controller=igra&action=game&id="+ data +"";
			}
		}
	});
	
	window.setInterval(function(){
		$.ajax({
			method: "POST",
			url: "funkcije.php",
			data: {"preveriStanje": true, uporabnik: "<?php echo $_SESSION['id']; ?>", 'alert': true},
			success: function(data){
				if(data > 0)
				{
					$('#myPleaseWait').modal('hide');
					window.location.href = "index.php?controller=igra&action=game&id="+ data +"";
				}
			}
		});
	}, 1000);
	
	$('#prekini').click(function(){
		$.ajax({
			method: "POST",
			url: "funkcije.php",
			data: {"izbris": true, 'prejemnik': <?php echo $_SESSION['id']; ?>, "lobby": true},
			success: function(){
				$('#myPleaseWait').modal('hide');
				window.location.href = "index.php?controller=igra&action=zacetna";
			}
		});
	});
});
</script>
</div>
</html>