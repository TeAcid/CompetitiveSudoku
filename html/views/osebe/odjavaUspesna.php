<?php 
$gregor1 = 'Gregor Ivajnšič';
$gregor2  = 'Gregor Ivanič';
$gregor3 = 'Gregor Kramar';
require_once('views/strani/domov.php'); 
?>

<script>
$(document).ready(function(){
	//$("nav.navbar-inverse").load("../views/PrijavaOdjava.php");
	if(document.URL.indexOf("#")==-1){
        // Set the URL to whatever it was plus "#".
        url = document.URL+"#";
        location = "#";

        //Reload the page
        location.reload(true);
    }
	//$("#chatDiv").load(location.href + " #chatDiv");
});
</script>