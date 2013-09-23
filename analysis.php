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

	// $clients = SingletonDB::multiQuery("SELECT c.ClientName,
	// 									(
	// 										SELECT COUNT(a.AnalysisID)
	// 										FROM Analysis a
	// 										WHERE a.ClientID = c.ClientID
	// 									) as 'NumAnalysis',
	// 									(
	// 										SELECT a.AnalysisID
	// 										FROM Analysis a
	// 										WHERE a.ClientID = c.ClientID
	// 										ORDER BY a.Created
	// 										LIMIT 1
	// 									) as 'Latest'
	// 									FROM Clients c
	// 									WHERE c.ClientID LIKE '$search';");

	$analysis = new Analysis(1);
	$consHeadings = array("Insignificant", "Serious", "Significant", "Major", "Catastrophic");
	$likeHeadings = array("", "Almost Certain", "Likely", "Possible", "Unlikely", "Rare");
	$classes = array("High", "High", "Extreme", "Extreme", "Extreme",
					 "Moderate", "High", "High", "Extreme", "Extreme", 
					 "Managed Risk", "Moderate", "High", "High", "Extreme",
					 "Managed Risk", "Managed Risk", "Moderate", "High", "Extreme",
					 "Managed Risk", "Managed Risk", "Moderate", "High", "High");

?>
<?php get_header('', !$lo); ?>
			<div id="infoBox"><?=$msg?></div>
			<div id="welcomeBox">
				<h2>Anaylsis</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus consectetur nunc sed lectus porttitor, eu placerat magna ultricies. Quisque nunc lacus,
					tempus eu bibendum nec, fermentum at velit. Vivamus nisl nibh, bibendum vitae est vel, sollicitudin euismod nisl. Vestibulum dictum mauris eget nisi laoreet iaculis.</p>

				<table width="100%" border="1" class="evenTable" id="reportTable">
					<tr><th class="tinyCell">&nbsp;</th><th colspan="6">Potential Consequence</th></tr>
					<tr><th rowspan="7" class="tinyCell">L<br/>i<br/>k<br/>e<br/>l<br/>i<br/>h<br/>o<br/>o<br/>d</th></tr>
					<?php
						$i = 0;
						for($like = 0; $like < count($likeHeadings); $like++){
							echo "<tr>\n";
								echo "<th>". $likeHeadings[$like] ."</th>";
								for($cons = 0; $cons < count($consHeadings); $cons++){
									if($like == 0)
										echo "<th>". $consHeadings[$cons] ."</th>\n";
									else {
										echo "<td class=\"". str_replace(' ', '', $classes[$i]) ."\">";
										echo "<h3>". $classes[$i++] ."</h3>\n";
										foreach($analysis->search(count($likeHeadings)-$like, $cons+1) as $entry)
											echo "<li>".$entry['Risk']."</li>";
										echo "</td>";
									}
								}
							echo "</tr>\n";
						}
					?>
				</table>
			</div>
			<div>
				
			</div>
<?php get_footer(true) ?>