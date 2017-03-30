<h1>Odjava</h1>
<form action="?controller=osebe&action=odjavi&id=<?php echo $_SESSION["id"];?>" method="post">
<div class="form-group">
<label for="upime">Se želite odjaviti?</label>
<input class="btn btn-primary" type="submit" name="Da" value="Da"/>
</div>
</form>