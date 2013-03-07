
	<script>
	jQuery(function($) {		
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
			
		
		$('#add-school').click(function(){
				$('#school-dialog').dialog('open');
		});
	 });
	 </script>
 
	<div id="school-dialog" title="Add New School">
		<form>
			<label>School Name</label>
			<input type="text" name="school-name" />
		</form>
	</div>

	<table>
		<tr>
			<td width="600" valign="top">
				<fieldset>
					<legend>Physical Address</legend>
					<table>
						<tr>
							<td>Street:</td>
							<td><input type="text" name="physical-street" size="40" value="142 Main St."/></td>
						</tr>
						<tr>
							<td>City:</td>
							<td>
								<input type="text" name="physical-city" value="Deadwood" /> State: 
								<select name="physical-state">
									<option>ND</option>
									<option selected="selected">SD</option>
									<option>WY</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Zip:</td>
							<td><input type="text" name="physical-zip" value="57732" /></td>
						</tr>
						
					</table>
				</fieldset>
				
				<fieldset>
					<legend>Mailing Address</legend>
					<table>
						<tr>
							<td></td>
							<td><input type="checkbox" checked />  Same as physical address</td>
						</tr>
						<tr>
							<td>Street:</td>
							<td><input type="text" name="mailing-street" size="40" value="142 Main St." /></td>
						</tr>
						<tr>
							<td>City:</td>
							<td>
								<input type="text" name="mailing-city" value="Deadwood" /> State: 
								<select name="mailing-state">
									<option>ND</option>
									<option selected="selected">SD</option>
									<option>WY</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Zip:</td>
							<td><input type="text" name="mailing-zip" value="57732" /></td>
						</tr>						
					</table>
				</fieldset>
				
				<fieldset>
					<legend>School</legend>
					<table>
						<tr>
							<td>School:</td>
							<td>
								<select name="ethnicity" style="width: 300px;">
									<option>Deadwood Junior High</option>
									<option selected="selected">Deadwood High School</option>
								</select>
								<a id="add-school" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
							</td>
						</tr>
						<tr>
							<td>Grade:</td>
							<td><input type="text" name="first-name" size="5" value="11" /></td>
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
							<td><input type="text" name="first-name" size="10" value="5'10&quot;" /></td>
						</tr>
						<tr>
							<td>Weight:</td>
							<td><input type="text" name="first-name" size="10" value="125" /></td>
						</tr>
						<tr>
							<td>Eye Color:</td>
							<td>
								<select name="eye" style="width: 100px;">
									<option>Brown</option>
									<option selected="selected">Blue</option>
									<option>Green</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Hair Color:</td>
							<td>
								<select name="hair" style="width: 100px;">
									<option>Brown</option>
									<option>Black</option>
									<option selected="selected">Blond</option>
									<option>Red</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Ethnicity:</td>
							<td>
								<select name="ethnicity" style="width: 100px;">
									<option>Asian</option>
									<option>African-American</option>
									<option selected="selected">Caucasian</option>
									<option>Hispanic</option>
									<option>Native American</option>
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
							<td><input type="text" name="first-name" size="10" value="10587452" /></td>
						</tr>
						<tr>
							<td>State:</td>
							<td>
								<select name="state">
									<option>ND</option>
									<option selected="selected">SD</option>
									<option>WY</option>
								</select>
							</td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>