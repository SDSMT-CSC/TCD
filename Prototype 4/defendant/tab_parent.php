<div id="parent-dialog" title="Add New Parent/Guardian">
  <form id="guardian-form" action="process.php" method="post">
    <input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
    <input type="hidden" name="action" value="Add Guardian" />
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
                        <input type="text" name="guardian-physical-city" id="guardian-physical-city" />
                        State: <input type="text" name="guardian-physical-state" id="guardian-physical-state" size="2" />
                        Zip: <input type="text" name="guardian-physical-zip" id="guardian-physical-zip" size="7" />
                        <a class="select-location" id="guardian-plocation" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
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
                        <input type="text" name="guardian-mailing-city" id="guardian-mailing-city" />
                        State: <input type="text" name="guardian-mailing-state" id="guardian-mailing-state" size="2" />
                        Zip: <input type="text" name="guardian-mailing-zip" id="guardian-mailing-zip" size="7" />
                        <a class="select-location" id="guardian-mlocation" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
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
	
<div id="guardian-list">
<input type="hidden" id="totalGuardians" value="<? echo $defendant->totalGuardians() ?>" />
<?
$guardian = new Guardian( $id );

$gList =  $defendant->getGuardianList(); 

if( sizeof( $gList ) == 0 )
	echo "<p>No parent or guardian information has been entered.</p>";
else
	foreach( $gList as $gID )
	{
	$guardian->getFromID( $gID );
	?>
  <form id="update-guardian-form-<? echo $gID ?>" action="process.php" method="post">
  <input type="hidden" name="defendantID" value="<? echo $id ?>" />
  <input type="hidden" name="guardianID" value="<? echo $gID ?>" />
  <input type="hidden" name="action" value="Update Guardian" />
  <fieldset>
    <legend>Parent/Guardian</legend>
      <table>
        <tr>
          <td valign="top">
            <table>
              <tr>
                <td>Relationship:</td>
                <td>
                  <select name="relationship" id="relationship-<? echo $gID ?>">
                    <option></option>
                    <option<? if( $guardian->relation == "Father" ) echo " selected"; ?>>Father</option>
                    <option<? if( $guardian->relation == "Mother" ) echo " selected"; ?>>Mother</option>
                    <option<? if( $guardian->relation == "Step-Father" ) echo " selected"; ?>>Step-Father</option>
                    <option<? if( $guardian->relation == "Step-Mother" ) echo " selected"; ?>>Step-Mother</option>
                    <option<? if( $guardian->relation == "Guardian" ) echo " selected"; ?>>Guardian</option>
                    <option<? if( $guardian->relation == "Other" ) echo " selected"; ?>>Other</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>First Name:</td>
                <td><input type="text" name="first-name" value="<? echo $guardian->firstName ?>" /></td>
              </tr>
              <tr>
                <td>Last Name:</td>
                <td><input type="text" name="last-name" value="<? echo $guardian->lastName ?>" /></td>
              </tr>
              <tr>
                <td>Home Phone:</td>
                <td><input type="text" name="home-phone"  value="<? echo $guardian->homePhone ?>" /></td>
              </tr>
              <tr>
                <td>Work Phone:</td>
                <td><input type="text" name="work-phone" value="<? echo $guardian->workPhone ?>" /></td>
              </tr>
              <tr>
                <td>Employer:</td>
                <td><input type="text" name="employer" value="<? echo $guardian->employer ?>" /></td>
              </tr>
              <tr>
                <td>Email Address:</td>
                <td><input type="text" name="email" value="<? echo $guardian->email ?>" /></td>
              </tr>
            </table>
          </td>
          <td valign="top">
            <table>
              <tr>
                <td>
                  <?
									$location = new Location( $defendant->getProgramID() );
									$location->getFromID( $guardian->pID );
									?>             
                  <fieldset>
                    <legend>Physical Address</legend>
                    <table>
                      <tr>
                        <td>Address:</td>
                        <td>
                          <input type="text" name="guardian-physical-address" id="guardian-physical-address-<? echo $gID ?>"  
                                 value="<? echo $guardian->pAddress ?>" size="40"/>
                        </td>
                      </tr>
                      <tr>
                        <td>City:</td>
                        <td>
                          <input type="text" name="guardian-physical-city" id="guardian-physical-city-<? echo $gID ?>" 
                                 value="<? echo $location->city ?>" />
                          State: <input type="text" name="guardian-physical-state" id="guardian-physical-state-<? echo $gID ?>" 
                                        size="2" value="<? echo $location->state ?>" />
                          Zip: <input type="text" name="guardian-physical-zip" id="guardian-physical-zip-<? echo $gID ?>" size="7" 
                                      value="<? echo $location->zip ?>" />
                          <a class="select-location" id="guardian-plocation-<? echo $gID ?>" style="cursor:pointer;">
                          <img src="/images/add.png" border="0" align="absmiddle" />
                          </a>
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
                    <? $location->getFromID( $guardian->mID ); ?>
                    <table>
                      <tr>
                        <td>Address:</td>
                        <td>
                          <input type="text" name="guardian-mailing-address" id="guardian-mailing-address-<? echo $gID ?>" 
                                 value="<? echo $guardian->mAddress ?>" size="40"  />
                        </td>
                      </tr>
                      <tr>
                        <td>City:</td>
                        <td>
                          <input type="text" name="guardian-mailing-city" 
                          				id="guardian-mailing-city-<? echo $gID ?>" value="<? echo $location->city ?>" />
                          State: <input type="text" name="guardian-mailing-state" id="guardian-mailing-state-<? echo $gID ?>" 
                          							size="2" value="<? echo $location->state ?>" />
                          Zip: <input type="text" name="guardian-mailing-zip" id="guardian-mailing-zip-<? echo $gID ?>" 
                          						size="7" value="<? echo $location->zip ?>" />
                          <a class="select-location" id="guardian-mlocation-<? echo $gID ?>" style="cursor:pointer;">
                          <img src="/images/add.png" border="0" align="absmiddle" />
                          </a>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                  <? unset($location) ?>
                </td>
              </tr>
              <tr>
                <td align="right">
                  Defendant lives with this person?:
                  <select name="liveswith">
                    <option value="1"<? if( $guardian->liveswith == 1 ) echo " selected"; ?>>Yes</option>
                    <option value="0"<? if( $guardian->liveswith == 0 ) echo " selected"; ?>>No</option>
                  </select>
                  <button class="delete-guardian" value="<? echo "process.php?action=Delete%20Guardian&id=" . $id . "&gid=" . $gID  ?>">Delete Guardian</button>
                  <input type="submit" name="update-guardian-<? echo $gID ?>" class="update-guardian" value="Update Guardian" />                  
                </td>
              </tr>
            </table>            
          </td>
        </tr>
      </table>
    </fieldset>
  </form>
<?		
}
?>
</div>

<input type="button" class="add" id="add-parent" value="Add New Parent/Guardian" />
		