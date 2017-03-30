<center><h2>Registracija</h2></center>
<form action="?controller=osebe&action=shrani" method="POST" id="formRegistracija" class="col-md-6 col-md-offset-3" data-toggle="validator">
	<div class="input-group">
		<span class="input-group-addon">*</span>
		<input type="text" class="form-control input-lg" name="ime" placeholder="Ime"/>
	</div>
	<div class="input-group">
		<span class="input-group-addon">*</span>
		<input type="text" class="form-control input-lg" name="priimek" placeholder="Priimek"/>
	</div>
	<div class="input-group">
		<span class="input-group-addon">*</span>
		<input type="text" class="form-control input-lg" name="upime" placeholder="Uporabniško ime"/>
	</div>
	<div class="input-group">
		<span class="input-group-addon">*</span>
		<input type="password" class="form-control input-lg" name="geslo" id="geslo" placeholder="Geslo"/>
	</div>
	<div class="input-group">
		<span class="input-group-addon">*</span>
		<input type="password" class="form-control input-lg" name="geslo2" placeholder="Geslo še enkrat"/>
	</div>
	<div class="input-group">
		<span class="input-group-addon">*</span>
		<input class="form-control input-lg" name="enaslov" id="enaslov" placeholder="Elektronski naslov"/>
	</div>
	<button class="btn btn-primary btn-lg" type="submit" name="Dodaj">Registracija</button>
</form>
