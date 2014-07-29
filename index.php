<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Community Eligibility Data</title>
<script src="jquery-1.10.2.min.js"></script>
<script src="jquery.tablesorter.min.js"></script>
</head>

<body>

<?php

function stateSelector($id) {
	$statesArr = array("Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");
	echo "<select id=\"".$id."\">";
	for ($i = 0;$i<count($statesArr);$i++) {
		echo "<option value=\"".$statesArr[$i]."\">".$statesArr[$i]."</option>";
	}
	echo "</select>";
};

stateSelector("stateSelector");

?>

<div id="districtSelectWrapper"></div>

<script type="text/javascript">

$("#stateSelector").change(function() {
	var state = this.value.replace(" ","_");
	var htmlString="<select id=\"districtSelector\">";
	var districts = $.get("districts.php?state=" + state,function(d) {
		for (var i = 0;i<d.length;i++) {
			htmlString += "<option value=\"" + d[i]["district_id"] + "\">" + d[i]["school_district"] + "</option>";
		}
		htmlString += "</select>";
		$("#districtSelectWrapper").html(htmlString);
	});
});

</script>

</body>

</html>