<?php include "UI/validacija.php"; ?>
<center>
	<p><h1>The PAWN'S GAME tutorial</h1></p>
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
<center><div>
	<div class='col-sm-9 tutorialTable container' id="0" style='margin-bottom: 5px;'></div>
	<div class="container col-sm-3">
		<div class='alert alert-block alert-success' style='text-align: center;'>
		  <strong>Checkpoint 1:</strong> Premikanje figur!
		</div>
		<div class="container" id="0" style="margin-top: 5%; width: 100%;">
			<button class="btn btn-success reset" style="width: 48%;">Reset</button>
			<button class="btn btn-primary next" style="width: 48%;">Next</button>
			<p></p>
			<p>
				Premik figure je enostaven. Prvo se izbere figura (seveda mora biti vaša in ne nasprotnikova). Če se ozadje figure pobarva zeleno, to pomeni, da je figura izbrana.
				Ko je figura izbrana, se enostavno premakne kam želite (seveda mora biti poteza veljavna).
				<p><b>Navodilo:</b> Premaknite četrtega kmeta od leve za dve mesti naprej!</p>
			</p>
		</div>
	</div>
	<div class='col-sm-9 tutorialTable' id="2" style='margin-bottom: 5px;'></div>
	<div class="container col-sm-3">
		<div class='alert alert-block alert-success' style='text-align: center;'>
		  <strong>Checkpoint 2:</strong> Snedenje figur!
		</div>
		<div class="container" id="2" style="margin-top: 5%; width: 100%;">
			<button class="btn btn-success reset" style="width: 48%;">Reset</button>
			<button class="btn btn-primary next" style="width: 48%;">Next</button>
			<p></p>
			<p>Figure ni le možno premikati za dve oz. eno mesto naprej. Možno jih je tudi premikati diagonalno (levo ali desno) naprej. Ampak to je le dovoljeno, ko nasprotniku poješ 
			eno od njegovih figur. </p>
			<p><b>Navodilo:</b> Pojejte nasprotniku figuro, ki leži diagonalno od vaše!</p>
		</div>
	</div>
	<div class='col-sm-9 tutorialTable' id="3" style='margin-bottom: 5px;'></div>
	<div class="container col-sm-3">
		<div class='alert alert-block alert-success' style='text-align: center;'>
		  <strong>Checkpoint 3:</strong> Kako zmagati?
		</div>
		<div class="container" id="3" style="margin-top: 5%; width: 100%;">
			<button class="btn btn-success reset" style="width: 48%;">Reset</button>
			<button class="btn btn-primary next" style="width: 48%;">Next</button>
			<p></p>
			<p>Pri igri THE PAWN'S GAME obstajajo trije načini, kako priti do zmage. Prvi način je pojesti vse nasprotnikove figure, tako da ostanejo le še vaše na polju.</p>
			<p><b>Navodilo:</b> Pojejte nasprotnikovo figuro in zmagajte!</p>
		</div>
	</div>
	<div class='col-sm-9 tutorialTable' id="6" style='margin-bottom: 5px;'></div>
	<div class="container col-sm-3">
		<div class='alert alert-block alert-success' style='text-align: center;'>
		  <strong>Checkpoint 4:</strong> Kdaj je igra neodločena?
		</div>
		<div class="container" id="6" style="margin-top: 5%; width: 100%;">
			<button class="btn btn-success reset" style="width: 48%;">Reset</button>
			<button class="btn btn-primary next" style="width: 48%;">Next</button>
			<p></p>
			<p><b>Čestitam!</b> Prišli ste daleč. Zadnja stvar, ki bi vas naučil, je remi. Remi pomeni, da se igra konča neodločeno (noben igralec ne zmaga). Do tega lahko pride le, ki oba igralca med seboj blokirata vse figure.</p>
			<p><b>Navodilo:</b> Naredite remi, tako da kmeta premaknete za eno naprej!</p>
		</div>
	</div>
</div></center>