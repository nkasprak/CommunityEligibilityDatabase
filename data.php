<?php

/*AJAX data return for main table data
by Nick Kasprak
CBPP*/

	include("config.php");
	include("getData.php");
	
	$state = str_replace("_"," ",mysqli_real_escape_string($mysqli,$_GET["state"]));
	$district = mysqli_real_escape_string($mysqli,$_GET["dist"]);
	$isp = explode("x",mysqli_real_escape_string($mysqli,$_GET["isp"]));
	$district = explode("x",mysqli_real_escape_string($mysqli,$_GET["dist"]));
	$show = mysqli_real_escape_string($mysqli,$_GET["show"]);
	$districtList = returnCEPData($state,$district,$isp,$show);
	header('Content-type: application/json');
	echo json_encode($districtList);
?>