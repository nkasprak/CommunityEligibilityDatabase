<?php

/*AJAX data return for main table data
by Nick Kasprak
CBPP*/

	include("config.php");
	include("getData.php");
	$state = str_replace("_"," ",$_GET["state"]);
	$district = $_GET["dist"];
	$isp = explode("x",$_GET["isp"]);
	$district = explode("x",$_GET["dist"]);
	$districtList = returnCEPData($state,$district,$isp);
	header('Content-type: application/json');
	echo json_encode($districtList);
?>