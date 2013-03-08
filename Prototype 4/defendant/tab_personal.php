
	<script>
	jQuery(function($) {
	  
	  $("#defendant-personal-submit").button().click(function() {  }); 
	  
		$("#school-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:400,
				height:150,
				buttons: {
					'Add School': function() {
						$(this).dialog('close');
							// TO DO: add school
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
			
		$("#location-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:400,
				height:200,
				buttons: {
					'Add Location': function() {
							processLocation();
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}	
			});
		
		$('#add-school').click(function(){
				$('#school-dialog').dialog('open');
		});
		
		$('.add-location').click(function(){
				$('#location-dialog').dialog('open');
		});
		
		function processLocation()
		{
			// get values from form
			var city = $("input#city").val();  
			var state = $("input#state").val();  
			var zip = $("input#zip").val();
					
			$.post( $("#location-form").attr("action"), $("#location-form").serialize(), function(response) {
				// close dialog window
        $("#location-dialog").dialog('close');
				
				// fill in the dropdowns
				$("#physical-locationID").append($('<option selected="selected"></option>').val(response).html(city + ", " + state + " " + zip));
        $("#mailing-locationID").append($('<option selected="selected"></option>').val(response).html(city + ", " + state + " " + zip));
    	});
			  
			return false;
		}
	 });
	 </script>
 
	<div id="school-dialog" title="Add New School">
		<form>
			<label>School Name</label>
			<input type="text" name="school-name" />
		</form>
	</div>

	<div id="location-dialog" title="Add New Location">
		<form name="location-form" id="location-form" action="process.php">
    	<input type="hidden" name="action" value="Add Location" />
    	<table>
      	<tr>
        	<td>City</td>
          <td><input type="text" name="city" id="city" /></td>
        </tr>
        <tr>
        	<td>State</td>
          <td><input type="text" name="state" id="state" size="2" /></td>
        </tr>
        <tr>
        	<td>Zip</td>
          <td><input type="text" name="zip" id="zip" size="7" /></td>
        </tr>
      </table>
		</form>
	</div>
  
  <form name="defendant-personal" id="defendant-personal" method="post" action="process.php">
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
            	<td>Location:</td>
              <td>
								<select name="physical-locationID" id="physical-locationID">
                	<? echo $program->getLocationList( "" ); ?>
								</select>
								<a class="add-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
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
            	<td>Location:</td>
              <td>
								<select name="mailing-locationID" id="mailing-locationID">
                  <? echo $program->getLocationList( "" ); ?>
								</select>
								<a class="add-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
              </td>
            </tr>
					</table>
				</fieldset>
				
				<fieldset>
					<legend>School</legend>
					<table>
						<tr>
							<td>School:</td>
							<td>
								<select name="school" style="width: 300px;">
                
								</select>
								<a id="add-school" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
							</td>
						</tr>
						<tr>
							<td>Grade:</td>
							<td><input type="text" name="grade" size="5" value="" /></td>
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
	
	<input type="submit" name="defendant-personal-submit" id="defendant-personal-submit" value="Update Personal Information">
	
</form>

