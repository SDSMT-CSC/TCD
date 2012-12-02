	<table>
		<tr>
			<td>
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
										<td>Street:</td>
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
									<th width="50">Statue</th>
									<th width="400">Title</th>
									<th width="150">Type</th>
									<th width="50">Remove</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>123.01.A</td>
									<td>Theft</td>
									<td>Misdemeanor</td>
									<td><a href="view.php">Remove</a></td>
								</tr>
								<tr>
									<td>123.01.A</td>
									<td>Theft</td>
									<td>Misdemeanor</td>
									<td><a href="view.php">Remove</a></td>
								</tr>
							</tbody>
						</table>
						<div>
							<label>Offence:</label>
							<select name="offense">
								<option></option>
								<option>22-21-1: Trespassing with intent to eavesdrop (Class 1 Misdemeanor)</option>
								<option>22-14-20: Discharge of firearm at occupied structure or motor vehicle (Felony)</option>
							</select>
							<button class="add">Add Offense</button>
						</div>
				</fieldset>
				
				<fieldset>
						<legend>Stolen/Vandalized Items</legend>
						<table class="listing">
							<thead>
								<tr>
									<th width="250">Item</th>
									<th width="100">Value</th>
									<th width="50">Remove</th>
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
							<label>Item:</label>
							<input type="text" name="item" size="30">
							<label>value:</label>
							<input type="text" name="item" size="10">
							<button class="add">Add Item</button>
						</div>
				</fieldset>
			
			
				<fieldset>
						<legend>Vehicles Involved</legend>
						
				</fieldset>
		
		</tr>
	</table>