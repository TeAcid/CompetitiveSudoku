<!DOCTYPE html>
<html style="width: 100%; height: 100%;">
   <head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="jQuery/script.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/igra_css.css">
		<link rel="icon" href="Slike/logo.jpg">
		<script src="jQuery/validation/dist/jquery.validate.js"></script>
		<title>Competitive SUDOKU</title>
		<!-- NOVICE -->
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script src="http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.js" type="text/javascript"></script>
		<style type="text/css">
		<!--@import url("http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.css");-->

		#ang, #slo {
		margin-top : 10px;
		margin-left: auto;
		margin-right: auto;
		width : 100%;
		font-size: 12px;
		color: #9CADD0;
		}

		.gfg-entry{
			height: 9em;
		}
		</style>
		<script type="text/javascript">		
	    function load() {
			var feedAng ="http://www.chessdom.com/feed/";
			var feedSlo ="http://www.sah-zveza.si/feed/";
			new GFdynamicFeedControl(feedAng, "ang");
			new GFdynamicFeedControl(feedSlo, "slo");
		}
		google.load("feeds", "1");
		google.setOnLoadCallback(load);
		</script>
		<!-- NOVICE -->
   </head>
   <body style="width: 100%; height: 100%;">
	<div id="carouselContainer">
		<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carousel" data-slide-to="0" class="active"></li>
				<li data-target="#carousel" data-slide-to="1"></li>
				<li data-target="#carousel" data-slide-to="2"></li>
			</ol>
			<!-- Carousel items -->
			<div class="carousel-inner">
				<div class="active item">Three people ...</div>
				<div class="item">... one goal ...</div>
				<div class="item">competitive SUDOKU!</div>
			</div>
			<!-- Carousel nav -->
			<a class="carousel-control left" href="#carousel" data-slide="prev"></a>
			<a class="carousel-control right" href="#carousel" data-slide="next"></a>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
	<?php include("PrijavaOdjava.php"); ?>
	</nav>
	<div class="container-fluid text-center" style="width: 100%; height: 100%;">
	 <div class="row content" style="width: 100$; height: 100%;">
		<div class="col-sm-8 text-left" id="igra" style="width: 100%; height: 100%;"> 
		   <?php require_once('routes.php'); ?> 
		</div>
	 </div>
	</div>
	<footer class="container-fluid text-center">
	 <p>Projekt - igra competitive SUDOKU</p>
	</footer>
   </body>
</html>