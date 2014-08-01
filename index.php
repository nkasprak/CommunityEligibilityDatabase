<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Community Eligibility Data</title>
<script src="//use.edgefonts.net/droid-sans.js"></script>
<script src="jquery-1.10.2.min.js"></script>
<script src="jquery.tablesorter.min.js"></script>
<style>
body {
	margin:0px;
	padding:0px;
	font-family:droid-sans, Arial, Helvetica, sans-serif;
	font-size:13px;
	line-height:120%;
	height:100%;
}

#selectTableWrapper table{
	margin-left:auto;
	margin-right:auto;	
}

select{
	font-family:droid-sans, Arial, Helvetica, sans-serif;
	width:100%;
}

select#percentSelector{
	height:7.5em;	
	vertical-align:top;
}

select#districtSelector{
	height:16em;
	vertical-align:top;	
}

div#wrapper {
	padding-top:3em;
	margin-left:auto;
	margin-right:auto;
	width:650px;
	position:relative;	
}

div#selectArea {
	padding:5px;
	background-color:#FBF9F0;
	-webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.2);
	-moz-box-shadow:    5px 5px 20px rgba(0, 0, 0, 0.2);
	box-shadow:         5px 5px 20px rgba(0, 0, 0, 0.2);
	
}

div#tableWrapper {
	position:relative;
	left:0px;
	max-height:1000px;
	overflow-y:auto;
	overflow-x:hidden;
	-webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.2);
	-moz-box-shadow:    5px 5px 20px rgba(0, 0, 0, 0.2);
	box-shadow:         5px 5px 20px rgba(0, 0, 0, 0.2);	
}

div#ajaxLoaderDisplay {
	display:none;	
}

table {border-collapse:collapse;}

table tr.blueHeader td, table tr.blueHeader th, div.blueHeader{
	background-color:#003768;
	color:#fff;
	line-height:150%;
	font-size:18px;
	text-align:center;
}

table tr.grayHeader td, table tr.grayHeader th{
	background-color:#c0c0c0;
	cursor:pointer;
}

table th {
	vertical-align:bottom;
	text-align:center;
}


table td {
	vertical-align:top;
	text-align:left;	
}

tr.dark0 td, span.dark0 {
	background-color:#fff;	
}
tr.dark1 td, span.dark1 {
	background-color:rgb(221,235,247);
}
tr.dark2 td, span.dark2 {
	background-color:rgb(181,215,238);
}
tr.dark3 td, span.dark3 {
	background-color:rgb(155,194,230);
}
tr.dark4 td, span.dark4 {
	background-color:rgb(47,117,181);
	color:#fff;
}

table#dataTable {
	width:100%;	
	table-layout:fixed;
}

table#dataTable td {
	border:1px solid;
	border-color:#c0c0c0;
	border-color:rgba(0,0,0,0.1);
}

table#dataTable th {
	border:0px;	
}
		

</style>
</head>

<body>
<div id="wrapper">
<div id="selectArea">
<div id="selectTableWrapper"><table>
<tr>
<td>
<strong>State: </strong></td><td>
<?php
function stateSelector($id) {
	$statesArr = array("Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");
	echo "<select id=\"".$id."\">";
	for ($i = 0;$i<count($statesArr);$i++) {
		echo "<option value=\"".$statesArr[$i]."\">".$statesArr[$i]."</option>";
	}
	echo "</select>";
};
stateSelector("stateSelector");?>
</td></tr><tr><td><strong>District: </strong></td><td>
<select multiple id="districtSelector"></select></td></tr><tr><td><strong>Eligibility: </strong></td><td>
<select multiple id="percentSelector">
	<option selected value="all">All</option>
	<option value="0">0-30%</option>
    <option value="30">30-39%</option>
    <option value="40">40-49%</option>
    <option value="50">50-59%</option>
    <option value="60">60-100%</option>
</select></td></tr></table>
<p align="center">Ctrl- or shift-click to select multiple items</p>
</div>

