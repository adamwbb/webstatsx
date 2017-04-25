<?php
//uncomment to debug
//error_reporting(E_ALL);
ini_set('display_errors', '1');

abstract class stats_settings {
	public $prefix;
	public $mysqli;
	

	function __construct(){
		if(!(@include __dir__.'/../config.php')){
			exit('config.php could not be loaded! Check if you inserted all necessary data in the config_demo.php and renamed it to config.php!');
		}
		
		$this->prefix = $prefix;

		//connect to mysql, select correct db
		$this->mysqli = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
		//set charset of tables (sadly not utf-8)
		if (!mysqli_set_charset($this->mysqli, $mysql_encoding)){
			printf('Error loading character set %s: %s<br/>mysqli_real_escape_string() might not work proper.', $mysql_encoding, $this->mysqli->error);
		}
		
		//no connection? End everything!
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
}

class stats_players extends stats_settings {
	public $counter;
	public $players;
	public $playtime;
	public $arrows;
	public $xp_gained;
	public $joins;
	public $fish_caught;
	public $damage_taken;
	public $times_kicked;
	public $tools_broken;
	public $eggs_thrown;
	public $items_crafted;
	public $food_eaten;
	public $onfire;
	public $words_said;
	public $commands_done;
	public $last_join;
	public $last_seen;

	function __construct($players){
		parent::__construct();

		$res = mysqli_query($this->mysqli, 'SELECT * FROM '.$this->prefix.'players WHERE players = "'.mysqli_real_escape_string($this->mysqli, $players).'"');

		if(mysqli_num_rows($res) < 1){
			echo 'Error! No user with given uuid "'.$players.'"!';
			return NULL;
		} else {
			$row = mysqli_fetch_assoc($res);
			$this->counter = $row['counter'];
			$this->players = $row['players'];
			$this->playtime = $this->convert_playtime($row['timed_played']);
			$this->arrows = $row['arrows_shot'];
			$this->move = $row['distance_travelled'];
			$this->xp_gained = $row['xp_gained'];
			$this->joins = $row['joins'];
			$this->fish_caught = $row['fish_caught'];
			$this->damage_taken = $row['damage_taken'];
			$this->times_kicked = $row['times_kicked'];
			$this->tools_broken = $row['tools_broken'];
			$this->eggs_thrown = $row['eggs_thrown'];
			$this->items_crafted = $row['items_crafted'];
			$this->omnomnom = $row['food_eaten'];
			$this->onfire = $row['onfire'];
			$this->words_said = $row['words_said'];
			$this->commandsdone = $row['commands_done'];
			$this->last_join = $row['lastjoin'];
			$this->last_seen = $row['last_seen'];
			#new ones
			$this->votes = $row['votes'];
			$this->teleports = $row['teleports'];
			$this->items_picked_up = $row['items_picked_up'];
			$this->beds_entered = $row['beds_entered'];
			$this->buckets_filled = $row['buckets_filled'];
			$this->buckets_emptied = $row['buckets_emptied'];
			$this->times_changed_world = $row['times_changed_world'];
			$this->items_dropped = $row['items_dropped'];
			$this->shears = $row['shears'];
		}
	}

	public static function convert_playtime($pt){
		$days = floor($pt / 86400);
		$hours = floor(($pt - $days*86400) / 3600);
		$mins = floor(($pt - $hours*3600 - $days*86400) / 60);
		$secs = floor($pt - $hours*3600 - $days*86400 - $mins*60);
		return $days.'d:'.$hours.'h:'.$mins.'m:'.$secs.'s';
	}

	// moving
	public function get_movement($type = 0){
		if($type > 3 || $type < 0){
			return "Error! No movement of this type exists.";
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT value FROM '.$this->prefix.'move WHERE players = "'.$this->players.'" AND type = "'.$type.'"');
			$row = mysqli_fetch_assoc($res);

			if(mysqli_num_rows($res) < 1){
				return 0;
			} else {
				return $row['value'];
			}
		}
	}

