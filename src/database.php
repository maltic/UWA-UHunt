<?php
	// an extremely hacky way to modularize database access
	// good enough for such a small app though
	function getDBLink() {
		$host = "YOUR HOST";
		$user = "YOUR USER NAME";
		$password = "YOUR PASSWORD";
		$database = "YOUR DATABASE";
		return new mysqli($host, $user, $password, $database);
	}
?>