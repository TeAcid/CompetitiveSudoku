//Funkcija, ki pretvori dva fena v vrstico tabele
function fenToTableRow(fenConcat, player)
{
	//Dva fena splitamo v polje
	var DvaFena = fenConcat.split(":");
	//Fena se pretvorita v polje
	var polje1 = fenToPolje(DvaFena[0]);
	var polje2 = fenToPolje(DvaFena[1]);

	//Preveri se katera poteza je bila narejena
	var start_X = 0;
	var start_Y = 0;
	var end_X = 0;
	var end_Y = 0;
	var stevec = 0;

	for(i = 0; i < 8; i++)
	{
		for(j = 0; j < 8; j++)
		{
			if(polje1[i][j] != polje2[i][j])
			{
				if(stevec == 0)
				{
					stevec++;
					start_X = j + 1;
					start_Y = i + 1;
				}
				else 
				{
					end_X = j + 1;
					end_Y = i + 1;
				}
			}
		}
	}
	//Skonstruira se vrstica
	rowCount = $("#potezeRacunalnik>tbody>tr").length + 1;
	
	if(player == true)
	{
		vrstica = "<tr><td>" + rowCount + "</td><td>[" + end_Y + "," + end_X + "]</td><td>[" + start_Y + "," + start_X + "]</td></tr>";
	}
	else
	{	
		vrstica = "<tr><td>" + rowCount + "</td><td>[" + start_Y + "," + start_X + "]</td><td>[" + end_Y + "," + end_X + "]</td></tr>";
	}
	
	//Vrne se vrstica
	return vrstica;
}

//funkcija, ki pretvori fen v polje
function fenToPolje(fen)
{
	//Prvo se odstranita zadnjiva dva znaka iz niza 
	//rezultat se shrani v str
	str = fen.substring(0, fen.length - 2);
	//Nadomestimo P-je z 1/2 in številke z 0
	str = Replace(str);
	//Niz se exploda v polje
	str = str.split("/");

	var polje = [
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	];
	
	//Prvo se celo polje napolni z -1
	for(i = 0; i < 8; i++)
	{
		for(j = 0; j < 8; j++)
		{
			polje[i][j] = -1;
		}
	}

	//Potem pa se še napolni ostali del polja
	for(i = 0; i < 8; i++)
	{
		for(j = 0; j < 8; j++)
		{
			if(str[i][j] == 0)
			{
				polje[i][j] = 0;
			}
			else if(str[i][j] == 1)
			{
				polje[i][j] = 1;
			}
			else
			{
				polje[i][j] = 2;
			}
		}
	}

	return polje;
}

function Replace(s)
{
	//Prvo se zamenjajo številke
	s = s.replace(/1/g, "0");
	s = s.replace(/2/g, "00");
	s = s.replace(/3/g, "000");
	s = s.replace(/4/g, "0000");
	s = s.replace(/5/g, "00000");
	s = s.replace(/6/g, "000000");
	s = s.replace(/7/g, "0000000");
	s = s.replace(/8/g, "00000000");

	//Potem pa še P-ji
	s = s.replace(/p/g, "2");
	s = s.replace(/P/g, "1");

	return s;
}

//funckija, ki pridobi premik iz dveh polj (premik oblike xy-x1y2)
function getPremik(start_pos, end_pos)
{
	var start_X = 0;
	var start_Y = 0;
	var end_X = 0;
	var end_Y = 0;
	var stevec = 0;
	
	end_pos = $.parseJSON(end_pos);
	/*var a = [
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	];
	
	for(i = 0; i < 8; i++)
	{
		for(j = 0; j < 8; j++)
		{
			a[i][j] = end_pos[i][j];
		}
	}*/
	
	//Pridobimo koordinate pomaknjene figure (startne in končne)
	for(i = 0; i < 8; i++)
	{
		for(j = 0; j < 8; j++)
		{
			if(start_pos[i][j] != end_pos[i][j])
			{
				if(stevec == 0)
				{
					stevec++;
					start_X = j + 1;
					start_Y = i + 1;
				}
				else 
				{
					end_X = j + 1;
					end_Y = i + 1;
				}
			}
		}
	}
	
	var p =	start_Y + "" + start_X + "-" + end_Y + "" + end_X;
	return p;
}

