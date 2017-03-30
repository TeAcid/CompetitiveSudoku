<script>
//Za premikanje figur==============================================================
$(document).ready(function(){
	$(".tutorialTable table").on("click", "div.content", function(){
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
			TD.html("<div class='content bela unclickable'><img src='../../slike/white.png' alt='white' height='100%'/></div>");
			TDfrom.html("<div class='content'></div>");
			$("div.content").addClass("unclickable");
			$("div.content").removeClass("selected");						
		}	
	   }
	});
	
	//Funkcija za resetiranje polja
	ResetPolje(id)
	{
	
	}
});
</script>
<center>
	<p><h1>The PAWN'S GAME tutorial for peasants</h1></p>
	<img src="slike/startPosition.png" alt="error.jpg" height="400"/><br/>
	Slika 1: Začetna postavitev kmetov pri igri PAWN'S GAME
</center>
<br/>
<p>
	The PAWN'S GAME je igra podobna šahu, kjer vsak igralec igra s samimi kmeti. Isto kot pri šahu je prvi na potezi beli igralec. Cilj igre je priti do nasprotne strani plošče. Zmaga
	tisti igralec kateremu to prvo uspe. Drugi način kako priti do zmage je pojesti vse nasprotnikove figure (kar je redki pojav). Igra se tudi konča v primeru, ko nobeden igralec ne mora
	več premakniti nobene figure. V tem primeru je izid igre neodločeno. 
</p>
<p>
	Isto kot pri šahu lahko igralec samo premika kmete za eno mesto naprej. Pri tem pravilu obstajata dve izhemi: 
	<ol>
		<li>Igralec lahko poje nasprotnikovo figuro in se tako premakne diagonalno. Igralec ne mora jesti figure, ki stojijo pred njegovimi figurami.</li>
		<li>Pri prvi potezi vsakega kmeta lahko igralec pomakne figure za dve mesti naprej.</li>
	</ol>
</p>
<center>
	<h2>Igranje igre na naši spletni strani</h2>
</center>
<p>
	Premik figure je enostaven. Prvo se izbere figura (seveda mora biti vaša in ne nasprotnikova). Če se ozadje figure pobarva zeleno, to pomeni, da je figura izbrana.
	Ko je figura izbrana, se enostavno premakne kam želite (seveda mora biti poteza veljavna). 
</p>
<div class='col-sm-9 tutorialTable' id="0" style='margin-bottom: 5px; padding: 0;'>
<script>
	$.ajax({
	  method: "POST",
	  url: "funkcije.php",
	  data: {'učenje': 0},
	  success: function(data){
		alert(data);
		$("#1").html(data);
	  },
	 });
</script>
</div>
<div class='alert alert-block alert-success' style='text-align: center; width: 31.5%; float: right; position: absolute; left: 68%;'>
  <strong>Checkpoint 1:</strong> Premikanje figur!!
</div>
<div class="container" id="0" style="width: 31.5%; position: absolute; left: 68%; margin-top: 5%;">
	<button class="btn btn-success reset" style="width: 49%;">Reset</button>
	<button class="btn btn-primary" style="width: 49%;">Next</button>
</div>
