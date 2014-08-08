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
				var groupString = [];
				var multiplier = Math.floor(Math.log(cepDatabase.entryIndex+1))+1;
				for (var i = 0;i<10*multiplier;i++) {
					var rowString = [];
					var classString = "dark0";
					var isp = cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"];
					if (isp>=.3) classString = "dark1";
					if (isp>=.4) classString = "dark2";
					if (isp>=.5) classString = "dark3";
					if (isp>=.6) classString = "dark4";
					rowString.push("<tr class=\"" + classString + "\" data-districtid=\"" + cepDatabase.currentEntries[cepDatabase.entryIndex]["id"] + "\">");
					rowString.push("<td data-colid=\"state\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["state"] + "</td>");
					rowString.push("<td data-colid=\"school_district\">" + cepDatabase.getDistrictName(cepDatabase.currentEntries[cepDatabase.entryIndex]["district_id"]) + "</td>");
					rowString.push("<td data-colid=\"school\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["school"] + "</td>");
					if ((cepDatabase.currentEntries[cepDatabase.entryIndex]["override"])) {
						rowString.push("<td data-colid=\"isp\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["override"] + "</td>");
					} else if (isNaN(cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"])) {
						rowString.push("<td data-colid=\"isp\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"] + "</td>");
					} else if (cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"] == -1) {
						rowString.push("<td data-colid=\"isp\">Unknown</td>");
					} else {
						rowString.push("<td data-colid=\"isp\">" + Math.round(cepDatabase.currentEntries[cepDatabase.entryIndex]["isp"]*1000)/10 +"%</td>");
					}
					rowString.push("<td data-colid=\"eligibility\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["eligibility"] +"</td>");
					rowString.push("<td data-colid=\"enrollment\">" + cepDatabase.currentEntries[cepDatabase.entryIndex]["enrollment"] + "</td>");
					rowString.push("</tr>");
					groupString.push(rowString);
					cepDatabase.entryIndex++;
					$("span#progressRowIndex").html(cepDatabase.entryIndex);
					$("span#progressRowTotal").html(cepDatabase.currentEntries.length);
					if (cepDatabase.entryIndex == cepDatabase.currentEntries.length) break;
				}
				groupString = groupString.join("");
				$("#dataTable > tbody").append(groupString);
				if (cepDatabase.entryIndex < cepDatabase.currentEntries.length) {
					cepDatabase.backgroundDrawTimer = setTimeout(cepDatabase.drawRow,1)	
				} else {
					cepDatabase.allowUpdates();
				}
			},
			retrieveData: function() {
				$("span#progressRowIndex").html("0");
				$("span#progressRowTotal").html("?");
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
						var rowString = "<tr><td colspan='6' align='center'>No results found</td></tr>";
						$("#dataTable > tbody").append(rowString);	
						cepDatabase.allowUpdates();
					}
				});
			}
		}
	}();
	
	$("#stateSelector").change(function() {
		cepDatabase.preventUpdates();
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