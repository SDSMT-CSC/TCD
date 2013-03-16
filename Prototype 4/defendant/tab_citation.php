<?

$citation = new Citation( $defendant->getDefendantID() );

?>

<div id="officer-dialog" title="Add New Officer">
  <form>
    <table>
      <tr>
        <td>Officer ID:</td>
        <td><input type="text" name="officer-id" /></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td><input type="text" name="officer-last-name" /></td>
      </tr>
      <tr>
        <td>First Initial:</td>
        <td><input type="text" name="officer-first-name" /></td>
      </tr>
      <tr>
        <td>Phone Number:</td>
        <td><input type="text" name="officer-first-name" /></td>
      </tr>
    </table>		
  </form>
</div>

<div id="common-location-dialog" title="Add New Common Location">
  <form id="common-location-form">
    <input type="hidden" name="action" value="Add Common Location" />
    <label>Common Location</label>
    <input type="text" name="common-location-name" id="common-location-name" style="width: 275px;" />
  </form>
</div>

<div id="offense-dialog" title="Add Offense">
  <form>
      <label>Offence:</label>
      <select name="offense">
        <option></option>
        
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

<?
$citation = new Citation( $defendant->getProgramID() );
?>
<form name="citation" id="citation" action="process.php" method="post">
  <input type="hidden" name="action" value="Update Citation" />
  <input type="hidden" name="defendantID" value="<? echo $defendant->getDefendantID() ?>" />
  <fieldset>
    <legend>Citation Infomation</legend>
    <table>
      <tr>
        <td>Date:</td>
        <td><input type="text" name="citation-date" id="citation-date" value="<? echo date("m/d/Y", $citation->citationDate); ?>" /></td>
        <td>Officer:</td>
        <td>
        	<? $data = new Data(); ?>
          <select name="officerID" id="officerID">
          	<option></option>
            <? echo $data->fetchOfficerDropdown( $user_programID, $citation->officerID )?>
          </select>
          <a id="add-officer" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
        </td>
      </tr>
      <tr>
        <td>Time:</td>
        <td><input type="text" name="citation-time" id="citation-time" value="<? echo date("h:i A", $citation->citationDate); ?>" /></td>
        <td>Miranda Given?</td>
        <td>
          <select name="miranda">
            <option value="1"<? if( $citation->mirandized == 1 ) echo " selected"; ?>>Yes</option>
            <option value="0"<? if( $citation->mirandized == 0 ) echo " selected"; ?>>No</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Address:</td>
        <td><input type="text" name="citation-address" style="width: 300px;" value="<? echo $defendant->address ?>"/></td>
        <td>Drugs/Alcohol?</td>
        <td>
          <select name="drugs-alcohol">
            <option value="1"<? if( $citation->drugsOrAlcohol == 1 ) echo " selected"; ?>>Yes</option>
            <option value="0"<? if( $citation->drugsOrAlcohol == 0 ) echo " selected"; ?>>No</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Common Place:</td>
        <td>
          <select style="width: 310px;" name="common-location" id="common-location">
            <option></option>
            <? echo $data->fetchCommonLocationDropdown( $user_programID, $citation->commonLocationID )?>
          </select>
          <a id="add-common-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
          <? unset( $data ); ?>
        </td>
      </tr>
      <tr>
        <td>City:</td>
        <td>
          <? 
          $location = new Location( $defendant->getProgramID() );
          $location->getFromID( $citation->locationID );
          ?>
          <input type="text" name="citation-city" id="citation-city" value="<? echo $location->city ?>" />
          State: <input type="text" name="citation-state" id="citation-state" size="2" value="<? echo $location->state ?>" />
          Zip: <input type="text" name="citation-zip" id="citation-zip" size="7" value="<? echo $location->zip ?>" />
          <a class="select-location" id="citation-location" style="cursor:pointer;"><img src="/images/add.png" border="0" align="absmiddle" /></a>
          <?
          unset($location);
          ?>
        </td>
        <td colspan="2" align="right"><button id="citation-submit">Update Citation Information</button></td>
      </tr>
    </table>
  </fieldset>
</form>

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
<? unset( $citation ); ?>
