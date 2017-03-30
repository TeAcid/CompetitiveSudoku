<form action="index.php?controller=osebe&action=prijava" method="POST">
	<center><h3><b>Prijava</b></h3></center>
	<div class="form-group">
		<input type="text" class="form-control" name="upime" placeholder="Uporabniško ime" required />
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="geslo" placeholder="Geslo" required />
	</div>
	<div class="form-group pull-right myCheckBox">
		<label>
		  <input type="checkbox" data-ng-model="rememberMe"/> Ostani prijavljen/a?
		</label> 
    </div>
	<button type="submit" class="btn btn-primary col-md-6" name="Prijava">Prijava</button>
</form>