	public function get_total_movement(){
		$res = mysqli_query($this->mysqli, 'SELECT SUM(value) as value FROM '.$this->prefix.'move WHERE players = "'.$this->players.'"');
		$row = mysqli_fetch_assoc($res);

		if(mysqli_num_rows($res) < 1){
			return 0;
		} else {
			return $row['value'];
		}
	}

	// deaths
	public function get_deaths($cause = NULL){
		if(empty($cause)){
			$res = mysqli_query($this->mysqli, 'SELECT SUM(value) as value FROM '.$this->prefix.'death WHERE players = "'.$this->players.'"');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT SUM(value) as value FROM '.$this->prefix.'death WHERE players = "'.$this->players.'" and cause = "'.$cause.'"');
		}

		$row = mysqli_fetch_assoc($res);
		//prevent a "return NULL"
		if($row['value'] > 0){
			return $row['value'];
		} else {
			return 0;
		}
	}

	public function get_all_deaths($top = NULL){
		if(empty($top)){
			$res = mysqli_query($this->mysqli, 'SELECT cause, value FROM '.$this->prefix.'death WHERE players = "'.$this->players.'"');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT cause, value FROM '.$this->prefix.'death WHERE players = "'.$this->players.'" ORDER BY value desc LIMIT 1');
		}
		
		if(mysqli_num_rows($res) <= 0){
			return array(array('NoDeaths', 1));
		}

		$return_arr = array();

		while($row = mysqli_fetch_assoc($res)){
				$return_arr[] = array($row['cause'], $row['value']);
		}

		return $return_arr;
	}


	// kills
	public function get_kills($type = NULL){
		if(empty($type)){
			$res = mysqli_query($this->mysqli, 'SELECT SUM(value) as value FROM '.$this->prefix.'kill WHERE players = "'.$this->players.'"');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT SUM(value) as value FROM '.$this->prefix.'kill WHERE players = "'.$this->players.'" AND type = "'.$type.'"');
		}

		$row = mysqli_fetch_assoc($res);
		//prevent a "return NULL"
		if($row['value'] > 0){
			return $row['value'];
		} else {
			return 0;
		}
	}

	public function get_all_kills($top = NULL){
		if(empty($top)){
			$res = mysqli_query($this->mysqli, 'SELECT type, value FROM '.$this->prefix.'kill WHERE players = "'.$this->players.'"');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT type, value FROM '.$this->prefix.'kill WHERE players = "'.$this->players.'" ORDER BY value desc LIMIT 1');
		}

		if(mysqli_num_rows($res) <= 0){
			return array(array('NoKills', 1));
		}

		$return_arr = array();

		while($row = mysqli_fetch_assoc($res)){
				$return_arr[] = array($row['entityType'], $row['value']);
		}

		return $return_arr;
	}

	//blocks
	public function get_all_blocks($res_type = NULL){
		$res = mysqli_query($this->mysqli, 'SELECT sbo.blockID, q1.value, q2.brk FROM (SELECT blockID FROM '.$this->prefix.'block WHERE players = "'.$this->players.'" GROUP BY blockID ORDER BY blockID asc) as sbo LEFT JOIN (SELECT blockID, SUM(value) as value FROM '.$this->prefix.'block WHERE players = "'.$this->players.'" AND break = 0 GROUP BY blockID ORDER BY blockID asc) as q1 ON sbo.blockID = q1.blockID LEFT JOIN (SELECT blockID, SUM(value) as brk FROM '.$this->prefix.'block WHERE players = "'.$this->players.'" AND break = 1 GROUP BY blockID ORDER BY blockID asc) as q2 ON sbo.blockID = q2.blockID');

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['blockID'], $row['value'], $row['brk']);
			}

			return $return_arr;
		}
		
	}
	
}

class stats_global extends stats_settings {
	private $gp_res = false;

