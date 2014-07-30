<?php
	include("config.php");
	include("getData.php");
	$state = str_replace("_"," ",$_GET["state"]);
	$district = $_GET["dist"];
	$districtList = returnCEPData($state,$district);
	header('Content-type: application/json');
	echo json_encode($districtList);
?>