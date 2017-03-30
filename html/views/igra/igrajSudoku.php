<html>
	<head>
	<style>
		<!--Za izris nastavitev-->
		form, form > .panel{
			position: absolute;
			right: 3%;
			height: 25%;
			width: 20%;
			margin-top: 20px;
		}
		
		<!--Za izris polja-->
		td:nth-child(3), td:nth-child(6){
			border-right: solid 5px black;
		}
		
		tr:nth-child(3), tr:nth-child(6){
			border-bottom: solid 5px black;
		}
		
		table{
			width: 50%;
			height: 100%;
			position: absolute;
			left: 25%;
			margin-top: 20px;
			border: solid 5px black;
		}
		
		.sudokuTile, .praznoPolje{
			width: 5%;
			height: 5%;
			text-align: center;
			font-weight: bold;
			font-size: 35px;
			line-height: 35px;
			border: solid 2px black;
		}
		
		tr:nth-child(4) :nth-child(1),
		tr:nth-child(5) :nth-child(1),
		tr:nth-child(6) :nth-child(1),
		tr:nth-child(4) :nth-child(2),
		tr:nth-child(5) :nth-child(2),
		tr:nth-child(6) :nth-child(2),
		tr:nth-child(4) :nth-child(3),
		tr:nth-child(5) :nth-child(3),
		tr:nth-child(6) :nth-child(3),
		tr:nth-child(4) :nth-child(8),
		tr:nth-child(5) :nth-child(8),
		tr:nth-child(6) :nth-child(8),
		tr:nth-child(4) :nth-child(7),
		tr:nth-child(5) :nth-child(7),
		tr:nth-child(6) :nth-child(7),
		tr:nth-child(4) :nth-child(9),
		tr:nth-child(5) :nth-child(9),
		tr:nth-child(6) :nth-child(9),
		tr:nth-child(1) :nth-child(4),
		tr:nth-child(1) :nth-child(5),
		tr:nth-child(1) :nth-child(6),
		tr:nth-child(2) :nth-child(4),
		tr:nth-child(2) :nth-child(5),
		tr:nth-child(2) :nth-child(6),
		tr:nth-child(3) :nth-child(4),
		tr:nth-child(3) :nth-child(5),
		tr:nth-child(3) :nth-child(6),
		tr:nth-child(7) :nth-child(4),
		tr:nth-child(7) :nth-child(5),
		tr:nth-child(7) :nth-child(6),
		tr:nth-child(8) :nth-child(4),
		tr:nth-child(8) :nth-child(5),
		tr:nth-child(8) :nth-child(6),
		tr:nth-child(9) :nth-child(4),
		tr:nth-child(9) :nth-child(5),
		tr:nth-child(9) :nth-child(6)
		{
			background-color: #eff0f1;
		}
	</style>
	</head>
<body>

<div id="obvestila" style="position: absolute; left: 10%; height: 25%; width: 20%; margin-top: 20px;"></div>
<div id="sudoku"></div>
<form action="" method="POST">
	<div class="panel panel-default">
	  <div class="panel-heading">Možnosti</div>
	  <div class="panel-body">
		<label style="font-weight: bold;">Težavnost</label>
		<!-- Radio buttoni -->
		<div class="radio">
		  <label><input type="radio" name="tezavnost" value="easy" checked>Easy</label>
		</div>
		<div class="radio">
		  <label><input type="radio" name="tezavnost" value="medium">Medium</label>
		</div>
		<div class="radio">
		  <label><input type="radio" name="tezavnost" value="hard">Hard</label>
		</div>
		<input type="button" class="btn btn-info" value="Sprejmi nastavitve" id="btnTezavnost">
		<input type="button" class="btn btn-success" value="Preglej" id="btnPreglej">
	  </div>
	</div>