<div id="ajaxLoaderDisplay"><img src="ajax-loader.gif" alt="" />
(<span id="progressRowIndex"></span>/<span id="progressRowTotal"></span>)
<button id="stopButton">Stop Loading</button></div>
</div>
<p>&nbsp;</p>
<div id="tableWrapper">
<div class="blueHeader">
<strong>Eligibility for Community Eligibility Provision</strong>
</div>
<table id="dataTable" class="tablesorter" cellspacing="0">
	<thead>
    	<!--<tr class='blueHeader'>
        	<th colspan="6" >Eligibility for Community Eligibility Provision</th>
        </tr>-->
    	<tr class='grayHeader'>
        <?php
		include("config.php");
		include("getData.php");
		$columnNames = returnColumnNames();
		function colHead($id,$width) {
			global $columnNames;
			echo "<th data-colid=\"" . $id . "\"" . ($width = -1 ? " width=\"" . $width . "\"" : "") . ">".$columnNames[$id]."</th>";	
		}
		?>
        <?php 
			colHead("state",60);
			colHead("school_district",162);
			colHead("school",162);
			colHead("isp",70);
			colHead("eligibility",90);
			colHead("enrollment",-1);
		?>
        </tr>
    </thead>
	<tbody>
    
    </tbody>
    <tfoot>
    	<td colspan="6"><div style="margin:5px"><p><strong>Technical notes</strong></p>

<p>* When actual Identified Student Percentages (ISPs) were not available for individual schools, some states reported proxy ISPs, and/or the percentage of directly certified students out of total enrollment.  The Identified Student Percentage column in this table shows, in order of availability, the actual ISP, the proxy ISP or the percentage of direct certified students.</p>


<p>** A school is classified as eligible when its ISP is 40 percent or higher, and as near-eligible when its ISP is between 30 percent and less than 40 percent.  A school with an ISP less than 30 percent is unclassified.</p>

<p>The schools are color-coded by ISP according to the following legend:</p>

<table>
<tr class="dark0">
<td>
<span >ISP Below 30%, or ISP figure unreported</span></td></tr><tr class="dark1">
<td>ISP 30%-40%</td></tr><tr class="dark2"><td>
ISP 40%-50%</td></tr><tr class="dark3"><td>
ISP 50%-60%</td></tr><tr class="dark4"><td>
ISP 60% and higher</td>
</tr>
</table>

<p>This list does not include schools in the state of New York because its list could not be transferred to this format.  New York's list of eligible districts and schools is available <a href="http://portal.nysed.gov/portal/page/pref/CNKC/IntDocs/CEP%20potential%20RA%2014-15.pdf">here</a>.</p>

<p>Illinois, Louisiana and South Dakota did not report ISP figures, but provided instead their own ISP categories.  Using this information, their schools are classified in this table as eligible and near-eligible, but most could not be categorized according to the ISP legend.</p>

<p>Ohio does not provide ISP figures, but classified their schools as eligible for CEP "district-wide."  Using this information, its schools have been classified as eligible in this table.</p>

<p>Eight schools in Georgia, 113 schools in Indiana, one school in South Carolina and 18 schools in Maryland do not provide enough information to determine their ISP and ISP categories.  They are uncategorized in this table. </p>

<p>16 schools in Indiana, Mississippi, Nebraska, New Mexico, North Dakota and Oregon report ISPs greater than 100%.</p>

<p>Ten states (Georgia, Idaho, Indiana, Kentucky, Maryland, Michigan, Missouri, Pennsylvania, South Carolina and West Virginia) provide total enrollment for individual schools.</p></div>
</td>
    </tfoot>
</table>
</div>
</div>
<script type="text/javascript">

/*Front-end scripts for community eligibility database
by Nick Kasprak
CBPP*/


