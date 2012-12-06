		<script>
		jQuery(function($) {
			$("#officer-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:400,
				height:225,
				buttons: {
					'Add Officer': function() {
						$(this).dialog('close');
							// TO DO: add school
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
			
			$("#common-place-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:450,
				height:175,
				buttons: {
					'Add Location': function() {
						$(this).dialog('close');
							// TO DO: add school
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
			
			$("#offense-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:600,
				height:200,
				buttons: {
					'Add Offense': function() {
						$(this).dialog('close');
							// TO DO: add offense
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
			
			$("#item-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:400,
				height:200,
				buttons: {
					'Add Item': function() {
						$(this).dialog('close');
							// TO DO: add stolen item
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
			
			$("#vehicle-dialog").dialog({
				resizable: false,
				autoOpen:false,
				modal: true,
				width:400,
				height:310,
				buttons: {
					'Add Vehicle': function() {
						$(this).dialog('close');
							// TO DO: add vehicle
						},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		
			$('#add-officer').click(function(){ $('#officer-dialog').dialog('open'); });
			$('#add-common-place').click(function(){ $('#common-place-dialog').dialog('open'); });
			$('#add-offense').click(function(){ $('#offense-dialog').dialog('open'); });
			$('#add-item').click(function(){ $('#item-dialog').dialog('open'); });
			$('#add-vehicle').click(function(){ $('#vehicle-dialog').dialog('open'); });
		});
		</script>
		
		<div id="officer-dialog" title="Add New Officer">
			<form>
				<table>
					<tr>
						<td>Officer ID</td>
						<td><input type="text" name="officer-id" /></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" name="officer-last-name" /></td>
					</tr>
					<tr>
						<td>First Initial</td>
						<td><input type="text" name="officer-first-name" /></td>
					</tr>
				</table>		
			</form>
		</div>
		
		<div id="common-place-dialog" title="Add New Common Place">
			<form>
				<label>Common Place</label>
				<input type="text" name="common-place-name" size="40" />
			</form>
		</div>
		
		<div id="offense-dialog" title="Add Offense">
			<form>
					<label>Offence:</label>
					<select name="offense">
						<option></option>
						<option>22-10-2: Theft (Class 2 Misdemeanor)</option>
						<option>22-21-1: Trespassing with intent to eavesdrop (Class 1 Misdemeanor)</option>
						<option>22-14-20: Discharge of firearm at occupied structure or motor vehicle (Felony)</option>
					</select>
			</form>
		</div>
		
		<div id="item-dialog" title="Add Stolen/Vandalized Item">
			<form>
				<table>
					<tr>
						<td>Item:</td>
						<td><input type="text" name="item" size="30"></td>
					</tr>
					<tr>
						<td>Value:</td>
						<td><input type="text" name="item" size="10"></td>
					</tr>
				</table>
			</form>
		</div>
		
		<div id="vehicle-dialog" title="Add Vehicle">
			<form>
			<table>
				<tr>
					<td>Year:</td>
					<td><input type="text" name="item" ></td>
				</tr>					
				<tr>
					<td>Make:</td>
					<td><input type="text" name="item" ></td>
				</tr>	
				<tr>
					<td>Model:</td>
					<td><input type="text" name="item" ></td>
				</tr>	
				<tr>
					<td>Color:</td>
					<td><input type="text" name="item" ></td>
				</tr>	
				<tr>
					<td>License:</td>
					<td><input type="text" name="item" ></td>
				</tr>	
				<tr>
					<td>State:</td>
					<td><input type="text" name="item" ></td>
				</tr>	
			</table>
		</form>
		</div>
		

		<fieldset>
			<legend>Citation Infomation</legend>
			<table>
				<tr>
					<td valign="top">
						<table>
							<tr>
								<td>Date:</td>
								<td><input type="text" name="citation-date" id="citation-date" value="11/04/2012" /></td>
							</tr>
							<tr>
								<td>Time:</td>
								<td><input type="text" name="citation-time" id="citation-time" value="10:30 am" /></td>
							</tr>
							<tr>
								<td>Address:</td>
								<td><input type="text" name="citation-street" size="40" value="673 3rd Avenue"/></td>
							</tr>
							<tr>
								<td>City:</td>
								<td>
									<input type="text" name="citation-city" value="Deadwood" /> State: 
									<select name="citation-state">
										<option>ND</option>
										<option selected="selected">SD</option>
										<option>WY</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Zip:</td>
								<td><input type="text" name="citation-zip" value="57732" /></td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<table>
							<tr>
								<td>Officer:</td>
								<td>
									<select name="officer">
										<option>345 - Johnson, D.</option>
										<option selected="selected">124 - Jackson, R.</option>
										<option>223 - Alberts, J.</option>
									</select>
									<a id="add-officer" style="cursor:pointer;">+</a>
								</td>
							</tr>
							<tr>
								<td>Miranda Given?</td>
								<td>
									<select name="miranda">
										<option>Yes</option>
										<option selected="selected">No</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Drugs/Alcohol?</td>
								<td>
									<select name="drugs-alcohol">
										<option>Yes</option>
										<option selected="selected">No</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Common Place:</td>
								<td>
									<select name="officer">
										<option></option>
										<option>Haley Park, 45 South Rd, Deadwood, SD</option>
										<option>Route 385 Turn-off, Mile Marker 15</option>
									</select>
									<a id="add-common-place" style="cursor:pointer;">+</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</fieldset>
	
		<fieldset>
				<legend>Offense</legend>					
				<table class="listing">
					<thead>
						<tr>
							<th width="10%">Statue</th>
							<th width="65%">Title</th>
							<th width="20%">Type</th>
							<th width="5%"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>22-10-2</td>
							<td>Theft</td>
							<td>Class 2 Misdemeanor</td>
							<td><a href="view.php">Remove</a></td>
						</tr>
						<tr>
							<td>22-14-20</td>
							<td>Discharge of firearm at occupied structure or motor vehicle</td>
							<td>Felony</td>
							<td><a href="view.php">Remove</a></td>
						</tr>
					</tbody>
				</table>
				<div>
					<input type="button" class="add" id="add-offense" value="Add Offense" />
				</div>
		</fieldset>
		
		<fieldset>
				<legend>Stolen/Vandalized Items</legend>
				<table class="listing">
					<thead>
						<tr>
							<th width="75%">Item</th>
							<th width="20%">Value</th>
							<th width="5%"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Stereo</td>
							<td>$350</td>
							<td><a href="view.php">Remove</a></td>
						</tr>
					</tbody>
				</table>
				<div>
					<input type="button" class="add" id="add-item" value="Add Item" />
				</div>
		</fieldset>
	
		<fieldset>
				<legend>Vehicles Involved</legend>
				<table class="listing">
					<thead>
						<tr>
							<th width="10%">Year</th>
							<th width="20%">Make</th>
							<th width="20%">Model</th>
							<th width="20%">Color</th>
							<th width="15%">License</th>
							<th width="10%">State</th>
							<th width="5%"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>2005</td>
							<td>Chevy</td>
							<td>F-150</td>
							<td>Red</td>
							<td></td>
							<td></td>
							<td><a href="view.php">Remove</a></td>
						</tr>
					</tbody>
				</table>
				<div>
					<input type="button" class="add" id="add-vehicle" value="Add Vehicle" />
				</div>
		</fieldset>