	public function get_players($by = NULL, $order = NULL, $limit = NULL){
		if($this->gp_res === false){
			if(empty($order)){
				$s = 'ORDER BY playerName ';
			} else {
				$s = 'ORDER BY '.mysqli_real_escape_string($this->mysqli, $by).' ';
			}

			if(!empty($order)){
				$s .= mysqli_real_escape_string($this->mysqli, $order);
			} else {
				$s .= 'uuid';
			}

			if(!empty($limit)){
				$s .= ' LIMIT '.mysqli_real_escape_string($this->mysqli, $limit);
			}

			$this->gp_res = mysqli_query($this->mysqli, 'SELECT playerName FROM '.$this->prefix.'players '.$s);
		}

		if($row = mysqli_fetch_assoc($this->gp_res)){
		   	return new stats_players($row['playerName']);
		} else {
			$this->gp_res = false;
			return false;
		}
	}

	public function count_players(){
		$resource = mysqli_query($this->mysqli, 'SELECT COUNT(uuid) as uuid FROM '.$this->prefix.'joins');
		$count = mysqli_fetch_assoc($resource);
		return $count['uuid'];
	}

	public function get_total_distance_moved(){
		$res = mysqli_query($this->mysqli, 'SELECT SUM(value) as value FROM '.$this->prefix.'distance_travelled');
		$row = mysqli_fetch_assoc($res);
		return $row['value'];
	}

	public function get_total_kills(){
		$res = mysqli_query($this->mysqli, 'SELECT SUM(value) as value FROM '.$this->prefix.'kills_players');
		$row = mysqli_fetch_assoc($res);
		return $row['value'];
	}

	public function get_total_deaths(){
		$res = mysqli_query($this->mysqli, 'SELECT SUM(value) as value FROM '.$this->prefix.'deaths');
		$row = mysqli_fetch_assoc($res);
		return $row['value'];
	}

	public function get_kill_average(){
		$res = mysqli_query($this->mysqli, 'SELECT AVG(sk1.sumam) as value FROM (SELECT SUM(value) as sumam FROM '.$this->prefix.'kill GROUP BY players) as sk1');

		$row = mysqli_fetch_assoc($res);
		return $row['value'];
	}

	public function get_death_average(){
		$res = mysqli_query($this->mysqli, 'SELECT AVG(sk1.sumam) as value FROM (SELECT SUM(value) as sumam FROM '.$this->prefix.'death GROUP BY players) as sk1');

		$row = mysqli_fetch_assoc($res);
		return $row['value'];
	}


	// top functions
	public function get_top_players_move($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'move GROUP BY players ORDER BY value desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'move GROUP BY players ORDER BY value desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['uuid'], $row['value']);
			}

			return $return_arr;
		}
	}

	public function get_top_players_kill($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'kill GROUP BY players ORDER BY value desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'kill GROUP BY players ORDER BY value desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['uuid'], $row['value']);
			}

			return $return_arr;
		}
	}

	public function get_top_players_death($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'deaths GROUP BY players ORDER BY value desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'deaths GROUP BY players ORDER BY value desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['uuid'], $row['value']);
			}

			return $return_arr;
		}
	}

	public function get_top_players_blocks_placed($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'blocks_placed = 0 GROUP BY players ORDER BY value desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'blocks_placed = 0 GROUP BY players ORDER BY value desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['uuid'], $row['value']);
			}

			return $return_arr;
		}
	}

	public function get_top_players_blocks_broken($res_type = NULL, $limit = NULL){
		if(empty($limit) || !is_integer($limit)){
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'blocks_broken = 1 GROUP BY players ORDER BY value desc');
		} else {
			$res = mysqli_query($this->mysqli, 'SELECT players, SUM(value) as value FROM '.$this->prefix.'blocks_broken = 1 GROUP BY players ORDER BY value desc LIMIT '.$limit);			
		}

		if($res_type == 'mysql'){
			return $res;
		} else {
			$return_arr = array();

			while($row = mysqli_fetch_assoc($res)){
					$return_arr[] = array($row['uuid'], $row['value']);
			}

			return $return_arr;
		}
	}


	public function get_players_state($players_list){
		$query = '';
		$return_arr = array();

		foreach ($players_list as $players) {
			$query .= 'players = "'.$players.'" OR ';
		}

		$res = mysqli_query($this->mysqli, 'SELECT players, last_join, last_seen FROM '.$this->prefix.'players WHERE '.substr($query, 0, -4));
		while($row = mysqli_fetch_assoc($res)){
			if(strtotime($row['last_join']) > strtotime($row['last_seen'])){
				$return_arr[$row['players']] = 1;
			} else {
				$return_arr[$row['players']] = 0;			
			}
		}

		return $return_arr;
	}
}


