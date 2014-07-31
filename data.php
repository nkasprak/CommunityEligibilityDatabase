<?php

/*AJAX data return for main table data
by Nick Kasprak
CBPP*/

	include("config.php");
	include("getData.php");
	$state = str_replace("_"," ",$_GET["state"]);
	$district = $_GET["dist"];
	$isp = explode(",",$_GET["isp"]);
	$districtList = returnCEPData($state,$district,$isp);
	header('Content-type: application/json');
	echo json_encode($districtList);
?>