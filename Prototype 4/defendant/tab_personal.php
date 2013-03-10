
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
							<td><input type="text" name="physical-address" id="physical-address" size="40" value="<? echo $defendant->pAddress ?>"/></td>
						</tr>
            <tr>
              <td>City:</td>
              <td>
              	<?
								$location = new Location( $user_programID );
								$location->getFromID( $defendant->pID );				
								?>              
              	<input type="text" name="physical-city" id="physical-city" value="<? echo $location->city ?>" />
           			State: <input type="text" name="physical-state" id="physical-state" size="2" value="<? echo $location->state ?>" />
                Zip: <input type="text" name="physical-zip" id="physical-zip" size="7" value="<? echo $location->zip ?>" />
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
							<td><input type="text" name="mailing-address" id="mailing-address" size="40" value="<? echo $defendant->mAddress ?>" /></td>
						</tr>
            <tr>
            	<td>City:</td>
              <td>
              	<? $location->getFromID( $defendant->mID );	?>
              	<input type="text" name="mailing-city" id="mailing-city" value="<? echo $location->city ?>" />
           			State: <input type="text" name="mailing-state" id="mailing-state" size="2" value="<? echo $location->state ?>" />
                Zip: <input type="text" name="mailing-zip" id="mailing-zip" size="7" value="<? echo $location->zip ?>" />
                <a class="select-location" id="mailing-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
              </td>
            </tr>
					</table>
				</fieldset>
				
				<fieldset>
					<legend>School Information</legend>
          <?
					$school = new School( $user_programID );
					$school->getFromID( $defendant->schoolID );
					?>
					<table>
						<tr>
							<td>School Name:</td>
							<td>
              	<input type="text" name="school-name" id="school-name" size="40" value="<? echo $school->name ?>" />
              	Grade: <input type="text" name="grade" size="5" value="<? echo $defendant->schoolGrade ?>" />
              </td>
						</tr>
						<tr>
							<td>Address:</td>
							<td><input type="text" name="school-address" id="school-address" size="40" value="<? echo $school->address ?>" /></td>
						</tr>
            <tr>
            	<td>City:</td>
              <td>
              	<input type="text" name="school-city" id="school-city" value="<? echo $school->city ?>" />
           			State: <input type="text" name="school-state" id="school-state" size="2" value="<? echo $school->state ?>" />
                Zip: <input type="text" name="school-zip" id="school-zip" size="7" value="<? echo $school->zip ?>" />
                <a id="select-school-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
              </td>
            </tr>
            <tr>
							<td>School Contact:</td>
							<td>
              	<input type="text" name="contact" value="<? echo $defendant->schoolContactName ?>" />
                Phone: <input type="text" name="contact-phone" value="<? echo $defendant->schoolContactPhone ?>" />
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
							<td><input type="text" name="height" size="10" value="<? echo $defendant->height ?>" /></td>
						</tr>
						<tr>
							<td>Weight:</td>
							<td><input type="text" name="weight" size="10" value="<? echo $defendant->weight ?>" /></td>
						</tr>
            <tr>
							<td>Sex:</td>
							<td>
								<select name="sex" style="width: 100px;">
                  <option></option>
                  <option<? if( $defendant->sex == "Male" ) echo " selected"; ?>>Male</option>
                  <option<? if( $defendant->sex == "Female" ) echo " selected"; ?>>Female</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Eye Color:</td>
							<td>
								<select name="eye" style="width: 100px;">
                  <option></option>
                  <option<? if( $defendant->eyecolor == "Amber" ) echo " selected"; ?>>Amber</option>
                  <option<? if( $defendant->eyecolor == "Blue" ) echo " selected"; ?>>Blue</option>
									<option<? if( $defendant->eyecolor == "Brown" ) echo " selected"; ?>>Brown</option>
                  <option<? if( $defendant->eyecolor == "Gray" ) echo " selected"; ?>>Gray</option>
                  <option<? if( $defendant->eyecolor == "Green" ) echo " selected"; ?>>Green</option>
                  <option<? if( $defendant->eyecolor == "Hazel" ) echo " selected"; ?>>Hazel</option>
                  <option<? if( $defendant->eyecolor == "Violet" ) echo " selected"; ?>>Violet</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Hair Color:</td>
							<td>
								<select name="hair" style="width: 100px;">
                  <option></option>
                  <option<? if( $defendant->haircolor == "Black" ) echo " selected"; ?>>Black</option>
									<option<? if( $defendant->haircolor == "Brown" ) echo " selected"; ?>>Brown</option>
									<option<? if( $defendant->haircolor == "Blonde" ) echo " selected"; ?>>Blonde</option>
                  <option<? if( $defendant->haircolor == "Auburn" ) echo " selected"; ?>>Auburn</option>
                  <option<? if( $defendant->haircolor == "Chestnut" ) echo " selected"; ?>>Chestnut</option>
									<option<? if( $defendant->haircolor == "Red" ) echo " selected"; ?>>Red</option>
                  <option<? if( $defendant->haircolor == "Gray" ) echo " selected"; ?>>Gray</option>
                  <option<? if( $defendant->haircolor == "White" ) echo " selected"; ?>>White</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Ethnicity:</td>
							<td>
								<select name="ethnicity" style="width: 100px;">
								  <option></option>
									<option<? if( $defendant->ethnicity == "Asian" ) echo " selected"; ?>>Asian</option>
									<option<? if( $defendant->ethnicity == "African-American" ) echo " selected"; ?>>African-American</option>
									<option<? if( $defendant->ethnicity == "Caucasian" ) echo " selected"; ?>>Caucasian</option>
									<option<? if( $defendant->ethnicity == "Hispanic" ) echo " selected"; ?>>Hispanic</option>
									<option<? if( $defendant->ethnicity == "Native American" ) echo " selected"; ?>>Native American</option>
                  <option<? if( $defendant->ethnicity == "Pacific Islander" ) echo " selected"; ?>>Pacific Islander</option>
                  <option<? if( $defendant->ethnicity == "Other" ) echo " selected"; ?>>Other</option>
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
							<td><input type="text" name="dl-number" id="dl-number" size="10" value="<? echo $defendant->licenseNum ?>" /></td>
						</tr>
						<tr>
							<td>State:</td>
							<td><input type="text" name="dl-state" id="dl-state" size="2" value="<? echo $defendant->licenseState ?>" /></td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>
</form>

<button id="defendant-personal-submit">Update Personal Information</button>

