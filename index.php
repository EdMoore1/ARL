<?php
	/*
	 *	Std Header
	*/
	session_start();
	foreach(glob('classes/*') as $classURI)
		include($classURI);
	$msg = "";
	if( isset($_POST['user']) && isset($_POST['pass'])){
		//Check login
		$row = reset(SingletonDB::multiQuery("SELECT UserID, Firstname, Lastname, Authentication FROM Users WHERE UserID = '%s' AND Password = MD5(CONCAT('%s', Salt));", $_POST['user'], $_POST['pass']));

		if (!empty($row)) {
			$msg = "<div class=\"success\">Login Successful</div><META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2; URL=". ROOT ."/main.php\">\n";
			$_SESSION['user'] = $row;
			$_SESSION['logged'] = true;
		}else{
			$msg = "<div class=\"error\">Invalid Username/Password</div>\n";
		}
	}
?>
<?php get_header($msg, true, false) ?>
			<div id="loginForm" class="bigForm">
				<form method="post" action="<?=ROOT?>/" name="loginForm">
					<input type="text" name="user" id="user" placeholder="Username" />
					<input type="password" name="pass" id="pass" placeholder="Password" />
					<input type="submit" value="Login" />
				</form>
			</div>
			<div id="forgotBox" class="filler">
				<div>
					<a href="#">Forgot your Username</a>
					<a href="#">Forgot your password?</a>
				</div>
			</div>
<?php get_footer(true) ?>