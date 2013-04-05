  <fieldset>
    <legend>Court Location</legend>
    <table>
      <tr>
        <td width="100">Name:</td>
        <td>
          <input type="text" name="locationName" id="court-name" style="width: 250px;" value="<? echo $locationName ?>"/>
          
          <a class="select-item ui-state-default ui-corner-all"  id="court-location" title="Select Existing Location">
            <span class="ui-icon ui-icon-newwin"></span>
          </a>        
        </td>
      </tr>
      <tr>
        <td>Address:</td>
        <td><input type="text" name="court-address" id="court-address" style="width: 250px;" value="<? echo $locationAddress ?>"/></td>
      </tr>
      <tr>
        <td>City:</td>
        <td>     
          <input type="text" name="court-city" id="court-city" value="<? echo $locationCity ?>" />
          State: <input type="text" name="court-state" id="court-state" size="2" value="<? echo $locationState ?>" />
          Zip: <input type="text" name="court-zip" id="court-zip" size="7" value="<? echo $locationZip ?>" />
          
          <a class="select-item ui-state-default ui-corner-all"  id="program-location" title="Select Existing Location">
            <span class="ui-icon ui-icon-newwin"></span>
          </a>
        </td>
      </tr>
    </table>
  </fieldset>