<?php
	/**
	* User Class
	**/

	class User{
		public static $AUTH_LEVELS = array("R"=>"Read", "W"=>"Write", "M"=>"Moderator", "A"=>"Administrator");






		public static function randomString($length = 6) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++)
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			return $randomString;
		}
	}