<?php
	// this is the cron job page for updating the solutions associated with users

	// setup some shit

	ini_set('max_execution_time', 0); //everready bunny, never allow script to timeout

	require_once("database.php");
	$db = getDBLink();

	//get all those users
	$users = $db->query("SELECT * FROM users");

	// update user loop
	while($user = $users->fetch_object()) {

		echo "Doing user $user->uhuntid '$user->name' <br />";

		// fetch data from uhunt api
		$scraped = json_decode(file_get_contents("http://uhunt.felix-halim.net/api/subs-user/$user->uhuntid"));

		foreach($scraped->subs as $sub) {
			// add any accepted answers to the database
			if($sub[2] == 90) {
				$problemId = $sub[1];
				$time = $sub[4];
				$lang = $sub[5];
				echo "Inserting accepted submission... <br />";
				print_r($sub);
				echo "<br />";
				//insert stuff into db ignoring any duplicates
				$db->query("INSERT IGNORE INTO solutions VALUES ('$user->uhuntid', '$problemId', '$lang', FROM_UNIXTIME($time))");
			}
		}

		echo "<br />";


	}
?>