<?php
	/**
	* Page Functions
	*
	* Not strictly a class but stores various common functions for
	* page generation
	**/

	/* Definitions */
	define("VERSION", "0.1 ALPHA");
	define("COPYRIGHT", "&copy; Copyright here - ".VERSION);
	define("SYSTEM_MAINTENANCE", false);
	define("ROOT", "http://".$_SERVER['SERVER_NAME']."/ARL");

	$menus['A'] = array("Home"=>"main.php",
						"New Analysis"=>"newAnalysis.php",
						"Past Analysis"=>"analysis.php",
						"Clients"=>"clients.php",
						"User Management"=>"user.php",
						"Logout"=>"user.php?a=logout");
	$menus['W'] = array("Home"=>"main.php",
						"New Analysis"=>"newAnalysis.php",
						"Past Analysis"=>"analysis.php",
						"Clients"=>"clients.php",
						"Logout"=>"user.php?a=logout");
	$menu['R'] = array("Home"=>"main.php",
						"Past Analysis"=>"analysis.php",
						"Logout"=>"user.php?a=logout");

	function get_header($msg = '', $print = false, $printMenu = true) {
		global $menus;
		$str = '<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<!--[if IE 7]>
		<link rel="stylesheet" href="css/font-awesome-ie7.min.css">
	<![endif]-->

	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	<script typ=e"text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
</head>
<body>
	<div id="pageWrapper">
		<div id="headerWrapper">
			<div id="header">
				<img src="http://placehold.it/100x100/" alt="Logo" />
				Mobile Header
				<div id="helpHeader">HelpHeader</div>
			</div>
		</div>';
		if ($printMenu) {
			$str .= '
			<div id="menuWrapper">
				<ul id="menu">';
			foreach($menus[$_SESSION['user']['Authentication']] as $name=>$link)
				$str .= "<a href=\"$link\"><li>$name</li></a>\n";
			$str .= '</ul>
			</div>';
		}
		$str .= '
		<div id="contentWrapper">
			<div id="infoBox">'.$msg.'</div>
			<div id="contentBox">
';

		if($print) echo $str;
		return $str;
	}

	function get_footer($print = false) {
		$str ="</div>\n";
		$str .= "\t\t\t</div>\n\t\t</div>
		<div id=\"footerWrapper\">
			footer here
		</div>
	</div>
</body>
</html>";


		if($print) echo $str;
		return $str;
	}