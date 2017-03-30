<h3>Obvestila</h3>
<h4>Prejeti izzivi:</h5>
<div id="text" style="width: 20%; height: 10%;"> </div>
<h4>Poslani izzivi:</h5>
<div id="stanje" style="width: 40%; height: 10%;"> </div>
<script>
$(document).ready(function(){
	$.ajax({
		method: "POST",
		url: "funkcije.php",
		data: {"izziv": true, "uporabnik": <?php echo $_SESSION['id']; ?>},
		success: function(data){
			document.getElementById("text").innerHTML = data;
		}
	});
			
	$(document).on("click", "#gumbOK", function(){
		var igralec2 = this.name;
			$.ajax({
				method: "POST",
				url: "funkcije.php",
				data: {"sprejmi": true, "posiljatelj": igralec2, "prejemnik":<?php echo $_SESSION['id']; ?>},
				success: function(){
					$.ajax({
						method: "POST",
						url: "funkcije.php",
						data: {"novaIgra": true, "igralec1": <?php echo $_SESSION['id']; ?>, "igralec2": igralec2 },
						success: function(data){
							window.location.href = "index.php?controller=igra&action=game&id="+ data +"";
							}
					});
				}
			});	
		});
		
	
	$(document).on("click", "#gumbNO", function(){
		var pos = this.name;
			$.ajax({
				method: "POST",
				url: "funkcije.php",
				data: {"izbris": true, "posiljatelj": pos, "prejemnik":<?php echo $_SESSION['id']; ?>},
				success: function(){
					window.location.reload();
				}
			});
	});	

	$.ajax({
		method: "POST",
		url: "funkcije.php",
		data: {"preveriStanje": true, uporabnik: "<?php echo $_SESSION['id']; ?>"},
		success: function(data){
			document.getElementById("stanje").innerHTML = data;
		},
		error: function(data){
			alert(JSON.stringify(data));
		}
	});	
	
	window.setInterval(function(){
		$.ajax({
			method: "POST",
			url: "funkcije.php",
			data: {"preveriStanje": true, uporabnik: "<?php echo $_SESSION['id']; ?>"},
			success: function(data){
				document.getElementById("stanje").innerHTML = data;
			},
			error: function(data){
				alert(JSON.stringify(data));
			}
		});
		
		$.ajax({
			method: "POST",
			url: "funkcije.php",
			data: {"izziv": true, "uporabnik": <?php echo $_SESSION['id']; ?>},
			success: function(data){
				document.getElementById("text").innerHTML = data;
			}
		});
	}, 5000);
});
</script>