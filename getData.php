<?php

function returnCEPData($state,$district) {
	
	$mysqli = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
	$mysqli->set_charset("utf8");
	
	$dataQuery = "SELECT * FROM cepdata WHERE `state` = \"" . $state ."\" AND `district_id` = " . $district;
	
	
	$dataResult = $mysqli->query($dataQuery);
	$returnObj = array();
	while ($row = $dataResult->fetch_array(MYSQLI_ASSOC)) {
		$returnObj[$row["id"]] = $row;
	}

	
	$mysqli->close();
	
		
	return $returnObj;
};

function returnDistrictList($state) {
	
	$mysqli = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
	$mysqli->set_charset("utf8");
	
	$districtQuery = "SELECT * FROM districts WHERE `state` = \"" . $state . "\"";
	
	$districtResult = $mysqli->query($districtQuery);
	$returnObj = array();
	while ($row = $districtResult->fetch_array(MYSQLI_ASSOC)) {
		$returnObj[$row["district_id"]] = $row;
	}
	

	
	$mysqli->close();
	
		return $returnObj;
	
};

function returnColumnNames() {
	
	$mysqli = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
	$mysqli->set_charset("utf8");
	
	$columnQuery = "SELECT * FROM columns";
	
	
	$$columnResult = $mysqli->query($columnQuery);
	$returnObj = array();
	while ($row = $columnResult->fetch_array(MYSQLI_ASSOC)) {
		$returnObj[$row["district_id"]] = $row;
	}
	
	
	
	$mysqli->close();
	
	return $returnObj;
	
}

?>