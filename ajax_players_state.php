<?php
$players = explode(', ', $_POST['players']);
array_pop($players);

if(count($players) > 0){
	include 'stats_web_core/classes.php';
	$stats_global = new stats_global();

	echo json_encode($stats_global->get_players_state($players));
}
?>