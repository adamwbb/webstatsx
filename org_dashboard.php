<?php
include('header.php');
?>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Dashboard</a>
					</li>
				</ul>
			</div>
			<div class="row-fluid">
				<a data-rel="tooltip" title="Take me to the player tables!" class="well span3 top-block ajax-link" href="players.php">
					<span class="icon32 icon-color icon-users"></span>
					<div>Number of players with stats</div>
					<div><?php echo $stats_global->count_players(); ?></div>
				</a>

				<a data-rel="tooltip" title="Take me to the top travelers!." class="well span3 top-block ajax-link" href="top_distance.php">
					<span class="icon32 icon-color icon-sent"></span>
					<div>Total distance traveled by players</div>
					<div><?php echo number_format($stats_global->get_total_distance_moved(), 2, '.', ''); ?></div>
				</a>

				<a data-rel="tooltip" title="Take me to the top killers!" class="well span3 top-block ajax-link" href="#">
					<span class="icon32 icon-green icon-arrowthick-n"></span>
					<div>Total kills by players</div>
					<div><?php echo $stats_global->get_total_kills(); ?></div>
				</a>
				
				<a data-rel="tooltip" title="Take me to the top dying players list!" class="well span3 top-block ajax-link" href="#">
					<span class="icon32 icon-red icon-arrowthick-s"></span>
					<div>Total deaths of players</div>
					<div><?php echo $stats_global->get_total_deaths(); ?></div>
				</a>
			</div>

			<div class="row-fluid sortable">
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 8 players by time</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content" style="min-height: 350px;">
						<table class="table table-striped table-bordered" id="table_top_time">
						  <thead>
							  <tr>
								  <th>Username</th>
								  <th>Playtime</th>
								  <th>Joins</th>
							  </tr>
						  </thead>
						  <tbody>
						  	<?php
							while ($player = $stats_global->get_players('playtime', 'desc', 8)){
            					echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$player->player.'">'.$player->player.'</a></td>';
            					echo '<td>'.$player->playtime.'</td>';
            					echo '<td>'.$player->joins.'</td>';
            				}
							?>							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->

				<div class="box span6">
					<div class="box-header well">
						<h2><i class="icon-picture"></i> Map</h2>
						<div class="box-icon">
							<a href="<?php echo $bonus_methods->map_link; ?>" class="btn btn-round"><i class="icon-share"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php echo $bonus_methods->get_map(); ?>
					</div>
				</div>
			</div><!--/row-->
			
			<?php echo $bonus_methods->get_motd(); ?>

<?php include('footer.php'); ?>