</form>
<div class="helpMe" style="max-width: 350px; position:absolute; margin-top:20px; left: 2%;">
	<a href="#" rel="tooltip" title="Verjetno se sprašujete kako ta stvar deluje. Povem vam. Kliknite na poljubno celico in s pomočjo tipk na tipkovnice vnašajte števila. Have fun. <3">
		<span style="font-size: 2em;" class="glyphicon glyphicon-question-sign"></span>
	</a>
</div>

</body>
</html>

<script>
	$(document).ready(function(){
		//Za tooltip
		$(document).ready(function () {
		  $("a").tooltip({
			'selector': '',
			'placement': 'bottom',
			'container':'body'
		  });
		});
		//
		$("#carouselContainer").hide();
		$("footer").hide();
		$("body").css( "height", "90%" );
		
		//pretvorba string v array
		function stringToArray(str)
		{
			var polje = [
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			   [0, 0, 0, 0, 0, 0, 0, 0, 0],
			];
			
			var stevec = 0;
			for(var i = 0; i < 9; i++)
			{
				for(var j = 0; j < 9; j++)
				{
					polje[i][j] = str[stevec];
					stevec++;
				}
			}
			
			return polje;
			console.log(polje);
		}

		//prvo nalaganje polja (default easy)
		var resitev = "";
		$.ajax({
		  method: "POST",
		  url: "funkcije.php",
		  data: {'izris': true },
		  success: function(data){
			var arr = data.split("<span>");
			$("#sudoku").html(arr[0]);
			resitev = stringToArray(arr[1]);
		  },
		  error: function(data){
			alert("NAPAKA:" + JSON.stringify(data));
		  }
		});
		
		var currX = "", currY = "", prevX = "", prevY = "", prevColor;
		//Za spreminjanje težavnosti
		$("#btnTezavnost").click(function(){
			val = $('input[name=tezavnost]:checked', 'form').val();
			$.ajax({
				  method: "POST",
				  url: "funkcije.php",
				  data: {'izris': true, 'tezavnost': val},
				  success: function(data){
					currX = "";
					currY = "";
					prevX = "";
					prevY = "";
					prevColor = "";
					var arr = data.split("<span>");
					$("#sudoku").hide().html(arr[0]).fadeIn(2000);
					resitev = stringToArray(arr[1]);
				  },
				  error: function(data){
					alert("NAPAKA:" + JSON.stringify(data));
				  }
			});
		});
		
		var colours = [
			   ["white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white"],
			   ["white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white"],
			   ["white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white"],
			   ["#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1"],
			   ["#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1"],
			   ["#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1"],
			   ["white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white"],
			   ["white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white"],
			   ["white", "white", "white", "#eff0f1", "#eff0f1", "#eff0f1", "white", "white", "white"],
		];
			
		var sudokuMap = [
			[1, 1, 1, 2, 2, 2, 3, 3, 3],
			[1, 1, 1, 2, 2, 2, 3, 3, 3],
			[1, 1, 1, 2, 2, 2, 3, 3, 3],
			[4, 4, 4, 5, 5, 5, 6, 6, 6],
			[4, 4, 4, 5, 5, 5, 6, 6, 6],
			[4, 4, 4, 5, 5, 5, 6, 6, 6],
			[7, 7, 7, 8, 8, 8, 9, 9, 9],
			[7, 7, 7, 8, 8, 8, 9, 9, 9],
			[7, 7, 7, 8, 8, 8, 9, 9, 9],
		];
			
		//Igranje
		var fuckit = false;
		$(document).on("click", ".sudokuTile", function(){
						
			if(prevColor == "rgb(255, 0, 0)" && fuckit)
			{
				var table = $("table")[0];
				var cell = table.rows[currY].cells[currX];
				$(cell).css("background-color", prevColor);
				fuckit = false;
			}
		
			$(document).unbind("keypress");
			//Sprememba barve nazaj prejšnje celice
			if(currX !== "" && currY !== "")
			{
				var table = $("table")[0];
				var cell = table.rows[currY].cells[currX];
				console.log($(table.rows[currY].cells[currX]).css("background-color"));
				if($(table.rows[currY].cells[currX]).css("background-color") != "rgb(255, 0, 0)")
				{
					console.log("hi");
					$(cell).css("background-color", colours[currY][currX]);
				}
			}
			
			//
			currX = this.cellIndex;
			currY = this.parentNode.rowIndex;
			console.log(currX + " " + currY);
			
			//Sprememba barve trenutne celice
			prevColor = $(this).css('backgroundColor');
			$(this).css("background-color", "#fffe66");

			fuckit = true;
			var currCell = $(this);
			//Vnos številke
			$(document).keypress(function(e) {
				if(e.which == 49 || e.which == 50 || e.which == 51 || e.which == 52 || e.which == 53 || e.which == 54 || e.which == 55 || e.which == 56 || e.which == 57) {
					//alert(e.keyCode);
					currCell.html(String.fromCharCode(e.keyCode));
					var table = $("table")[0];
					for(var i = 0; i < 9; i++)
					{
						//console.log(table.rows[currY].cells[i].innerHTML + " kk " + String.fromCharCode(e.keyCode));
						if(table.rows[currY].cells[i].innerHTML == String.fromCharCode(e.keyCode) && currX !== i)
						{
							currCell.css("background-color", "#ff0000");
						}

						if(table.rows[i].cells[currX].innerHTML == String.fromCharCode(e.keyCode) && currY !== i)
						{
							currCell.css("background-color", "red");
						}
					}
					
					console.log(sudokuMap[currY][currX] + " san");
					if(sudokuMap[currY][currX] === 1)
					{
						for(var i = 0; i < 3; i++)
						{
							for(var j = 0; j < 3; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					else if(sudokuMap[currY][currX] === 2)
					{
						for(var i = 0; i < 3; i++)
						{
							for(var j = 3; j < 6; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					else if(sudokuMap[currY][currX] === 3)
					{
						for(var i = 0; i < 3; i++)
						{
							for(var j = 6; j < 9; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					else if(sudokuMap[currY][currX] === 4)
					{
						for(var i = 3; i < 6; i++)
						{
							for(var j = 0; j < 3; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					else if(sudokuMap[currY][currX] === 5)
					{
						for(var i = 3; i < 6; i++)
						{
							for(var j = 3; j < 6; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					else if(sudokuMap[currY][currX] === 6)
					{
						for(var i = 3; i < 6; i++)
						{
							for(var j = 6; j < 9; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					else if(sudokuMap[currY][currX] === 7)
					{
						for(var i = 6; i < 9; i++)
						{
							for(var j = 0; j < 3; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					else if(sudokuMap[currY][currX] === 8)
					{
						for(var i = 6; i < 9; i++)
						{
							for(var j = 3; j < 6; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					else
					{
						for(var i = 6; i < 9; i++)
						{
							for(var j = 6; j < 9; j++)
							{
								if(i != currY && j != currX && table.rows[i].cells[j].innerHTML == String.fromCharCode(e.keyCode))
								{
									currCell.css("background-color", "#ff0000");
								}
							}
						}
					}
					
					fuckit = false;
				}
			});
		});
		
		//Button preglej
		$("#btnPreglej").click(function(){
			var count = 0;
			for(var i = 0; i < 9; i++)
			{
				for(var j = 0; j < 9; j++)
				{
					//console.log($("table")[0].rows[i].cells[j].innerHTML);
					if($("table")[0].rows[i].cells[j].innerHTML == resitev[i][j])
					{
						//console.log("yes");
						count++;
					}
				}
			}
			
			//Preveri se, če se vsa polja ujemajo
			if(count == 81)
			{
				$("#obvestila").html("<span style='color: green; font-weight: bold; font-size: 20px;'>ZMAGALI STE</span>");
			}
			else
			{
				$("#obvestila").html("<span style='color: red; font-weight: bold; font-size: 20px;'>VZTRAJAJTE ŠE MALO</span>");
			}
		});
	});
</script>