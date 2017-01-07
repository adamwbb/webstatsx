<?php
//check if we only want to perform a syntax check
if(isset($_GET['c'])){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	include 'config.php';
	echo 'true';
	exit();
}

//--- vars to work with

//get the current url
$url = 'http';
if ($_SERVER["HTTPS"] == "on") {$url .= "s";}
$url .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
	$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
	$url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

//possible answers
$y = '<span class="label label-success">Yes</span>'; // yes
$n = '<span class="label label-important">No</span>'; // no
$u = '<span class="label label-info">Couldn\'t be checked</span>'; // unknown

//tables of the stats plugin
$tables = array('blocks_broken', 'death', 'kill', 'move', 'players');

//vars in the config
$config_vars = array('mysql_host', 'mysql_user', 'mysql_pass', 'mysql_db', 'mysql_encoding', 'prefix', 'show_avatars', 'show_online_state', 'server_ip', 'server_port', 'link_to_map', 'custom_links', 'enable_server_page');

//states of the check
$config_is_fine = false;
$connection_is_fine = false;
$all_tables_okay = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Minecraft WEBStatsX check</title>
	<link id="bs-css" href="css/bootstrap-spacelab.css" rel="stylesheet">
</head>
<body>
	<h1>Quick server check</h1>
	<table class="table table-bordered table-striped" style="width:auto;">
		<thead>
			<tr><th>Test</th><th>Result</th></tr>
		</thead>
		<tbody>
			<tr>
				<td>config.php exists?</td>
				<td>
					<?php
					if(file_exists('config.php')){
						echo $y;
						$config_is_fine = true;
					} else {
						echo $n;
					}
					?>
				</td>
			</tr>
			<tr>
				<td>No syntax errors in config?</td>
				<td>
					<?php
					$curl = curl_init($url.'?c=1');
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
					$curl_result = curl_exec($curl);
					curl_close($curl);

					if($curl_result == 'true'){
						echo $y;
					} else {
						echo $n.', the following error is reported:<br />'.$curl_result.'<br />The test will be stopped at this point, <b>please fix your config.php file!</b>';
						$config_is_fine = false;
					}
					?>
				</td>
			</tr>
			<?php
			if($config_is_fine){
				include 'config.php';

				//check if all vars are set
				foreach ($config_vars as $cv) {
					echo '<tr><td>Var $'.$cv.' is in config?</td><td>';
					if(isset(${$cv})){
						echo $y;
					} else {
						echo $n;
					}
					echo '</td></tr>';
				}

				// check the connection
				$mysqli = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

				echo '<tr><td>Connection to database?</td><td>';
				if (mysqli_connect_errno()) {
					echo $n.' -> '.mysqli_connect_error();
				} else {
					echo $y;
					$connection_is_fine = true;
				}
				echo '</td></tr>';


				if($connection_is_fine){
					foreach ($tables as $table) {
						echo '<tr><td>Table '.$prefix.$table.' exists?</td><td>';
						$res = mysqli_query($mysqli, 'SELECT 1 FROM '.$prefix.$table);
						if($res === false){
							$all_tables_okay = false;
							echo $n;
						} else {
							echo $y;
						}
						echo '</td></tr>';
					}
				}
			}
			?>
			</tbody>
		</table>
		<p>If you experience some errors, here are a few common solutions:</p>
		<ul>
			<li>The table prefix is wrong, try "stats_", "Stats_" or "Stats3_"</li>
			<li>There is a missing semicolon in the config.php file</li>
			<li>Some new settings have been added to the config during an update, please update your config</li>
		</ul>
	</body>
</html>