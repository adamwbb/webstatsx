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
				<a class="well span3 top-block" href="players.php">
					<span class="icon32 icon-color icon-users"></span>
					<div>Number of players tracked</div>
					<div><?php echo $stats_global->count_players(); ?></div>
				</a>

				<a class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-sent"></span>
					<div>Total distance travelled </div>
					<div><?php echo number_format($stats_global->get_total_distance_moved(), 2, '.', ''); ?></div>
				</a>

				<a class="well span3 top-block" href="#">
					<span class="icon32 icon-green icon-arrowthick-n"></span>
					<div>Total kills</div>
					<div><?php echo $stats_global->get_total_kills(); ?></div>
				</a>
				
				<a class="well span3 top-block" href="#">
					<span class="icon32 icon-red icon-arrowthick-s"></span>
					<div>Total deaths</div>
					<div><?php echo $stats_global->get_total_deaths(); ?></div>
				</a>
			</div>
			
			<div class="row-fluid">		
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top <?=$bonus_methods->top_limit?> travellers</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Distance</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
							$player = $stats_global->get_top_players_move('mysql', $bonus_methods->top_limit);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td class="p_name"><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.number_format($row[1], 2, '.', '').'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top <?=$bonus_methods->top_limit?> killers</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Kills</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
							$player = $stats_global->get_top_players_kill('mysql', $bonus_methods->top_limit);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td class="p_name"><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top <?=$bonus_methods->top_limit?> deaths</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Deaths</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
							$player = $stats_global->get_top_players_death('mysql', $bonus_methods->top_limit);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td class="p_name"><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->


			<!-- row 2 -->
			<div class="row-fluid">		
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top <?=$bonus_methods->top_limit?> builders</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Blocks placed</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
							$player = $stats_global->get_top_players_blocks_placed('mysql', $bonus_methods->top_limit);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td class="p_name"><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top <?=$bonus_methods->top_limit?> mining</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Blocks broken</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
							$player = $stats_global->get_top_players_blocks_broken('mysql', $bonus_methods->top_limit);
							while ($row = mysqli_fetch_row($player)){
								echo '<tr><td class="p_name"><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top <?=$bonus_methods->top_limit?> players</h2>
						<!--
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
						-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th>Username</th>
								  <th>Playtime</th>
								  <th>Joins</th>
							  </tr>
						  </thead>
						  <tbody>
						  	<?php
							while ($player = $stats_global->get_players('playtime', 'desc', $bonus_methods->top_limit)){
								echo '<tr><td  class="p_name"><a class="ajax-link" href="single_player.php?p='.$player->player.'">'.$player->player.'</a></td>';
            					echo '<td>'.$player->playtime.'</td>';
            					echo '<td>'.$player->joins.'</td>';
            				}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<?php include('footer.php'); ?>
