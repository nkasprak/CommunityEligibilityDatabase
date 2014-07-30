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
stateSelector("stateSelector");?>

<div id="districtSelectWrapper"></div>

<select id="percentSelector">
	<option value="0">0-19%</option>
    <option value="20">20-39%</option>
    <option value="40">40-59%</option>
    <option value="60">60-79%</option>
    <option value="80">80-100%</option>
</select>

<button id="retrieve">
Retrieve Data
</button>

<table id="dataTable">
	<thead>
    	<tr>
        <?php
		include("config.php");
		include("getData.php");
		$columnNames = returnColumnNames();
		function colHead($id) {
			global $columnNames;
			echo "<th data-colid=\"" . $id . "\">".$columnNames[$id]."</th>";	
		}
		?>
        <?php 
			colHead("state");
			colHead("school_district");
			colHead("school");
			colHead("isp");
			colHead("eligibility");
			colHead("enrollment");
		?>
        </tr>
    </thead>
	<tbody>
    
    </tbody>
    <tfoot>
    </tfoot>
</table>

<script type="text/javascript">
$(document).ready(function() {
	
	var cepDatabase = function() {
		return {
			getDistrictName: function(districtID) {
				var districtSelectorOptions = $("#districtSelector option");
				for (var i = 0;i<districtSelectorOptions.length;i++) {
					if ($(districtSelectorOptions[i]).val() == districtID) {
						return $(districtSelectorOptions[i]).html()
					}
				}
				return "Unknown";
			}
		}
	}();
	
	$("#stateSelector").change(function() {
		var state = $(this).val().replace(" ","_");
		var htmlString="<select id=\"districtSelector\">";
		var districts = $.get("districts.php?state=" + state,function(d) {
			for (var i = 0;i<d.length;i++) {
				htmlString += "<option value=\"" + d[i]["district_id"] + "\">" + d[i]["school_district"] + "</option>";
			}
			htmlString += "</select>";
			$("#districtSelectWrapper").html(htmlString);
		});
	});
	
	$("#retrieve").click(function() {
		var state = $("#stateSelector").val().replace(" ","_");
		var district = $("#districtSelector").val();
		var dataRequest = $.get("data.php?state=" + state + "&dist=" + district, function(d) {
			var tableString = "";
			var entries = [];
			for (var entry in d) {
				entries.push(d[entry]);	
			}
			entries.sort(function(a,b) {
				return a["id"]*1 - b["id"]*1;
			});
			
			for (var i = 0;i<entries.length;i++) {
				console.log(entries[i]);
				tableString += "<tr data-districtid=\"" + entries[i]["id"] + "\">";
				tableString += "<td data-colid=\"state\">" + entries[i]["state"] + "</td>";
				tableString += "<td data-colid=\"school_district\">" + cepDatabase.getDistrictName(entries[i]["district_id"]) + "</td>";
				tableString += "<td data-colid=\"school\">" + entries[i]["school"] + "</td>";
				tableString += "<td data-colid=\"isp\">" + entries[i]["isp"] +"</td>";
				tableString += "<td data-colid=\"eligibility\">" + entries[i]["eligibility"] +"</td>";;
				tableString += "<td data-colid=\"enrollment\">" + entries[i]["enrollment"] + "</td>";
				tableString += "</tr>";
			}
			$("#dataTable tbody").html(tableString);
		});
	});
});

</script>

</body>

</html>