<?php
$db = Db::getInstance();
$id = $_GET['id'];
$query = mysqli_query($db, "SELECT * FROM IgreProtiOsebi WHERE ID = $id");
$row = mysqli_fetch_array($query);

$result = mysqli_query($db, "SELECT * FROM oseba WHERE ID = $row[1]");
$uporabnik = mysqli_fetch_array($result); 
$igralec1 = $uporabnik['upime'];
mysqli_free_result($result);

$result = mysqli_query($db, "SELECT * FROM oseba WHERE ID = $row[2]");
$uporabnik = mysqli_fetch_array($result);
$igralec2 = $uporabnik['upime'];
mysqli_free_result($result);
?>
<head>
<script>
$(document).ready(function(){	
	$.ajax({
		method: "POST",
		url: "funkcije.php",
		data: {"premik":true, 'id': <?php echo $id; ?>},
		success: function(data){
			$("#polje").html(data);
		}
	});
	
	stopInterval = false;
	izrisInterval = window.setInterval(function(){	
		$.ajax({
			method: "POST",
			url: "funkcije.php",
			data: {"premik": true, 'id': <?php echo $id; ?>},
			success: function(data){
				// alert(data);
				$("#polje").html(data);
				// Igranje::izrisi_polje(data);
			}
		});
		
		$.ajax({
			method: "POST",
			url: "funkcije.php",
			data: {'poraz': true, 'id': <?php echo $id; ?>},
			success: function(data){
				if(data)
				{
					window.location.href = "index.php?controller=igra&action=zacetna";
				}
			}
		});
		
		if(stopInterval == true)
		{
			clearInterval(izrisInterval);
		}
	}, 500);			
});
</script>
</head>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
		<?php
		if($_SESSION['id'] == $row[1])
		{
		echo "<center><h2>Igraš proti uporabniku: " . $igralec2 . "(črne figurice)</h2></center>";
		?>
		<script>
			window.setInterval(function(){
				$.ajax({
				method: "POST",
				url: "funkcije.php",
				data: {"preveriPremik": true, "id": <?php echo $id; ?>},
				success: function(data){
					var igralec = <?php echo json_encode($igralec2); ?>;
					//alert(data + " " + igralec);
					if(data == igralec || data == "zacetek")
					{
						//clearInterval(izrisInterval);
						stopInterval = true;
						
						naVrsti = "MIN";
						var id = location.search.split('&')[2].slice(3);
						//To se zgodi vse, če je na vrsti človek (ali katerokoli drugo živo bitje, ki igra našo igro)
						$("#polje").unbind("click").on("click", "div.content", function(){
							if(!$(this).hasClass("unclickable"))
							{
								if($(this).hasClass("bela"))
								{
									if($(this).hasClass("selected"))
									{
										clickCount = 0;
										TDfrom = "";
										TD = "";
									
										$(this).removeClass("selected");
									}
									else
									{
										if(clickCount == 0)
										{
											TDfrom = $(this).closest("td");
											clickCount++;
										}
										else
										{
											TDfrom = $(this).closest("td");
											clickCount = 1;
										}
									
										poteza_od = $(this).closest("td").attr("id");
										$("div").removeClass("selected");
										$(this).addClass("selected");
									}

								//S funkcijo se pretvori tabela v polje
								arr = TableToArray();
								fen = PoljeToFen(arr, "w");
								}
								else if(clickCount == 1 && naVrsti == "MIN")
								{
									//sem pride figura po potezi
									TD = $(this).closest("td");

									clickCount = 0;
									poteza_do = $(this).closest("td").attr("id");
									
									poteza = poteza_od + "-" + poteza_do;
									//Zdaj ko imamo potezo, jo pošljemo v validacija.php,
									//kjer se validira
									$.ajax({
									  method: "POST",
									  url: "UI/validacija.php",
									  data: {'poteza': poteza, 'fen': fen, 'igralec': true, 'igralec1': true, 'id': id},
									  success: function(data){
										response = JSON.stringify(data);
										//Če je poteza veljavna
										
										if(response == "\"true\"" || response == "\"zmaga\"" || response == "\"remi\"")
										{
											$.ajax({
											  method: "POST",
											  url: "PPJ/fen.php",
											  data: {'getRow': true, 'igralec': true, 'igralec1': true},
											  success: function(data){
												row = fenToTableRow(data, true);
												$("#potezeRacunalnik tbody").append(row);
												$("#potezeRacunalnik tbody").hide();
												$("#potezeRacunalnik tbody").fadeIn(900);
											  },
											  error: function(data){
												alert("NAPAKA:" + JSON.stringify(data));
											  }
											});				
											if(response == "\"true\"")
											{
												TD.html("<div class='content bela'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
												TDfrom.html("<div class='content'></div>");											
												$("div.content").removeClass("selected");
												$("#polje").off("click", "div.content");
												
												stopInterval = false;
												izrisInterval = window.setInterval(function(){	
													$.ajax({
														method: "POST",
														url: "funkcije.php",
														data: {"premik": true, 'id': <?php echo $id; ?>},
														success: function(data){
															// alert(data);
															$("#polje").html(data);
															// Igranje::izrisi_polje(data);
														}
													});
													
													$.ajax({
														method: "POST",
														url: "funkcije.php",
														data: {'poraz': true, 'id': <?php echo $id; ?>},
														success: function(data){
															if(data)
															{
																window.location.href = "index.php?controller=igra&action=zacetna";
															}
														}
													});
													
													if(stopInterval == true)
													{
														clearInterval(izrisInterval);
													}
												}, 500);
											}
											else if(response == "\"zmaga\"")
											{
												TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
												TDfrom.html("<div class='content'></div>");																										
												$.ajax({
													method: "POST",
													url: "funkcije.php",
													data: {'zmaga': true, 'igralec1': true, 'id': id},
													success: function()
													{
														
													}
												});
												
												$.ajax({
													method: "POST",
													url: "UI/ranking.php",
													data: {'zmagovalec': true, 'igraID': id},
													success: function(data)
														{
															//alert("Zmaga!!");	
															alert(data);
														}
												});
												window.location.href = "index.php?controller=igra&action=zacetna";
											}
											else if(response == "\"remi\"")
											{
												TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
												TDfrom.html("<div class='content'></div>");												
												alert("Remi!!!");
											}
											//drugače
											else
											{
												alert("Neveljavna poteza!!!");
												$("div.content").removeClass("selected");	
											}
										}
										else
										{
											alert("Neveljavna poteza");
											$("div.content").removeClass("selected");
										}
									  },
									  error: function(data){
										alert(JSON.stringify(data));
									  }
									});
								}
							}	
						});
					}
				}
				});
			}, 500);
		</script>
		<?php
		}
		else if($_SESSION['id'] == $row[2])
		{
		echo "<center><h2>Igraš proti uporabniku: " . $igralec1 . "(bele figurice)</h2></center>";
		?>
		<script>
			window.setInterval(function(){
				$.ajax({
				method: "POST",
				url: "funkcije.php",
				data: {"preveriPremik": true, "id": <?php echo $id; ?>},
				success: function(data){
					var igralec = <?php echo json_encode($igralec2); ?>;
					//alert(data + " " + igralec);
						if(data != igralec && data != "zacetek")
						{
						naVrsti = "MAX";
						//clearInterval(izrisInterval);
						stopInterval = true;
						
						var id = location.search.split('&')[2].slice(3);
						$("#polje").unbind("click").on("click", "div.content", function(){
							if(!$(this).hasClass("unclickable"))
							{
								if($(this).hasClass("crna"))
								{
									if($(this).hasClass("selected"))
									{
										clickCount = 0;
										TDfrom = "";
										TD = "";
									
										$(this).removeClass("selected");
									}
									else
									{
										if(clickCount == 0)
										{
											TDfrom = $(this).closest("td");
											clickCount++;
										}
										else
										{
											TDfrom = $(this).closest("td");
											clickCount = 1;
										}
								
										poteza_od = $(this).closest("td").attr("id");
										$("div").removeClass("selected");
										$(this).addClass("selected");
									}

									//S funkcijo se pretvori tabela v polje
									arr = TableToArray();
									fen = PoljeToFen(arr, "b");
								}
								else if(clickCount == 1 && naVrsti == "MAX")
								{
									//sem pride figura po potezi
									TD = $(this).closest("td");

									clickCount = 0;
									poteza_do = $(this).closest("td").attr("id");
									
									poteza = poteza_od + "-" + poteza_do;
									//Zdaj ko imamo potezo, jo pošljemo v validacija.php,
									//kjer se validira
									$.ajax({
									  method: "POST",
									  url: "UI/validacija.php",
									  data: {'poteza': poteza, 'fen': fen, 'igralec': true, 'igralec2': true, 'id': id},
									  success: function(data){
										response = JSON.stringify(data);
										//Če je poteza veljavna
										if(response == "\"true\"" || response == "\"zmaga\"" || response == "\"remi\"")
										{
											$.ajax({
											  method: "POST",
											  url: "PPJ/fen.php",
											  data: {'getRow': true, 'igralec': true, 'igralec2': true},
											  success: function(data){
												row = fenToTableRow(data, false);
												$("#potezeRacunalnik tbody").append(row);
												$("#potezeRacunalnik tbody").hide();
												$("#potezeRacunalnik tbody").fadeIn(900);
											  },
											  error: function(data){
												alert("NAPAKA:" + JSON.stringify(data));
											  }
											});		
											if(response == "\"true\"")
											{
												TD.html("<div class='content crna'><img src='../../slike/black.png' alt='black' height='100%'/></div>");
												TDfrom.html("<div class='content'></div>");
												$("div.content").removeClass("selected");
												$("#polje").off("click", "div.content");
												
												stopInterval = false;
												izrisInterval = window.setInterval(function(){	
													$.ajax({
														method: "POST",
														url: "funkcije.php",
														data: {"premik": true, 'id': <?php echo $id; ?>},
														success: function(data){
															// alert(data);
															$("#polje").html(data);
															// Igranje::izrisi_polje(data);
														}
													});
													
													$.ajax({
														method: "POST",
														url: "funkcije.php",
														data: {'poraz': true, 'id': <?php echo $id; ?>},
														success: function(data){
															if(data)
															{
																window.location.href = "index.php?controller=igra&action=zacetna";
															}
														}
													});
													
													if(stopInterval == true)
													{
														clearInterval(izrisInterval);
													}
												}, 500);	
											}
											else if(response == "\"zmaga\"")
											{
												TD.html("<div class='content crna unclickable'><img src='../../slike/black.png' alt='black' height='100%'/></div>");
												TDfrom.html("<div class='content'></div>");																									
												$.ajax({
													method: "POST",
													url: "funkcije.php",
													data: {'zmaga': true, 'igralec2': true, 'id': id},
													success: function()
													{
														alert("prvi ajax");
														$.ajax({
															method: "POST",
															url: "UI/ranking.php",
															data: {'zmagovalec': true, 'igraID': id},
															success: function()
															{
																alert("Zmaga!!!");																
															}
														});
													}
												});
												window.location.href = "index.php?controller=igra&action=zacetna";
											}
											else if(response == "\"remi\"")
											{
												TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
												TDfrom.html("<div class='content'></div>");												
												alert("Remi!!!");
											}
											//drugače
											else
											{
												alert("Neveljavna poteza!!!");
												$("div.content").removeClass("selected");	
											}
										}
										else
										{
											alert("Neveljavna poteza");
											$("div.content").removeClass("selected");
										}
									  },
									  error: function(data){
										alert(JSON.stringify(data));
									  }
									});
								}	
							}
						});
						}
				}
				});
			}, 500);
		</script>
		<?php
		}
		else
		{
			echo "<center><h2>Gledate igro med " .  $igralec1 ."(bele figurice) in ". $igralec2 ."(črne figurice)</h2></center>";
			?>
			<script>
				window.setInterval(function(){	
					$.ajax({
						method: "POST",
						url: "funkcije.php",
						data: {"premik": true, 'id': <?php echo $id; ?>},
						success: function(data){
							// alert(data);
							$("#polje").html(data);
							// Igranje::izrisi_polje(data);
						}
					});
				}, 500);
			</script>
			<?php
		}
		?>
		<div id="polje"></div>
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
			<div class="row">
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
							<input type="text" name="sporocilo" style="width: 80%;"><button type="submit" name="Sporocilo" style="width: 20%;"><center><span class="glyphicon glyphicon-envelope"></span></center></button>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>