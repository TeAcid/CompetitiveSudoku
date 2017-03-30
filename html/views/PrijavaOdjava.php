<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container-fluid">
   <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-home"></span></a>
		 <?php
		 if(isset($_SESSION["id"]))
		 {
		 ?>	
			<ul class="nav navbar-nav">
				<li <?php if(isset($_GET['action'])){if($_GET['action']=='zacetna'){echo "class='active'";}} ?>><a href="?controller=igra&action=zacetna">Igraj <span class="glyphicon glyphicon-pawn"></span></a></li>
				<li <?php if(isset($_GET['action'])){if($_GET['action'] == 'igrajSudoku'){echo "class='active'";}} ?>><a href="?controller=igra&action=igrajSudoku"><span class="glyphicon glyphicon-leaf"></span> Igraj sudoku</a></li>
				<li <?php if(isset($_GET['action'])){if($_GET['action']=='prijatelji'){echo "class='active'";}} ?>><a href="?controller=osebe&action=prijatelji">Prijatelji <span class="glyphicon glyphicon-user"></span></a></li>
				<li <?php if(isset($_GET['action'])){if($_GET['action']=='glej'){echo "class='active'";}} ?>><a href="?controller=igra&action=glej">Glej druge <span class="glyphicon glyphicon-eye-open"></span></a></li>
				<li <?php if(isset($_GET['action'])){if($_GET['action']=='ucenje'){echo "class='active'";}} ?>><a href="?controller=igra&action=ucenje">Učenje <span class="glyphicon glyphicon-education"></span></a></li>
				<li <?php if(isset($_GET['action'])){if($_GET['action']=='obvestila'){echo "class='active'";}} ?>><a href="?controller=osebe&action=obvestila">Obvestila <span class="glyphicon glyphicon-time"></span></a></li>
			</ul>
		 <?php
		 }
		 ?>
   <ul class="nav navbar-nav navbar-right">
		 <?php
		 if(isset($_SESSION['id']))
		 {
			?>
			<li <?php if(isset($_GET['action'])){if($_GET['action']=='profil'){echo "class='active'";}} ?>><a href="?controller=osebe&action=profil&id=<?php echo $_SESSION['id']; ?>">Moj profil <span class="glyphicon glyphicon-tag"></span></a></li>
			<li><a href="?controller=osebe&action=odjavi&id=<?php echo $_SESSION['id'];?>">Odjava <span class="glyphicon glyphicon-log-out"></span></a></li>
			<?php
		 }
		 else
		 {
			?>
			<li <?php if(isset($_GET['action'])){if($_GET['action'] == 'dodaj'){echo "class='active'";}} ?>><a href="?controller=osebe&action=dodaj"><span class="glyphicon glyphicon-user"></span> Registracija</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Prijava <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php require_once("osebe/prijava.php"); ?>
				</ul>
			</li>
			<?php
		 }
		 ?>
   </ul>
</div>