class bonus_methods {

	public $page_title;
	public $header_title;
	public $top_limit;

	public $map_link;
	public $tmotd;
	public $tmotd_headline;
	public $custom_links;
	public $enable_server_page;
	public $show_avatars;
	public $show_online_state;

	private $server_port;
	private $server_ip;
	public $max_players;
	public $online_players;

	function __construct(){
		//include __dir__.'/../config_bonus.php';
		include __dir__.'/../config.php';

		//$this->tmotd = $motd;
		//$this->tmotd_headline = $motd_headline;

		$this->page_title = empty($page_title) ? 'WEBStatsX Reloaded' : $page_title;
		$this->header_title = empty($header_title) ? 'WEBStatsX Reloaded' : $header_title;
		$this->top_limit = empty($top_limit) || !is_int($top_limit) ? 10 : $top_limit;

		if(empty($link_to_map) || $link_to_map == ''){
			$this->map_link = '#';
		} else {
			$this->map_link = $link_to_map;
		}

		if($show_avatars == false){
			$this->show_avatars = 0;
		} else {
			$this->show_avatars = 1;
		}

		if($show_online_state == false){
			$this->show_online_state = 0;
		} else {
			$this->show_online_state = 1;
		}
		
		$this->custom_links = $custom_links;
		$this->server_ip = $server_ip;
		$this->server_port = $server_port;
		$this->enable_server_page = $enable_server_page;
	}

	public function get_custom_links(){
		$links = $this->custom_links;
		$prepared_links = "";
		foreach ($links as $uuid => $url) {
			$prepared_links .= "<li><a href='". $url ."'><i class='icon-arrow-left'></i><span class='hidden-tablet'> ". $uuid ."</span></a></li>" ;
		}
		return $prepared_links;
	}

	public function check_server(){
		if(empty($this->server_ip)){
			return false;
		}

		if ($sock = stream_socket_client('tcp://'.$this->server_ip.':'.$this->server_port, $errno, $errstr, 1)){

			fwrite($sock, "\xfe\x01");
			$data = fread($sock, 1024);
			fclose($sock);

			if($data == false AND substr($data, 0, 1) != "\xFF"){
				return false;
			}

			$data = substr($data, 9);
			$data = mb_convert_encoding($data, 'auto', 'UCS-2');
			$data = explode("\x00", $data);
			
			$this->online_players = (int) $data[3];
			$this->max_players = (int) $data[4];
			return true;

		} else {
			return false;
		}
	}

	public function get_map(){
		if($this->map_link == '#'){
			return '<div class="alert alert-info"><strong>No map!</strong> There is no link to a map in the config, so I can\'t include one. :(</div>';
		} else {
			return '<div id="map_frame"><iframe seamless="seamless" style="width:100%;height:100%;" src="'.$this->map_link.'"></iframe></div>';
		}
	}

	public function get_motd(){
		if(!empty($this->tmotd)){
			return '<div class="row-fluid"><div class="box span12"><div class="box-header well"><h2><i class="icon-info-sign"></i> Motd</h2><div class="box-icon"><a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a><a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a></div></div><div class="box-content"><h1>'.$this->tmotd_headline.'</h1>'.$this->tmotd.'<div class="clearfix"></div></div></div></div>';
		}
	}
}
?>