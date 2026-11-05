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
	$statesArr = array("Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District of Columbia", "Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");
	echo "<select id=\"".$id."\">";
	for ($i = 0;$i<count($statesArr);$i++) {
		echo "<option value=\"".$statesArr[$i]."\">".$statesArr[$i]."</option>";
	}
	echo "</select>";
};
stateSelector("stateSelector");?>
</td></tr><tr><td><strong>District: </strong></td><td width="400">
<select multiple id="districtSelector"></select></td></tr><tr><td><strong>Eligibility: </strong></td><td>
<select multiple id="percentSelector">
	<option selected value="all">All</option>
	<option value="0">0-30%</option>
    <option value="30">30-39%</option>
    <option value="40">40-49%</option>
    <option value="50">50-59%</option>
    <option value="60">60-100%</option>
    <option value="unknown">Unknown</option>
</select></td></tr><tr><td><strong>Show:</strong></td>
	<td><input type="radio" name="participation" value="Y">Schools Participating<br />
		<input type="radio" name="participation" value="N">Schools Not Participating<br />
        <input type="radio" name="participation" value="B" checked>Both</tr></table>
<p align="center">Ctrl- or shift-click to select multiple items</p>
</div>

<div id="ajaxLoaderDisplay" align="center"><img src="ajax-loader.gif" alt="" /> <span id="statusText"></span>
(<span id="progressRowIndex"></span>/<span id="progressRowTotal"></span>)
<button id="stopButton">Stop Loading</button></div>
</div>
<p>&nbsp;</p>
<div id="legendWrapper">
<p>The schools are color-coded by ISP according to the  following legend:</p>
<table align="center">
  <tbody><tr class="dark0">
<td>
<span>ISP Below 30%, or ISP figure unreported</span></td></tr><tr class="dark1">
<td>ISP 30%-40%</td></tr><tr class="dark2"><td>
ISP 40%-50%</td></tr><tr class="dark3"><td>
ISP 50%-60%</td></tr><tr class="dark4"><td>
ISP 60% and higher</td>
</tr>
</tbody></table>
</div>
<p>&nbsp;</p>
<div id="tableWrapper">
<div class="blueHeader">
<strong>Eligibility for Community Eligibility Provision</strong>
</div>
<div class="grayHeader" align="center">
<strong>Showing <span id="numSchools"></span></strong>
</div>
<table align="center" id="dataTable" class="tablesorter" cellspacing="0">
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
			echo "<th data-colid=\"" . $id . "\"" . ($width = -1 ? " width=\"" . $width . "\"" : "") . "><div class='tableHeader'><div class='text'>".$columnNames[$id]."</div></div></th>";	
		}
		?>
        <?php 
			colHead("state",-1);
			colHead("school_district",152);
			colHead("school",142);
			colHead("isp",90);
			colHead("participation",90);
			colHead("enrollment",-1);
		?>
        </tr>
    </thead>
	<tbody>
    
    </tbody>
    <tfoot>
    	<td colspan="6">
</td>
    </tfoot>
</table>
</div>



<div style="margin:5px"><h3><strong>Technical notes</strong></h3>
		<h4>General Notes</h4>
<p>The Identified Student Percentage (ISP) column in this database shows the ISP data collected directly by CBPP from state agencies.  When these data were not provided, the database shows the ISP data published by state agencies in May 2014. </p>

<p>Unless otherwise noted, ISPs for participating schools are data provided by state child nutrition agencies between September 2014 and January 2015, while ISP data for non-participating schools are from the May 2014 published list. USDA permitted states to base their published lists on proxy data readily available to them. Proxy data are merely an indicator of potential eligibility, not the basis for eligibility. Districts must submit more accurate information, which may be more complete and/or more recent, when applying to adopt community eligibility. ISP ranges are shown where provided by the state in lieu of an exact percentage. </p>
<p>If a district groups schools or participates district-wide, the district adds all of the Identified Students across the participating schools and divides this total by the enrollment of all schools in the group or district.  Group ISPs are shown in instances where the individual school-level ISP is unavailable or the state agency requested the publication of group-level data.  Schools that are participating in CEP, but have ISPs below 40 percent are participating as part of a group.  </p>
<p>When states did not provide school-level enrollment data, none are included in this database. As a result, the student enrollment data in this table may not add up to the state-level CEP enrollment totals included in <a href="http://www.cbpp.org/cms/index.cfm?fa=view&id=5273" target="_blank">this paper</a>.</p>
<h4>State Notes</h4>
<p>Georgia, Maine, New Jersey, South Dakota, Vermont and Washington provided district or group-level ISP data for some schools and school-level ISP data for others (but not both for any one school).  Georgia provided group-level ISP data for schools participating in CEP, but did not provide group ISPs for groups with ISPs above 62.5 percent.  Maine did not publish a list of eligible schools, but provided a combination of group and school-level data for participating schools.  South Dakota provided group-level ISP data for participating schools, but no ISP data for non-participating schools; therefore the ISPs for eligible non-participating schools could not be determined.  Colorado only provided group or district level ISP data.  In the database, the group-level ISP is presented as the ISP for the schools that belong to the group or district where individual ISP data was not available.</p>
<p>Illinois, Maine, Ohio, Oklahoma and South Dakota did not publish or provide sufficient ISP data to determine CEP take-up percentages for schools adopting CEP.  Illinois provided a list of participating schools but no school-level data and the ISP ranges provided by the state were insufficient to identify the highest poverty schools.  As a result, the list of highest poverty eligible schools for this state could not be determined.  Ohio neither published ISP data in May 2014 nor provided ISP data for participating schools; therefore the full list of eligible schools could not be determined.  </p>
<p>Indiana did not provide ISP data on 100 schools that are not participating in CEP, so we do not know whether they are eligible.  Those schools are not included in this database.</p>
<p>For Iowa, ISP data for both participating and non-participating schools is based on data published in May 2014.  </p>
<p>The number of eligible schools with ISPs of 60 percent or higher for Louisiana may be undercounted, as there are 17 CEP-eligible schools for which ISP data were not provided.</p>
<p>In New York, in some instances, multiple groups of students that are co-located in a single building are counted as separate CEP sites because they participate in separate educational programs.  Schools with names that start with &quot;Lyfe&quot; are childcare centers for the children of students in sites that participate in CEP.</p>
<p>Oklahoma and Wisconsin provided ISP ranges instead of exact percentages.  Oklahoma provided ISP ranges for participating schools, rather than individual-school level ISP data, but no ISP data for non-participating schools; therefore the ISPs for eligible non-participating schools could not be determined. These ISP ranges are shown in the database in place of individual school-level data.  Wisconsin provided ranges for non-participating schools and individual ISPs for participating schools.  </p>
<p>For eight schools in Indiana, Nebraska, New Mexico and Oregon the state child nutrition agencies provided ISPs greater than 100 percent.  Under community eligibility, no more than 100 percent of the meals served are reimbursed at the free rate.</p>
<p>For 37 schools participating in CEP in California, Indiana, Kentucky, Michigan, Mississippi, New Jersey, Pennsylvania, Tennessee, and Texas enrollment was reported as zero.</p>
    	</div>

</div>
<script type="text/javascript" src="cedatabase.js">
</script>

</body>

</html>