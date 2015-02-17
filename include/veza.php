<?php
class DB_Instance {
	private static $db;

	public static function getDBO() {
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );
		if (!self::$db)
			self::$db = new PDO("mysql:host=localhost;dbname=ime_baze", "ime_korisnika", "lozinka", $options);

		return self::$db;
	}

}
?>