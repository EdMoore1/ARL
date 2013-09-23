<?php
	/*
	 *	Std Header
	*/
	session_start();
	foreach(glob('classes/*') as $classURI)
		include($classURI);
	$msg = "";
	if (!isset($_SESSION['logged']) || !$_SESSION['logged'])
		die("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=index.php\" />");
?>
<?php get_header('', true) ?>
			<div id="messageBox"><?=$msg?></div>
			<div id="welcomeBox"></div>
<?php get_footer(true) ?>