//Funkcija, s katero se izvede računalnikov premik
function Move(start_pos, end_pos)
{
	var start_X = 0;
	var start_Y = 0;
	var end_X = 0;
	var end_Y = 0;
	var stevec = 0;
	
	end_pos = $.parseJSON(end_pos);
	/*var a = [
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	];
	
	for(i = 0; i < 8; i++)
	{
		for(j = 0; j < 8; j++)
		{
			a[i][j] = end_pos[i][j];
		}
	}*/
	
	//Pridobimo koordinate pomaknjene figure (startne in končne)
	for(i = 0; i < 8; i++)
	{
		for(j = 0; j < 8; j++)
		{
			if(start_pos[i][j] != end_pos[i][j])
			{
				if(stevec == 0)
				{
					stevec++;
					start_X = j + 1;
					start_Y = i + 1;
				}
				else 
				{
					end_X = j + 1;
					end_Y = i + 1;
				}
			}
		}
	}
	
	var TD_start = $("table tr:eq(" + start_Y + ") td:eq(" + start_X + ")");
	var TD_end = $("table tr:eq(" + end_Y + ") td:eq(" + end_X + ")");
	
	TD_start.find("div").addClass("selected");

	setTimeout(function(){	
		TD_start.find("div").removeClass("selected");
		TD_start.html("<div class='content'></div>");
		TD_end.html("<div class='content crna'><img src='../../slike/black.png' alt='black' height='100%'/></div>");
	}, 1000);
}

//Funkcija, ki pretvori tabelo v 2D polje
function TableToArray()
{
	arr = [
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	];
	
	var i = 0;
	var j = 0;
	
	$("td").each(function(){
		if($(this).find("div").hasClass("crna") && i > 0 && j > 0)
		{
			arr[j-1][i-1] = 2;
		}
		else if($(this).find("div").hasClass("bela") && i > 0 && j > 0)
		{
			arr[j-1][i-1] = 1;
		}
		
		i++;
		
		if(i == 9)
		{
			j++;
			i = 0;
		}
	});
	
	return arr;
}

//Funkcija, ki pretvori polje v FEN notacijo
function PoljeToFen(polje, bw)
{
	var str = "";
	var stevec = 0;
	
	for(i = 0; i < 8; i++)
	{
		for(j = 0; j < 8; j++)
		{
			if(polje[i][j] == 1)
			{
				str = str + "P";
			}
			else if(polje[i][j] == 2)
			{
				str = str + "p";
			}
			else if(polje[i][j] == 0)
			{
				stevec++;
				
				if(j == 7)
				{
					str = str + stevec;
					stevec = 0;
				}
				else if(polje[i][j + 1] == 1 || polje[i][j + 1] == 2)
				{
					str = str + stevec;
					stevec = 0;
				}
			}
			else
			{
				return false;
			}
		}
		
		str = str + "/";
	}
	
	str = str.substring(0, str.length - 1);
	str = str + " " + bw;

	return str;
}
	
//IGRANJE PROTI RAČUNALNIKU================================================================================
//Za štetje klikov
clickCount = 0;
//Poteza od in do
poteza_od = "";
poteza_do = "";
//Končna poteza (npr. 71-51)
poteza = "";
//Polje za shranjevanje stanj 
arr = "";
//FEN notacija
fen = "";
//Kdo je na vrsti (trenutno igralec - vedno beli (MIN), računalnik - vedno črni(MAX))
naVrsti = "MIN";
//V to celico pomaknemo figuro
TD = "";
//S te celice pomaknemo figuro
TDfrom = "";

