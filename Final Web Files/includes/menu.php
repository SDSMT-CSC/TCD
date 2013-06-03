<div id="menu">
	<ul>
		
		<? if ( $user_type != 1 ) { ?>
		<li><a id="main" href="/main.php">Home</a>
		<li>
			<a id="defendant" href="/defendant/index.php">Defendants</a>
			<ul>
				<li><a href="/defendant/index.php">List Defendants</a></li>
				<li><a href="/defendant/view.php">New Defendant</a></li>
				<li><a href="/defendant/search.php">Search Defendants</a></li>
			</ul>
		</li>
		<li>
			<a id="volunteer" href="/volunteer/index.php">Volunteers</a>
			<ul>
				<li><a href="/volunteer/index.php">List Volunteers</a></li>	
				<li><a href="/volunteer/view.php">New Volunteer</a></li>	
				<li><a href="/volunteer/search.php">Search Volunteers</a></li>
			</ul>	
		</li>
		<li>
			<a id="court" href="/court/index.php">Courts</a>
			<ul>
				<li><a href="/court/index.php">List Courts</a></li>
				<li><a href="/court/view.php">New Court</a></li>
				<li><a href="/court/hours.php">Enter Hours</a></li>	
				<li><a href="/court/search.php">Search Courts</a></li>
			</ul>
		</li>
		<li>
			<a id="workshop" href="/workshop/index.php">Workshops</a>
			<ul>
				<li><a href="/workshop/index.php">List Workshops</a></li>
				<li><a href="/workshop/view.php">New Workshop</a></li>
				<li><a href="/workshop/search.php">Search Workshops</a></li>
			</ul>
		</li>
		<li><a id="reports" href="/reports/index.php">Reports</a></li>
		<!--<li><a id="statistics" href="/statistics/index.php">Statistics</a></li>-->
		<? } ?>
    
		<? // if ( $user_type == 2 ) { ?>
		<!-- <li><a id="surveys" href="#">Surveys</a></li> -->
		<? // } ?>
		
		<? if ( $user_type == 1 || $user_type == 2 ) { ?>
		<li><a id="programs" href="/admin/programs.php">Programs</a></li>
    <li><a id="users" href="/admin/users.php">Users</a></li>
		<? } ?>
		
		<? if ( $user_type == 2 || $user_type == 3 ) { ?>
    <li><a id="program" href="/admin/program.php">My Program</a></li>
		<? } ?>
    
    <? if ( $user_type == 3 ) { ?>
    <li><a id="users" href="/admin/users.php">Users</a></li>
    <? } ?>


	</ul>
</div>