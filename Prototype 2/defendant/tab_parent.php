	<script>
	jQuery(function($) {		
		$("#parent-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:700,
				height:435,
				buttons: {
					'Add Parent/Guardian': function() {
						$(this).dialog('close');
							// TO DO: add school
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			
			});
			
		$('#add-parent').click(function(){$('#parent-dialog').dialog('open');});
	});
	</script>
 
	<div id="parent-dialog" title="Add New Parent/Guardian">
		<form>
			<table>
				<tr>
					<td valign="top">
						<table>
							<tr>
								<td>Relationship:</td>
								<td>
									<select name="relationship">
										<option>Father</option>
										<option>Mother</option>
										<option>Step-Father</option>
										<option>Step-Mother</option>
										<option>Guardian</option>
										<option>Other</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Last Name:</td>
								<td><input type="text" name="first-name"/></td>
							</tr>
							<tr>
								<td>First Name:</td>
								<td><input type="text" name="first-name"/> MI: <input type="text" name="middle" size="5" /></td>
							</tr>
							<tr>
								<td>Home Phone:</td>
								<td><input type="text" name="home-phone" /></td>
							</tr>
							<tr>
								<td>Work Phone:</td>
								<td><input type="text" name="work-phone" /></td>
							</tr>
							<tr>
								<td>Employer:</td>
								<td><input type="text" name="employer" /></td>
							</tr>
							<tr>
								<td>Defendant lives with?:</td>
								<td>
									<select name="liveswith">
										<option>No</option>
										<option selected="selected">Yes</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<fieldset>
							<legend>Physical Address</legend>
							<table>
								<tr>
									<td>Street:</td>
									<td><input type="text" name="physical-street" size="40"/></td>
								</tr>
								<tr>
									<td>City:</td>
									<td>
										<input type="text" name="physical-city" /> State: 
										<select name="physical-state">
											<option>ND</option>
											<option selected="selected">SD</option>
											<option>WY</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Zip:</td>
									<td><input type="text" name="physical-zip" /></td>
								</tr>
								
							</table>
						</fieldset>
						
						<fieldset>
							<legend>Mailing Address</legend>
							<table>
								<tr>
									<td>Street:</td>
									<td><input type="text" name="mailing-street" size="40"  /></td>
								</tr>
								<tr>
									<td>City:</td>
									<td>
										<input type="text" name="mailing-city"  /> State: 
										<select name="mailing-state">
											<option>ND</option>
											<option selected="selected">SD</option>
											<option>WY</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Zip:</td>
									<td><input type="text" name="mailing-zip" /></td>
								</tr>						
							</table>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td><button class="delete">Delete</button></td>
					<td><input type="checkbox" checked />  Same as defendant addresses</td>	
				</tr>
			</table>
		</form>
	</div>
	
		<fieldset>
			<legend>Parent/Guardian Information</legend>
			<table>
				<tr>
					<td valign="top">
						<table>
							<tr>
								<td>Relationship:</td>
								<td>
									<select name="relationship">
										<option>Father</option>
										<option selected="selected">Mother</option>
										<option>Step-Father</option>
										<option>Step-Mother</option>
										<option>Guardian</option>
										<option>Other</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Last Name:</td>
								<td><input type="text" name="first-name" value="Doe"/></td>
							</tr>
							<tr>
								<td>First Name:</td>
								<td><input type="text" name="first-name" value="Suzan"/> MI: <input type="text" name="middle" size="5" value="D" /></td>
							</tr>
							<tr>
								<td>Home Phone:</td>
								<td><input type="text" name="home-phone" value="(605) 555-5555"/></td>
							</tr>
							<tr>
								<td>Work Phone:</td>
								<td><input type="text" name="work-phone" value="(605) 555-5555"/></td>
							</tr>
							<tr>
								<td>Employer:</td>
								<td><input type="text" name="employer" value="Deadwood Library"/></td>
							</tr>
							<tr>
								<td>Defendant lives with?:</td>
								<td>
									<select name="liveswith">
										<option>No</option>
										<option selected="selected">Yes</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
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
					</td>
				</tr>
				<tr>
					<td><button class="delete">Delete</button></td>
					<td><input type="checkbox" checked />  Same as defendant addresses</td>	
				</tr>
			</table>
			
		</fieldset>

		<fieldset>
			<legend>Parent/Guardian Information</legend>
			<table>
				<tr>
					<td valign="top">
						<table>
							<tr>
								<td>Relationship:</td>
								<td>
									<select name="relationship">
										<option selected="selected">Father</option>
										<option>Mother</option>
										<option>Step-Father</option>
										<option>Step-Mother</option>
										<option>Guardian</option>
										<option>Other</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Last Name:</td>
								<td><input type="text" name="first-name" value="Doe"/></td>
							</tr>
							<tr>
								<td>First Name:</td>
								<td><input type="text" name="first-name" value="James"/> MI: <input type="text" name="middle" size="5" value="R" /></td>
							</tr>
							<tr>
								<td>Home Phone:</td>
								<td><input type="text" name="home-phone" value="(605) 555-5555"/></td>
							</tr>
							<tr>
								<td>Work Phone:</td>
								<td><input type="text" name="work-phone" value="(605) 555-5555"/></td>
							</tr>
							<tr>
								<td>Employer:</td>
								<td><input type="text" name="employer" value="Four Aces"/></td>
							</tr>
							<tr>
								<td>Defendant lives with?:</td>
								<td>
									<select name="liveswith">
										<option>No</option>
										<option selected="selected">Yes</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
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
				</td>
			</tr>
				<tr>
					<td><button class="delete">Delete</button></td>
					<td><input type="checkbox" checked />  Same as defendant addresses</td>	
				</tr>
		</table>
		</fieldset>
							
		<input type="button" class="add" id="add-parent" value="Add New Parent/Guardian" />
		