function IgraProtiRačunalniku()
{
	if($("h2").text() == "Igraš proti računalniku")
	{
		//To se zgodi vse, če je na vrsti človek (ali katerokoli drugo živo bitje, ki igra našo igro)
		if(naVrsti == "MIN")
		{
			$("table").on("click", "div.content", function(){
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
				else if(clickCount == 1)
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
					  data: {'poteza': poteza, 'fen': fen, 'player': true},
					  success: function(data){
						response = JSON.stringify(data);
						//alert(poteza);
						//Če je poteza veljavna
						if(response == "\"true\"" || response == "\"zmaga\"" || response == "\"remi\"")
						{
							$.ajax({
							  method: "POST",
							  url: "PPJ/fen.php",
							  data: {'getRow': true, 'player': true},
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
								TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
								TDfrom.html("<div class='content'></div>");
								naVrsti = "MAX";													
								$("div.content").addClass("unclickable");
								$("div.content").removeClass("selected");	
										
								setTimeout(IgraProtiRačunalniku, 3000);
							}
							else if(response == "\"zmaga\"")
							{
								TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
								TDfrom.html("<div class='content'></div>");												
								$("div.content").addClass("unclickable");
								$("div.content").removeClass("selected");	
									
								alert("Zmaga!!!");
							}
							else if(response == "\"remi\"")
							{
								TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
								TDfrom.html("<div class='content'></div>");												
								$("div.content").addClass("unclickable");
								$("div.content").removeClass("selected");	
							
								alert("Remi!!!");
							}
							//drugače
							else
							{
								alert("Neveljavna poteza!!!");
								$("div.content").removeClass("selected");	
							}
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
		else
		{
			//Prvo v spremenljivko arr shranimo polje (trenutno stanje igre)
			arr = TableToArray();
			fen = PoljeToFen(arr, "b");

			//Potem se pošlje ajax zahteva, ki vrne računalnikov premik
			$.ajax({
			  method: "POST",
			  url: "UI/NegamaxAlfabeta.php",
			  data: {'fen': fen},
			  success: function(data){
				//S funkcijo izvedemo premik figure
				Move(arr, data);		
				poteza = getPremik(arr, data);
				//alert(poteza);
				//Tu se preveri, če je prišlo do remija ali zmage
				$.ajax({
				  method: "POST",
				  url: "UI/validacija.php",
				  data: {'poteza': poteza, 'fen': fen},
				  success: function(data){
					response = JSON.stringify(data);
					//alert(response);
					if(response == "\"zmaga\"")
					{
						TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
						TDfrom.html("<div class='content'></div>");												
						$("div.content").addClass("unclickable");
						$("div.content").removeClass("selected");	
							
						alert("Zmaga!!!");
					}
					else if(response == "\"remi\"")
					{
						TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
						TDfrom.html("<div class='content'></div>");												
						$("div.content").addClass("unclickable");
						$("div.content").removeClass("selected");	
					
						alert("Remi!!!");
					}
					else
					{
						naVrsti = "MIN";
						$("div.content").removeClass("unclickable");
					}
				 },
				 error: function(data){
					alert(JSON.stringify(data));
				  }
				});
				//_________________________________________________
					
				//Ta del je za posodabljanje tabele
				$.ajax({
				  method: "POST",
				  url: "PPJ/fen.php",
				  data: {'getRow': true, 'computer': true},
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
				//___________________________________
			  },
			  error: function(data){
				alert(JSON.stringify(data));
			  }
			});
		}
	}
}

//Funkcije za tutorial===============================================	
function stanjeIgrePoPremiku(currStanje, TD_from, TD_to, id)
{
	var TD_from_X = TD_from.index();
	var TD_from_Y = TD_from.closest("tr").index();
	var TD_to_X = TD_to.index();
	var TD_to_Y = TD_to.closest("tr").index();

	currStanje[TD_from_Y][TD_from_X] = 0;
	currStanje[TD_to_Y][TD_to_X] = 1;
	
	var res = "";
	//alert(currStanje);
	fen = PoljeToFen(currStanje, "w");
	//alert(fen);
	$.ajax({
	  method: "POST",
	  url: "funkcije.php",
	  async: false,
	  data: {'preveriTutorial': fen, 'idFena': id},
	  success: function(data){
		//alert(data);
		if(data == "\"true\"")
		{
			res = "true";
		}
		else
		{
			res = "false";
		}
	  }
	 });
	 
	return res;
}

//Funkcija, ki pretvori tabelo v 2D polje
function TableToArrayTutorial(num)
{
	arr = [
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	   [0, 0, 0, 0, 0, 0, 0, 0],
	];
	
	var i = 0;
	var j = 0;
	
	$("#" + num + " td").each(function(){
		if($(this).find("div").hasClass("crna"))
		{
			arr[j][i] = 2;
		}
		else if($(this).find("div").hasClass("bela"))
		{
			arr[j][i] = 1;
		}
		
		i++;
		
		if(i == 8)
		{
			j++;
			i = 0;
		}
	});
	
	return arr;
}

//Funkcija za resetiranje polja
function Izris(idVrstica, idDiv)
{
	$.ajax({
	  method: "POST",
	  url: "funkcije.php",
	  data: {'učenje': idVrstica, 'div': idDiv},
	  success: function(data){
		$("#" + idDiv).html(data);
	  },
	  error: function(data){
		alert(data);
	  }
	 });
}

Izris(0, 0);
Izris(2, 2);
Izris(3, 3);
Izris(6, 6);

//Za next button
$(document).on("click", ".next", function(){
	$('html, body').animate({
		scrollTop: $(this).parent(".container").parent(".container").next(".tutorialTable").offset().top
	}, 	1000);
});

//Funkcija za zgodovine iger===============================================================================================================
function ZgodovinaIgre(polje)
{
	poteza_id = -1;
	
	$.each(polje, function( index, value ) {
		if (index%2 == 0)
		{
			$("#potezeRacunalnik tbody").append(fenToTableRow(value, true));
		}
		else
		{
			$("#potezeRacunalnik tbody").append(fenToTableRow(value, false));
		}
	});

	$("#potezeRacunalnik tr").on("click" , function() {
		poteza_id = $(this).find("td:first").text()-1;
		var temp = polje[poteza_id].split(":");
		$.ajax({
		method: "POST",
		url: "funkcije.php",
		data: {'fen_poteza': temp[1]},
		success: function(data){
			$("#igralno_polje").html(data);
		},
		});
	});
	
	$("#next").on("click", function() {
		if(poteza_id < $("#potezeRacunalnik>tbody>tr").length-1)
		{
			poteza_id++;
			var temp = polje[poteza_id].split(":");
			$.ajax({
			method: "POST",
			url: "funkcije.php",
			data: {'fen_poteza': temp[1]},
			success: function(data){
				$("#igralno_polje").html(data);
			},
			});
		}
	});
	
	$("#prev").on("click", function() {
		if(poteza_id > 0)
		{
			poteza_id--;
			var temp = polje[poteza_id].split(":");
			$.ajax({
			method: "POST",
			url: "funkcije.php",
			data: {'fen_poteza': temp[1]},
			success: function(data){
				$("#igralno_polje").html(data);
			},
			});
		}
	});
}

//=========================================================================================================================================

$(document).ready(function(){
    //Ta del je za to, da tisti dropdown za prijavo ostane odprt
	//četudi uporabnik klikne kjer izven njega
	$('.dropdown').on({
		"shown.bs.dropdown": function() {
		  this.closable = false;
		},
		"click": function() {
		  this.closable = true;
		},
		"hide.bs.dropdown": function() {
		  return this.closable;
		}
	});

	//Za validacijo forme pri registraciji
	$('#formRegistracija').validate({
        rules: {
			ime: {
				required: true
			},
			priimek: {
				required: true
			},
			upime: {
				required: true
			},
            enaslov: {
                required: true,
                email: true
            },
			/*enaslov2: {
				required: true,
				equalTo: "#enaslov"
			},*/
            geslo: {
                minlength: 7,
                required: true
            },
			geslo2: {
				required: true,
				equalTo: "#geslo"
			},
        },
		errorElement: 'div',
		wrapper: 'div',
        highlight: function (element){
            $(element).closest('.input-group').removeClass('has-success').addClass('has-error');
			$("#alertRegistracija").css("visibility", "visible");
        },
        success: function (element) {
            $(element).closest('.input-group').removeClass('has-error').addClass('has-success');
        }
    });
	
	//CAROUSEL
	$('.carousel').carousel();
	
	IgraProtiRačunalniku();

	//UČENJE IGRE================================================================================================
	Izris(0, 0);
	Izris(2, 2);
	Izris(3, 3);
	Izris(6, 6);
	checkpoint = 0;
	$(document).on("click", ".tutorialTable table div.content", function(){
	if(!$(this).hasClass("unclickable"))
	{
		var idDiva = $(this).closest(".tutorialTable").attr("id");
		if(idDiva == 0 && checkpoint != 1)
		{
			checkpoint = 0;
		}
		
		if(idDiva == 2)
		{
			checkpoint = 2;
		}
		
		if(idDiva == 3 && checkpoint != 4 && checkpoint != 5)
		{
			checkpoint = 3;
		}
		
		if(idDiva == 6)
		{
			checkpoint = 6;
		}
		
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
				
				//poteza_od = $(this).closest("td").attr("id");
				$("div").removeClass("selected");
				$(this).addClass("selected");
			}

			//S funkcijo se pretvori tabela v polje
			arr = TableToArray();
			fen = PoljeToFen(arr, "w");
		}
		else if(clickCount == 1)
		{
			//sem pride figura po potezi
			TD = $(this).closest("td");
			rowIndex = TD.closest("tr").index();
			clickCount = 0;
			if(checkpoint == 0)
			{
				var stanje = TableToArrayTutorial(0);
				var test = stanjeIgrePoPremiku(stanje, TDfrom, TD, 0);
				if(test == "true")//idDiva == 0 && TD.index() == 3 && TDfrom.index() == 3 && rowIndex == 4)
				{
					TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
					TDfrom.html("<div class='content'></div>");
					//$("div.content").addClass("unclickable");
					$("div.content").removeClass("selected");
					
					setTimeout(function(){ 
						Izris(1, 0);
						$("b:first").html("<span class='glyphicon glyphicon-ok'></span>");
						$(".container#0 p:last").append("<p><b>Odlično!</b> Poteze kmetov za dva koraka naprej so le možne ob prvem premiku vsakega kmeta. Za tem se kmet lahko še samo premika po en korak naprej.</p><p><b> Navodilo:</b> Premaknite šestega kmeta od leve za eno naprej.</p>");
					}, 1500);
					
					checkpoint = 1;
				}
				else
				{
					TD.css("background-color", "red");
				}
			}
			else if(checkpoint == 1)
			{
				var stanje = TableToArrayTutorial(0);
				var test = stanjeIgrePoPremiku(stanje, TDfrom, TD, 1);
				if(test == "true")//idDiva == 0 && TD.index() == 5 && TDfrom.index() == 5 && rowIndex == 4)
				{
					TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
					TDfrom.html("<div class='content'></div>");
					$("div.content").addClass("unclickable");
					$("div.content").removeClass("selected");
					
					setTimeout(function(){ 
						//Izris(1, 0);
						$("b:eq(2)").html("<span class='glyphicon glyphicon-ok'></span>");
						$(".container#0 p:last").append("<p><p><b>Čestitam!</b> Osvojili ste premik figur!</p></p>");
						
						setTimeout(function(){
							$('html, body').animate({
								scrollTop: $(".tutorialTable:eq(1)").offset().top
							}, 	1000);
							$("div.content").removeClass("unclickable");
						}, 1000);
					}, 500);
					
					checkpoint = 2;
				}
				else
				{
					TD.css("background-color", "red");
				}
			}
			else if(checkpoint == 2)
			{
				var stanje = TableToArrayTutorial(2);
				var test = stanjeIgrePoPremiku(stanje, TDfrom, TD, 2);
				if(test == "true")//idDiva == 2 && TD.index() == 3 && TDfrom.index() == 4 && rowIndex == 3)
				{
					TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
					TDfrom.html("<div class='content'></div>");
					$("div.content").addClass("unclickable");
					$("div.content").removeClass("selected");
					
					setTimeout(function(){ 
						//Izris(1, 0);
						$(".container#2 b:first").html("<span class='glyphicon glyphicon-ok'></span>");
						$(".container#2 p:last").append("<p><p><b>Čestitam!</b> Osvojili ste snedenje nasprotnikovih figur!</p></p>");
						
						setTimeout(function(){
							$('html, body').animate({
								scrollTop: $(".tutorialTable:eq(2)").offset().top
							}, 	1000);
							$("div.content").removeClass("unclickable");
						}, 1000);
					}, 500);
					
					checkpoint = 3;
				}
				else
				{
					TD.css("background-color", "red");
				}
			}
			else if(checkpoint == 3)
			{
				var stanje = TableToArrayTutorial(3);
				var test = stanjeIgrePoPremiku(stanje, TDfrom, TD, 3);
				if(test == "true")//idDiva == 3 && TD.index() == 7 && TDfrom.index() == 6 && rowIndex == 4)
				{
					TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
					TDfrom.html("<div class='content'></div>");
					$("div.content").addClass("unclickable");
					$("div.content").removeClass("selected");
					
					setTimeout(function(){ 
						$(".container#3 b:first").html("<span class='glyphicon glyphicon-ok'></span>");
						$(".container#3 p:last").append("<p><p><b>Odlično!</b> Naslednji način kako priti do zmage je, da blokirate vse nasprotnikove figure, tako da se samo še vi lahko prosto premikate.</p></p><p><p><b>Navodilo:</b> Blokirajte nasprotnikovo figuro, tako da zmagate!</p></p>");
						Izris(4, 3);
					}, 1500);
					
					checkpoint = 4;
				}
				else
				{
					TD.css("background-color", "red");
				}
			}
			else if(checkpoint == 4)
			{
				var stanje = TableToArrayTutorial(3);
				var test = stanjeIgrePoPremiku(stanje, TDfrom, TD, 4);
				if(test == "true")//idDiva == 3 && TD.index() == 0 && TDfrom.index() == 0 && rowIndex == 5)
				{
					TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
					TDfrom.html("<div class='content'></div>");
					$("div.content").addClass("unclickable");
					$("div.content").removeClass("selected");
					
					setTimeout(function(){ 
						$(".container#3 b:eq(2)").html("<span class='glyphicon glyphicon-ok'></span>");
						$(".container#3 p:last").append("<p><p><b>Odlično!</b> Glavni način kako priti do zmage je to, da prideš na drugi konec plošče z enim od svojih kmetov.</p></p><p><p><b>Navodilo:</b> Premaknite se na konec plošče, tako da zmagate!</p></p>");
						Izris(5, 3);
					}, 1500);
					
					checkpoint = 5;
				}
				else
				{
					TD.css("background-color", "red");
				}
			}
			else if(checkpoint == 5)
			{
				var stanje = TableToArrayTutorial(3);
				var test = stanjeIgrePoPremiku(stanje, TDfrom, TD, 5);
				if(test == "true")//idDiva == 3 && TD.index() == 0 && TDfrom.index() == 0 && rowIndex == 0)
				{
					TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
					TDfrom.html("<div class='content'></div>");
					$("div.content").addClass("unclickable");
					$("div.content").removeClass("selected");
					
					setTimeout(function(){ 
						$(".container#3 b:eq(4)").html("<span class='glyphicon glyphicon-ok'></span>");
						$(".container#3 p:last").append("<p><b>Čestitam!</b> Osvojili ste zmaganje pri igri THE PAWN'S GAME!</p>");
						
						setTimeout(function(){
							$('html, body').animate({
								scrollTop: $(".tutorialTable:eq(3)").offset().top
							}, 	1000);
							$("div.content").removeClass("unclickable");
						}, 1000);
					}, 500);
					
					checkpoint = 6;
				}
				else
				{
					TD.css("background-color", "red");
				}
			}
			else if(checkpoint == 6)
			{
				var stanje = TableToArrayTutorial(6);
				var test = stanjeIgrePoPremiku(stanje, TDfrom, TD, 6);
				if(test == "true")//idDiva == 6 && TD.index() == 2 && TDfrom.index() == 2 && rowIndex == 3)
				{
					TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
					TDfrom.html("<div class='content'></div>");
					$("div.content").addClass("unclickable");
					$("div.content").removeClass("selected");
					
					setTimeout(function(){ 
						$(".container#6 b:eq(1)").html("<span class='glyphicon glyphicon-ok'></span>");
						$(".container#6 p:last").append("<p><p><b>Čestitam!</b> Osvojili ste remi!</p></p>");
					}, 1500);
					
					$("div.content").removeClass("unclickable");
					checkpoint = 0;
				}
				else
				{
					TD.css("background-color", "red");
				}
			}
		}
	}
	});
	
	//Za reset button
	$(".reset").on("click", function(){
		if($(this).closest(".container").attr("id") == 0)
		{
			Izris(0, 0);
			checkpoint = 0;
			$(".container#0 p:eq(3), .container#0 p:eq(3), .container#0 p:eq(4), .container#0 p:eq(5), .container#0 p:eq(2)").remove();
			$(".container#0 p:eq(1)").html("Premik figure je enostaven. Prvo se izbere figura (seveda mora biti vaša in ne nasprotnikova). Če se ozadje figure pobarva zeleno, to pomeni, da je figura izbrana. Ko je figura izbrana, se enostavno premakne kam želite (seveda mora biti poteza veljavna).<p></p><p><b> Navodilo:</b> Premaknite četrtega kmeta od leve za dve mesti naprej!</p>");
		}
		else if($(this).closest(".container").attr("id") == 2)
		{
			Izris(2, 2);
			checkpoint = 0;
			/*$(".container#2 p:eq(2)").remove();*/
			$(".container#2 p:eq(2)").html("<b>Navodilo:</b> Pojejte nasprotniku figuro, ki leži diagonalno od vaše!");
		}
		else if($(this).closest(".container").attr("id") == 3)
		{
			Izris(3, 3);
			checkpoint = 0;
			$(".container#3 p:eq(2)").html("<p><b>Navodilo:</b> Pojejte nasprotnikovo figuro in zmagajte!</p>");
		}
		else
		{
			Izris(6, 6);
			checkpoint = 0;
			$(".container#6 p:eq(2)").html("<p><b>Navodilo:</b> Naredite remi, tako da kmeta premaknete za eno naprej!</p>");
		}
		
		$("div").removeClass("unclickable");
	});
});
