<?php
	/*
	 *	Std Header
	*/
	session_start();
	foreach(glob('classes/*') as $classURI)
		include($classURI);
	$msg = "";
	$lo = false;
	if (!isset($_SESSION['logged']) || !$_SESSION['logged'])
		die("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=index.php\" />");

	//Action Code

	//Display Code
	$search = $_SESSION['user']['UserID'];
	if ($_SESSION['user']['Authentication'] == 'A' || $_SESSION['user']['Authentication'] == 'M')
		$search = '%';

	$clients = SingletonDB::multiQuery("SELECT c.ClientName,
										(
											SELECT COUNT(a.AnalysisID)
											FROM Analysis a
											WHERE a.ClientID = c.ClientID
										) as 'NumAnalysis',
										(
											SELECT a.AnalysisID
											FROM Analysis a
											WHERE a.ClientID = c.ClientID
											ORDER BY a.Created
											LIMIT 1
										) as 'Latest'
										FROM Clients c
										WHERE c.ClientID LIKE '$search';");
?>
<?php get_header('', !$lo); ?>
			<div id="infoBox"><?=$msg?></div>
			<div id="welcomeBox">
				<h2>Clients</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus consectetur nunc sed lectus porttitor, eu placerat magna ultricies. Quisque nunc lacus,
					tempus eu bibendum nec, fermentum at velit. Vivamus nisl nibh, bibendum vitae est vel, sollicitudin euismod nisl. Vestibulum dictum mauris eget nisi laoreet iaculis.</p>
			</div>
			<div>
				<table id="clientTable" class="bigTable">
					<tr>
						<th>Client Name</th>
						<th># Analysis</th>
						<th>Latest Analysis</th>
						<th>&nbsp;</th>
					</tr>
				<?php
					foreach($clients as $client) {
						if (is_null($client['Latest']))
							$client['Latest'] = '-';
						echo "<tr>\n";
							echo "<td>". $client['ClientName'] ."</td>\n";
							echo "<td>". $client['NumAnalysis'] ."</td>\n";
							echo "<td>". $client['Latest'] ."</td>\n";
							echo "<td></td>\n";
						echo "</tr>\n";
					}
				?>
				</table>
			</div>
<?php get_footer(true) ?>