<?php

/*Data retrieval functions for community eligibility database
by Nick Kasprak
CBPP*/

function returnCEPData($state,$district,$isp) {
	$mysqli = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
	$mysqli->set_charset("utf8");
	$state = mysqli_real_escape_string($mysqli,$state);
	$dataQuery = "SELECT * FROM cepdata_data WHERE `state` = \"" . $state . "\"";
	if (!in_array("all",$district)) {
		$dataQuery .=  " AND (";
		for ($i=0;$i<count($district);$i++) {
			$district[$i] = mysqli_real_escape_string($mysqli,$district[$i]);
			$dataQuery .= "`district_id` = " . $district[$i];
			if ($i<count($district)-1) $dataQuery .= " OR ";
		}
		$dataQuery .= ")";
	}
	if (!in_array("all",$isp)) {
		$dataQuery .= " AND (";
		for ($i=0;$i<count($isp);$i++) {
			$ispEntry = $isp[$i];
			switch ($ispEntry) {
			case "unknown":
			$app = "(`isp` = -1)";
			break;
			case 0:
			$app = "(0 <= `isp` AND `isp` < .3)";
			break;
			case 30:
			$app = "(0.3 <= `isp` AND `isp` < .4)";
			break;
			case 40:
			$app = "(0.4 <= `isp` AND `isp` < .5)";
			break;
			case 50:
			$app = "(0.5 <= `isp` AND `isp` < .6)";
			break;
			case 60:
			$app = "(0.6 <= `isp`)";
			break;
			}
			if ($i < count($isp) - 1) $app .= " OR ";
			$dataQuery .= $app;
		}
		$dataQuery .= ")";
	}
	$dataResult = $mysqli->query($dataQuery);
	$returnObj = array();
	while ($row = $dataResult->fetch_array(MYSQLI_ASSOC)) {
		array_push($returnObj,$row);
	}
	$mysqli->close();	
	return $returnObj;
};

function returnDistrictList($state) {
	$mysqli = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
	$mysqli->set_charset("utf8");
	$state = mysqli_real_escape_string($mysqli,$state);
	$districtQuery = "SELECT * FROM cepdata_districts WHERE `state` = \"" . $state ."\"";
	$districtResult = $mysqli->query($districtQuery);
	$returnObj = array();
	while ($row = $districtResult->fetch_array(MYSQLI_ASSOC)) {
		foreach ($row as $key=>$item) {
			$row[$key] = trim($row[$key]);	
		}
		array_push($returnObj,$row);
	}
	usort($returnObj,function($a,$b){
		return strcmp($a["school_district"], $b["school_district"]);
	});
	$mysqli->close();
	return $returnObj;
};

function returnColumnNames() {
	$mysqli = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
	$mysqli->set_charset("utf8");
	$columnQuery = "SELECT * FROM cepdata_columns";
	$columnResult = $mysqli->query($columnQuery);
	$returnObj = array();
	while ($row = $columnResult->fetch_array(MYSQLI_ASSOC)) {
		$returnObj[$row["id"]] = $row["name"];
	}
	$mysqli->close();
	return $returnObj;
}

?>