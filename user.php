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
	if (isset($_GET['a']) ){
		if($_GET['a'] == "logout") {
			session_destroy();
			unset($_SESSION);
			$msg = "<div class=\"success\">Logout Successful!</div><META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2; URL=index.php\" />\n";
			$lo = true;
		}elseif($_GET['a'] == "new"){
			if($_SESSION['user']['Authentication'] == 'A') {
				//Validate information
				$row = SingletonDB::multiQuery("SELECT UserID FROM Users WHERE UserID = '%s';", $_POST['new_userid']);
				if( count($row) > 0 ) {
					$msg = "<div class=\"error\">Duplicate UserID. User not created.</div>\n";
				}else{
					//Create the user
					$salt = User::randomString(6);
					SingletonDB::multiQuery("INSERT INTO Users(UserID, Password, Salt, Firstname, Lastname, Authentication)VALUES('%s', '%s', '%s', '%s', '%s', '%s');",
											$_POST['new_userid'], MD5($_POST['new_password'].$salt), $salt, $_POST['new_firstname'], $_POST['new_lastname'], $_POST['new_authentication']);
					$msg = "<div class=\"success\">User created!</div>\n";
				}
			}else
				$msg = "<div class=\"error\">You can't do this!</div>\n";
		}elseif($_GET['a'] == "changePassword") {
			//Check Auth
			$changeID = substr(key($_POST), 0, strpos(key($_POST), '_'));
			if( $_SESSION['user']['Authentication'] == 'A' || $_SESSION['user']['userid'] == $changeID ) {
				SingletonDB::multiQuery("UPDATE Users SET Password = MD5(CONCAT('%s', Salt)) WHERE UserID = '%s';", current($_POST), $changeID );
				$msg = "<div class=\"success\">Password Changed!</div>\n";
			}else
				$msg = "<div class=\"error\">You can't do this!</div>\n";
		}
		elseif($_GET['a'] == "delete") {
			if( $_SESSION['user']['Authentication'] == 'A') {
				if( $_GET['userID'] != $_SESSION['user']['UserID'] && $_GET['userID'] != '%' ) {
					SingletonDB::multiQuery("DELETE FROM Users WHERE UserID = '%s';", $_GET['userID']);
					$msg = "<div class=\"success\">User deleted!</div>\n";
				}else
					$msg = "<div class=\"error\">You can't delete yourself!</div>\n";
			}else
				$msg = "<div class=\"error\">You can't do this!</div>\n";
		}
	}

	//Display Code
	$search = $_SESSION['user']['UserID'];
	if ($_SESSION['user']['Authentication'] == 'A')
		$search = '%';

	$users = SingletonDB::multiQuery("SELECT UserID, Firstname, Lastname, Authentication FROM Users WHERE UserID LIKE '$search';");
?>
<?php get_header('', !$lo); ?>
			<div id="infoBox"><?=$msg?></div>
			<div id="welcomeBox">
				<h2>New Analysis</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus consectetur nunc sed lectus porttitor, eu placerat magna ultricies. Quisque nunc lacus,
					tempus eu bibendum nec, fermentum at velit. Vivamus nisl nibh, bibendum vitae est vel, sollicitudin euismod nisl. Vestibulum dictum mauris eget nisi laoreet iaculis.</p>
			</div>
			<div>
				<table id="userTable" class="bigTable">
					<tr>
						<th>UserID</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Auth. Level</th>
						<th>New Password</th>
						<th>&nbsp;</th>
					</tr>
				<?php
					foreach($users as $user) {
						echo "\t<form method=\"POST\" action=\"user.php?a=changePassword\" name=\"". $user['UserID'] ."_changeForm\" id=\"". $user['UserID'] ."_changeForm\">\n";
						echo "<tr>\n\t<td>". $user['UserID'] ."</td><td>". $user['Firstname'] ."</td><td>". $user['Lastname'] ."</td>\n";
						echo "<td>". USER::$AUTH_LEVELS[$user['Authentication']] ."</td>\n";

						//ChangePass
						echo "\t\t<td><input type=\"text\" name=\"". $user['UserID'] ."_newPass\" placeholder=\"Change Password\" /></td>\n";
						echo "\t\t<td><i class=\"icon-pencil\" onClick=\"\$('#". $user['UserID'] ."_changeForm').submit()\"></i>\n";

						if ($_SESSION['user']['Authentication'] == 'A') {
							echo "<i class=\"icon-remove\" onClick=\"window.location = 'user.php?a=delete&userID=". $user['UserID'] ."';\"></i>\n";
						}
						echo "</td>\n</tr>\n";
						echo "\t</form>\n";
					}

					// New form
					if ($_SESSION['user']['Authentication'] == 'A') {
						echo "<form name=\"newUser\" id=\"newUserForm\" action=\"user.php?a=new\" method=\"POST\">\n";
						echo "<tr>
								<td><input type=\"text\" name=\"new_userid\" placeholder=\"UserID\"></td>
								<td><input type=\"text\" name=\"new_firstname\" placeholder=\"First Name\" /></td>
								<td><input type=\"text\" name=\"new_lastname\" placeholder=\"Last Name\" /></td>
								<td><select name=\"new_authentication\">";
						foreach(USER::$AUTH_LEVELS as $code=>$level)
							echo "<option value=\"". $code ."\">". $level ."</option>\n";
						echo "</select></td>
								<td><input type=\"text\" name=\"new_password\" placeholder=\"Password\" /></td>
								<td><i class=\"icon-ok\" onClick=\"\$('#newUserForm').submit()\"></i>
							</tr>\n";
						echo "</form>\n";
					}

				?>
				</table>
			</div>
<?php get_footer(true) ?>