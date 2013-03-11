<script>
jQuery(function($) {		
	$("#parent-dialog").dialog({
			resizable: false,
			autoOpen:false,
			modal: true,
			width:820,
			buttons: {
				'Add Parent/Guardian': function() {
					$(this).dialog('close');
					$.post("process.php", $("#parent-form").serialize(), function(data) {
						
						// refresh parent list
						// TODO
						$('#tabs').tabs('load', 1);
						
						// clear the form
						$("#SameAsDefendant").attr("checked",false);
						$("#relationship")[0].selectedIndex = 0;
						$("#parent-form").find("input[type=text], textarea").val("");
					});
					},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
		
	$('#add-parent').click(function(){$('#parent-dialog').dialog('open');});
	
	$("#SameAsDefendant").click(function() {
		if($(this).is(':checked')) {
			$("#guardian-physical-address").val($("#physical-address").val());
			$("#guardian-physical-city").val($("#physical-city").val());
			$("#guardian-physical-state").val($("#physical-state").val());
			$("#guardian-physical-zip").val($("#physical-zip").val());
			$("#guardian-mailing-address").val($("#mailing-address").val());
			$("#guardian-mailing-city").val($("#mailing-city").val());
			$("#guardian-mailing-state").val($("#mailing-state").val());
			$("#guardian-mailing-zip").val($("#mailing-zip").val());
		}
	});
	
	$.get('guardian_list.php?id=<? echo $defendant->getDefendantID() ?>' ).done(function(data) {
  		$("#guardian-list").html(data);
		});
});
</script>
 
	<div id="parent-dialog" title="Add New Parent/Guardian">
		<form name="parent-form" id="parent-form">
    	<input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
    	<input type="hidden" name="action" value="Add Parent" />
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
							<tr><td><input type="checkbox" id="SameAsDefendant" />  Same as defendant addresses</td></tr>
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
                </td>
              </tr>
            </table>            
					</td>
				</tr>
			</table>
		</form>
	</div>
	
<div id="guardian-list"></div>							
<input type="button" class="add" id="add-parent" value="Add New Parent/Guardian" />
		