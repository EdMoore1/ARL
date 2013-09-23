<?php
	/**
	* Database Class
	**/

	/* Initialisation */
	SingletonDB::Connect();

	class SingletonDB{
		static $db;

		private static $MYSQL_HOST = "mysql.eddyswebdesign.com";
		private static $MYSQL_USER = "comp355_arl";
		private static $MYSQL_PASS = "75N169T284p8751";
		private static $MYSQL_DB   = "comp355_arl";

		private function __construct() { }
		public static function Connect() {
			self::$db = @(mysqli_connect(self::$MYSQL_HOST, self::$MYSQL_USER, self::$MYSQL_PASS, self::$MYSQL_DB));
			if (!is_object(self::$db))
				trigger_error("Failed to connect the database.", E_USER_ERROR);
			if (self::$db->connect_error) die('Connect Error (' . self::$db->connect_errno . ') ' . self::$db->connect_error);
		}

		public static function multiQuery ($query) {

			if (!isset(self::$db))
				self::Connect();

			for($i = 1; $i < func_num_args(); $i++) {
				$tmp = self::$db->real_escape_string(func_get_arg($i));
				$query = preg_replace('/%s/', $tmp, $query, 1);
			}

			$result = self::$db->query($query);
			if (self::$db->error) die("SQL Error: ". self::$db->error);
			$arr = array();

			if($result === true)
				return $arr;

			if($result->num_rows > 0)
				while($row = $result->fetch_assoc())
					array_push($arr, $row);
			return $arr;
		}	
	}