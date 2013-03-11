<?
$id = $_GET["id"]; 

?>
	<form name="update-guardian">
	<fieldset>
  	<legend>Parent/Guardian</legend>
			<table>
				<tr>
					<td valign="top">
						<table>
							<tr>
								<td>Relationship:</td>
								<td>
									<select name="relationship" id="relationship">
										<option></option>
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
								<td>First Name:</td>
								<td><input type="text" name="first-name"/></td>
							</tr>
							<tr>
								<td>Last Name:</td>
								<td><input type="text" name="last-name"/></td>
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
								<td>Email Address:</td>
								<td><input type="text" name="email" /></td>
							</tr>
						</table>
					</td>
					<td valign="top">
          	<table>
              <tr>
              	<td>             
                  <fieldset>
                    <legend>Physical Address</legend>
                    <table>
                      <tr>
                        <td>Address:</td>
                        <td><input type="text" name="guardian-physical-address" id="guardian-physical-address" size="40"/></td>
                      </tr>
                      <tr>
                        <td>City:</td>
                        <td>
                          <input type="text" name="guardian-physical-city" id="guardian-physical-city" value="<? echo $glocation->city ?>" />
                          State: <input type="text" name="guardian-physical-state" id="guardian-physical-state" size="2" value="<? echo $glocation->state ?>" />
                          Zip: <input type="text" name="guardian-physical-zip" id="guardian-physical-zip" size="7" value="<? echo $glocation->zip ?>" />
                          <a class="select-location" id="parent-plocation" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
                        </td>
                      </tr>							
                    </table>
                  </fieldset>
                </td>
              </tr>
              <tr>
              	<td>
                  <fieldset>
                    <legend>Mailing Address</legend>
                    <table>
                      <tr>
                        <td>Address:</td>
                        <td><input type="text" name="guardian-mailing-address" id="guardian-mailing-address" size="40"  /></td>
                      </tr>
                      <tr>
                        <td>City:</td>
                        <td>
                          <input type="text" name="guardian-mailing-city" id="guardian-mailing-city" value="<? echo $glocation->city ?>" />
                          State: <input type="text" name="guardian-mailing-state" id="guardian-mailing-state" size="2" value="<? echo $glocation->state ?>" />
                          Zip: <input type="text" name="guardian-mailing-zip" id="guardian-mailing-zip" size="7" value="<? echo $glocation->zip ?>" />
                          <a class="select-location" id="parent-mlocation" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
                        </td>
                      </tr>			
                    </table>
                  </fieldset>
              	</td>
              </tr>
            	<tr>
              	<td>
                  Defendant lives with this person?:
                  <select name="liveswith">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                  <input type="submit" name="update-guardian" id="update-guardian" value="Update Guardian" />                  
                </td>
              </tr>
            </table>            
					</td>
				</tr>
			</table>
     </fieldset>
     </form>