$(document).ready(function() {
	try {
	var cepDatabase = function() {
		var isUpdating = false;
		return {
			preventUpdates: function() {
				isUpdating = true;
				$("div#ajaxLoaderDisplay").show();
				$("input, select").prop('disabled', true);
			},
			allowUpdates: function() {
				isUpdating = false;
				$("#dataTable").trigger("update");
				$("div#ajaxLoaderDisplay").hide();
				$("input, select").prop('disabled', false);
			},
			checkIfLocked: function() {
				return isUpdating;	
			},
			abortTableDraw: function() {
				clearTimeout(cepDatabase.backgroundDrawTimer);
				cepDatabase.allowUpdates();	
			},
			getDistrictName: function(districtID) {
				var districtSelectorOptions = $("#districtSelector option");
				for (var i = 0;i<districtSelectorOptions.length;i++) {
					if ($(districtSelectorOptions[i]).val() == districtID) {
						return $(districtSelectorOptions[i]).html()
					}
				}
				return "Unknown";
			},
			getDistrictList: function(state) {
				try {
				var htmlString="<option value=\"all\">All</option>";
				var districts = $.get("districts.php?state=" + state,function(d) {
					
					for (var i = 0;i<d.length;i++) {
						htmlString += "<option value=\"" + d[i]["district_id"]  + "\"" + (i==0 ? " selected":"") + ">" + d[i]["school_district"] + "</option>";
					}
					$("#districtSelector").html(htmlString);
					cepDatabase.retrieveData();
				});
				} catch (ex) {
					console.log(ex);	
				}
			},
			drawRow: function() {
				for (var i = 0;i<10;i++) {
					var rowString = "";
					var classString = "dark0";
					var isp = cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"];
					if (isp>=.3) classString = "dark1";
					if (isp>=.4) classString = "dark2";
					if (isp>=.5) classString = "dark3";
					if (isp>=.6) classString = "dark4";
					rowString += "<tr class=\"" + classString + "\" data-districtid=\"" + cepDatabase.currentEntries[cepDatabase.entryIndex]["id"] + "\">";
					rowString += "<td data-colid=\"state\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["state"] + "</td>";
					rowString += "<td data-colid=\"school_district\">" + cepDatabase.getDistrictName(cepDatabase.currentEntries[cepDatabase.entryIndex]["district_id"]) + "</td>";
					rowString += "<td data-colid=\"school\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["school"] + "</td>";
					if ((cepDatabase.currentEntries[cepDatabase.entryIndex]["override"])) {
						rowString += "<td data-colid=\"isp\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["override"] + "</td>";
					} else if (isNaN(cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"])) {
						rowString += "<td data-colid=\"isp\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"] + "</td>";
					} else {
						rowString += "<td data-colid=\"isp\">" + Math.round(cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"]*1000)/10 +"%</td>";
					}
					rowString += "<td data-colid=\"eligibility\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["eligibility"] +"</td>";;
					rowString += "<td data-colid=\"enrollment\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["enrollment"] + "</td>";
					rowString += "</tr>";
					$("#dataTable > tbody").append(rowString);
					cepDatabase.entryIndex++;
					$("span#progressRowIndex").html(cepDatabase.entryIndex);
					$("span#progressRowTotal").html(cepDatabase.currentEntries.length);
					if (cepDatabase.entryIndex == cepDatabase.currentEntries.length) break;
				}
				if (cepDatabase.entryIndex < cepDatabase.currentEntries.length) {
					cepDatabase.backgroundDrawTimer = setTimeout(cepDatabase.drawRow,1)	
				} else {
					cepDatabase.allowUpdates();
				}
			},
			retrieveData: function() {
				cepDatabase.preventUpdates();
				$("#dataTable > tbody").html("");
				var state = $("#stateSelector").val().replace(" ","_");
				var district = $("#districtSelector").val();
				var isp = $("#percentSelector").val();
				isp = isp.join("x");
				district = district.join("x");
				if (!district) district = 0;
				var url = "data.php?state=" + state + "&dist=" + district + "&isp=" + isp;
				var dataRequest = $.get(url, function(d) {
					cepDatabase.currentData = d;
					cepDatabase.currentEntries = [];
					cepDatabase.entryIndex = 0;
					for (var entry in cepDatabase.currentData) {
						cepDatabase.currentEntries.push(cepDatabase.currentData[entry]);	
					}
					cepDatabase.currentEntries.sort(function(a,b) {
						return a["id"]*1 - b["id"]*1;
					});
					if (cepDatabase.currentEntries.length > 0) {
						cepDatabase.drawRow();
					} else {
						var rowString = "<tr><td colspan='7' align='center'>No results found</td></tr>";
						$("#dataTable tbody").append(rowString);	
						cepDatabase.allowUpdates();
					}
				});
			}
		}
	}();
	
	$("#stateSelector").change(function() {
		var state = $(this).val().replace(" ","_");
		cepDatabase.getDistrictList(state);
	});
	
	$("#percentSelector, #districtSelector").change(function() {
		cepDatabase.retrieveData();
	});
	
	$("#dataTable").tablesorter();
	
	$("#stopButton").click(cepDatabase.abortTableDraw);
	
	cepDatabase.getDistrictList("Alabama");
	
	} catch (ex) {
		console.log(ex);	
	}
	
});

</script>

</body>

</html>