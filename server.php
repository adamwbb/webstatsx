<?php include('header.php'); ?>

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php" class="ajax-link">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Server</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-hdd"></i> Server statistics [beta]</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<?php
						//Get uptime and load average
						//$data = explode(' ', shell_exec('uptime'));

						$cores = shell_exec("cat /proc/cpuinfo | grep processor | wc -l");
						echo '<!-- cores found on system: '.$cores.' -->';
						$load = sys_getloadavg();
						foreach ($load as $k => $v) {
							if($cores == 0){
								$load[$k] = '<span class="label label-info">'.$v.'</span>';
							} elseif($v > $cores){
								$load[$k] = '<span class="label label-important">'.$v.'</span>';
							} else {
								$load[$k] = '<span class="label label-success">'.$v.'</span>';
							}
						}
						echo '<p>Server load last minute: '.$load[0].'</p>';
						echo '<p>Server load last five minutes: '.$load[1].'</p>';
						echo '<p>Server load last 15 minutes: '.$load[2].'</p>';


						$uptime = explode(' ', exec("cat /proc/uptime r"));

						echo '<p>Machine up since: '.Stats3_players::convert_playtime($uptime[0]).'</p>';
						echo '<p>Total idle time: '.Stats3_players::convert_playtime($uptime[1]).'</p>';


						/*
						foreach ($data as $key => $value) {
							$data[$key] = trim($value);
							if($data[$key] == ''){ unset($data[$key]); }
						}

						echo 'System time: '.$data[1].'<br />';
						echo 'Up since: '.substr($data[4], 0, -1).' h'.'<br />';
						echo 'Load average during last minute: '.$data[11].'%'.'<br />';
						echo 'Load average during last 5 minutes: '.$data[12].'%'.'<br />';
						echo 'Load average during last 15 minutes: '.$data[13].'%'.'<br />'.'<br />';
						*/


						//Get the RAM usage of the java process
						$ram_usage = shell_exec('total=0; for i in `ps -C java -o rss=`; do total=$(($total+$i)); done; echo "$(($total/1024))"');
						echo '<p>RAM Usage of the java process (most likely the minecraft server): '.$ram_usage.' MB</p>';
						?>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
    
<?php include('footer.php'); ?>