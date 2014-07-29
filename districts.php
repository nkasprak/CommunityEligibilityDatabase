<?php
	include("config.php");
	include("getData.php");
	$state = str_replace("_"," ",$_GET["state"]);
	$districtList = returnDistrictList($state);
	header('Content-type: application/json');
	echo json_encode($districtList);
?>