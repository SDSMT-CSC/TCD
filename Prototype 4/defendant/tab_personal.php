
	<script>
	var address;
	jQuery(function($) {
		
		$("#defendant-personal-submit").button().click(function() { $("#defendant-personal").submit(); });
	  	  
		$("#school-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:600,
				buttons: {
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
			
		$("#location-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:500,
				buttons: {
					Cancel: function() {
						$(this).dialog('close');
					}
				}	
			});
		
		$('#select-school-location').click(function(){
				$('#school-dialog').dialog('open');
				$('.ui-dialog :button').blur();
		});
		
		$('#select-physical-location').click(function(){
				address = "physical";
				$('#location-dialog').dialog('open');
				$('.ui-dialog :button').blur();
		});
		
		$('#select-mailing-location').click(function(){
				address = "mailing";
				$('#location-dialog').dialog('open');
				$('.ui-dialog :button').blur();
		});
		
		function processSchool()
		{
			// get values from form
			var schoolname = $("input#schoolname").val();
					
			$.post( $("#school-form").attr("action"), $("#school-form").serialize(), function(response) {
				
				// fill in the dropdown
				$("#schoolID").append($('<option selected="selected"></option>').val(response).html(schoolname));
    	});
			  
			return false;
		}
		
		var locTable = $("#location-table").dataTable( { 
					"aaSorting": [],
					"sPaginationType": "full_numbers",
					"bProcessing": false,
					"sAjaxSource": '/data/program_locations.php'
		});
		
		var schoolTable = $("#school-table").dataTable( { 
					"aaSorting": [],
					"aoColumns": [null,{"bVisible":false},null,null,null],
					"sPaginationType": "full_numbers",
					"bProcessing": false,
					"sAjaxSource": '/data/program_schools.php'
		});
		
		$('#location-table tbody tr').live('click', function (event) {        
    	var aData = locTable.fnGetData(this); // get datarow
			if (aData != null)  // null if we clicked on title row
			{
				// set input values
				if(address == "physical")
				{
					$("#physical-city").val(aData[0]);
					$("#physical-state").val(aData[1]);
					$("#physical-zip").val(aData[2]);
				}
				else
				{
					$("#mailing-city").val(aData[0]);
					$("#mailing-state").val(aData[1]);
					$("#mailing-zip").val(aData[2]);
				}
				
				// close the window
				$("#location-dialog").dialog('close');
			}
		});
				
		// $("input").prop('disabled', true); THIS IS FOR READ ONLY ACCESS - INPUT DISABLED FOR TYPE 5 users		
	});
		 
	</script>
 
	<div id="school-dialog" title="Add New School">
		<table id="school-table">
      <thead>
          <tr>
            <th>School</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
          </tr>
      </thead>
      <tbody></tbody>
  	</table> 
	</div>

	<div id="location-dialog" title="Select Location">
    <table id="location-table">
      <thead>
          <tr>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
          </tr>
      </thead>
      <tbody></tbody>
    </table> 
	</div>
  
  <form name="defendant-personal" id="defendant-personal" method="post" action="process.php">
  <input type="hidden" name="defendantID" value="<? echo $id ?>" />
  <input type="hidden" name="action" value="Update Personal" />
	<table>
		<tr>
			<td width="600" valign="top">
				<fieldset>
					<legend>Physical Address</legend>
					<table>
						<tr>
							<td>Street:</td>
							<td><input type="text" name="physical-street" size="40" value=""/></td>
						</tr>
            <tr>
              <td>City:</td>
              <td>
              	<input type="text" name="physical-city" id="physical-city" />
           			State: <input type="text" name="physical-state" id="physical-state" size="2" />
                Zip: <input type="text" name="physical-zip" id="physical-zip" size="7" />
                <a id="select-physical-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
              </td>
            </tr>
					</table>
				</fieldset>
				
				<fieldset>
					<legend>Mailing Address</legend>
					<table>
						<tr>
							<td></td>
							<td><input type="checkbox" />  Same as physical address</td>
						</tr>
						<tr>
							<td>Street:</td>
							<td><input type="text" name="mailing-street" size="40" value="" /></td>
						</tr>
            <tr>
            	<td>City:</td>
              <td>
              	<input type="text" name="mailing-city" id="mailing-city" />
           			State: <input type="text" name="mailing-state" id="mailing-state" size="2" />
                Zip: <input type="text" name="mailing-zip" id="mailing-zip" size="7" />
                <a id="select-mailing-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
              </td>
            </tr>
					</table>
				</fieldset>
				
				<fieldset>
					<legend>School Information</legend>
					<table>
						<tr>
							<td>School Name:</td>
							<td>
              	<input type="text" name="school-name" size="40" value="" />
              	Grade: <input type="text" name="grade" size="5" value="" />
              </td>
						</tr>
						<tr>
							<td>Street:</td>
							<td><input type="text" name="school-street" size="40" value="" /></td>
						</tr>
            <tr>
            	<td>City:</td>
              <td>
              	<input type="text" name="school-city" id="school-city" />
           			State: <input type="text" name="school-state" id="school-state" size="2" />
                Zip: <input type="text" name="school-zip" id="school-zip" size="7" />
                <a id="select-school-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
              </td>
            </tr>
            <tr>
							<td>School Contact:</td>
							<td>
              	<input type="text" name="grade" value="" />
                Phone: <input type="text" name="grade" value="" />
              </td>
						</tr>
					</table>
				</fieldset>
			</td>
			<td valign="top">
				<fieldset>
					<legend>Description</legend>
					<table>
						<tr>
							<td>Height:</td>
							<td><input type="text" name="height" size="10" value="" /></td>
						</tr>
						<tr>
							<td>Weight:</td>
							<td><input type="text" name="weight" size="10" value="" /></td>
						</tr>
						<tr>
							<td>Eye Color:</td>
							<td>
								<select name="eye" style="width: 100px;">
                  <option></option>
                  <option>Amber</option>
                  <option>Blue</option>
									<option>Brown</option>
                  <option>Gray</option>
                  <option>Green</option>
                  <option>Hazel</option>
                  <option>Violet</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Hair Color:</td>
							<td>
								<select name="hair" style="width: 100px;">
                  <option></option>
                  <option>Black</option>
									<option>Brown</option>
									<option>Blond</option>
                  <option>Auburn</option>
                  <option>Chestnut</option>
									<option>Red</option>
                  <option>Gray</option>
                  <option>White</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Ethnicity:</td>
							<td>
								<select name="ethnicity" style="width: 100px;">
								  <option></option>
									<option>Asian</option>
									<option>African-American</option>
									<option>Caucasian</option>
									<option>Hispanic</option>
									<option>Native American</option>
                  <option>Pacific Islander</option>
                  <option>Other</option>
								</select>
							</td>
						</tr>
					</table>
				</fieldset>
				
				<fieldset>
					<legend>Drivers License</legend>
					<table>
						<tr>
							<td>Number:</td>
							<td><input type="text" name="dl-number" size="10" value="" /></td>
						</tr>
						<tr>
							<td>State:</td>
							<td><input type="text" name="dl-state" size="2" value="" /></td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>
</form>

<button id="defendant-personal-submit">Update Personal Information</button>

