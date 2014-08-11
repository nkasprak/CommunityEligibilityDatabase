<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Community Eligibility Data</title>
<script src="//use.edgefonts.net/droid-sans.js"></script>
<script src="jquery-1.10.2.min.js"></script>
<script src="jquery.tablesorter.min.js"></script>
<link rel="stylesheet" type="text/css" href="cestyle.css" />
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
	$statesArr = array("Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");
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
    <option value="unknown">Unknown</option>
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
<div class="grayHeader" align="center">
<strong>Showing <span id="numSchools"></span></strong>
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
			colHead("state",-1);
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

<p>Illinois, Louisiana and South Dakota did not report ISP figures, but provided instead their own ISP categories.  Using this information, their schools are classified in this table as eligible and near-eligible, but most could not be categorized according to the ISP legend.</p>

<p>Ohio does not provide ISP figures, but classified their schools as eligible for CEP "district-wide."  Using this information, its schools have been classified as eligible in this table.</p>

<p>Eight schools in Georgia, 113 schools in Indiana, one school in South Carolina and 18 schools in Maryland do not provide enough information to determine their ISP and ISP categories.  They are uncategorized in this table. </p>

<p>16 schools in Indiana, Mississippi, Nebraska, New Mexico, North Dakota and Oregon report ISPs greater than 100%.</p>

<p>Eleven states (Georgia, Idaho, Indiana, Kentucky, Maryland, Michigan, Missouri, New York, Pennsylvania, South Carolina and West Virginia) provide total enrollment for individual schools. 133 schools in Georgia, Indiana and Maryland were reported as having zero enrollment.</p></div>
</td>
    </tfoot>
</table>
</div>
</div>
<script type="text/javascript" src="cedatabase.js">
</script>

</body>

</html>