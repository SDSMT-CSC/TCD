
	<script>
	jQuery(function($) {
		
		var address;
		
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
		
		$("#sameaddress").click(function() {
				if($(this).is(':checked')) {
					$("#mailing-locationID").val($("#physical-locationID").val());
					$("#mailing-address").val($("#physical-address").val());
					$("#mailing-city").val($("#physical-city").val());
					$("#mailing-state").val($("#physical-state").val());
					$("#mailing-zip").val($("#physical-zip").val());
				}
		});
		
		$('#select-school-location').click(function(){
				$('#school-dialog').dialog('open');
				$('.ui-dialog :button').blur();
		});
		
		$('.select-location').click(function(){
				address = $(this).attr('id');
				$('#location-dialog').dialog('open');
				$('.ui-dialog :button').blur();
		});
				
		var locTable = $("#location-table").dataTable( { 
					"aaSorting": [],
					"aoColumns": [{"bVisible":false},null,null,null],
					"sPaginationType": "full_numbers",
					"bProcessing": false,
					"sAjaxSource": '/data/program_locations.php'
		});
		
		var schoolTable = $("#school-table").dataTable( { 
					"aaSorting": [],
					"aoColumns": [{"bVisible":false},null,{"bVisible":false},null,null,null],
					"sPaginationType": "full_numbers",
					"bProcessing": false,
					"sAjaxSource": '/data/program_schools.php'
		});
		
		$('#location-table tbody tr').live('click', function (event) {        
    	var oData = locTable.fnGetData(this); // get datarow
			if (oData != null)  // null if we clicked on title row
			{
				// set input values
				if( address == "physical-location" )
				{
					$("#physical-locationID").val(oData[0]);
					$("#physical-city").val(oData[1]);
					$("#physical-state").val(oData[2]);
					$("#physical-zip").val(oData[3]);
				}
				else if( address == "mailing-location" )
				{
					$("#mailing-locationID").val(oData[0]);
					$("#mailing-city").val(oData[1]);
					$("#mailing-state").val(oData[2]);
					$("#mailing-zip").val(oData[3]);
				}
				
				// close the window
				$("#location-dialog").dialog('close');
			}
		});
		
		$('#school-table tbody tr').live('click', function (event) {        
    	var oData = schoolTable.fnGetData(this); // get datarow
			if (oData != null)  // null if we clicked on title row
			{
					$("#schoolID").val(oData[0]);
					$("#school-name").val(oData[1]);
					$("#school-address").val(oData[2]);
					$("#school-city").val(oData[3]);
					$("#school-state").val(oData[4]);
					$("#school-zip").val(oData[5]);
				
				// close the window
				$("#school-dialog").dialog('close');
			}
		});
				
		// $("input").prop('disabled', true); THIS IS FOR READ ONLY ACCESS - INPUT DISABLED FOR TYPE 5 users		
	});
		 
	</script>
 
	<div id="school-dialog" title="Add New School">
		<table id="school-table">
      <thead>
          <tr>
            <th>ID</th>
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
            <th>ID</th>
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
							<td>Address:</td>
							<td><input type="text" name="physical-address" id="physical-address" size="40" value=""/></td>
						</tr>
            <tr>
              <td>City:</td>
              <td>
          			<input type="hidden" name="physical-locationID" id="physical-locationID" value="<? echo $defendant->getPhysicalLocationID(); ?>" />
              	<input type="text" name="physical-city" id="physical-city" />
           			State: <input type="text" name="physical-state" id="physical-state" size="2" />
                Zip: <input type="text" name="physical-zip" id="physical-zip" size="7" />
                <a class="select-location" id="physical-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
              </td>
            </tr>
					</table>
				</fieldset>
				
				<fieldset>
					<legend>Mailing Address</legend>
					<table>
						<tr>
							<td></td>
							<td><input type="checkbox" id="sameaddress" />  Same as physical address</td>
						</tr>
						<tr>
							<td>Address:</td>
							<td><input type="text" name="mailing-address" id="mailing-address" size="40" value="" /></td>
						</tr>
            <tr>
            	<td>City:</td>
              <td>
          			<input type="hidden" name="mailing-locationID" id="mailing-locationID" value="<? echo $defendant->getMailingLocationID(); ?>" />
              	<input type="text" name="mailing-city" id="mailing-city" />
           			State: <input type="text" name="mailing-state" id="mailing-state" size="2" />
                Zip: <input type="text" name="mailing-zip" id="mailing-zip" size="7" />
                <a class="select-location" id="mailing-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
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
              	<input type="text" name="school-name" id="school-name" size="40" value="" />
              	Grade: <input type="text" name="grade" size="5" value="" />
              </td>
						</tr>
						<tr>
							<td>Address:</td>
							<td><input type="text" name="school-address" id="school-address" size="40" value="" /></td>
						</tr>
            <tr>
            	<td>City:</td>
              <td>
         				<input type="hidden" name="schoolID" id="schoolID" value="<? echo $defendant->getSchoolID(); ?>" />
              	<input type="text" name="school-city" id="school-city" />
           			State: <input type="text" name="school-state" id="school-state" size="2" />
                Zip: <input type="text" name="school-zip" id="school-zip" size="7" />
                <a id="select-school-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
              </td>
            </tr>
            <tr>
							<td>School Contact:</td>
							<td>
              	<input type="text" name="contact" value="" />
                Phone: <input type="text" name="contact-phone" value="" />
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

