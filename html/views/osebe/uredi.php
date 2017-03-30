<!-- obrazec za urejanje uporabnika -->
<h1>Urejanje profila</h1>
<form action="?controller=osebe&action=urejanje&id=<?php echo $oseba->id;?>" method="post">
<div class="form-group">
<label for="ime">Ime:</label>
<input type="text" class="form-control" name="ime" required value="<?php echo $oseba->ime; ?>"/>
<label for="priimek">Priimek:</label>
<input type="text" class="form-control" name="priimek" required value="<?php echo $oseba->priimek; ?>"/>
<label for="upime">Uporabniško ime:</label>
<input type="text" class="form-control" name="upime" required value="<?php echo $oseba->upime; ?>"/>
<label for="geslo">Geslo:</label>
<input type="password" class="form-control" name="geslo" required />
<label for="enaslov">Elektronski naslov:</label>
<input type="text" class="form-control" name="enaslov" required value="<?php echo $oseba->enaslov; ?>"/>
<input class="btn btn-primary" type="submit" name="Uredi" value="Uredi"/>
</div>
</form>