<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$players = explode(', ', $_POST['players']);
array_pop($players);

if(count($players) > 0){
	include 'stats_web_core/classes.php';
	$stats_global = new stats_global();

	echo json_encode($stats_global->get_players_state($players));
}
?>