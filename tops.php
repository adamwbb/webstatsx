<?php include('header.php'); ?>

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php" class="ajax-link">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Top's</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid">		
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 travellers</h2>
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
									<th>Total distance</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$players = $stats_global->get_top_players_move('mysql', 10);
							while ($row = mysqli_fetch_row($players)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 killers</h2>
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
									<th>Total kills</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$players = $stats_global->get_top_players_kill('mysql', 10);
							while ($row = mysqli_fetch_row($players)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 deaths</h2>
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
									<th>Total deaths</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$players = $stats_global->get_top_players_death('mysql', 10);
							while ($row = mysqli_fetch_row($players)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
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
						<h2><i class="icon-user"></i> Top 10 builders</h2>
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
									<th>Total blocks placed</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$players = $stats_global->get_top_players_blocks_placed('mysql', 10);
							while ($row = mysqli_fetch_row($players)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 miners</h2>
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
									<th>Total blocks brocken</th>
								</tr>
							</thead>
							<tbody>
						 	<?php
						 	$players = $stats_global->get_top_players_blocks_broken('mysql', 10);
							while ($row = mysqli_fetch_row($players)){
								echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$row[0].'">'.$row[0].'</a></td>';
								echo '<td>'.$row[1].'</td></tr>';
							}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Top 10 players</h2>
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
							while ($players = $stats_global->get_players('playtime', 'name', 8)){
            					echo '<tr><td><a class="ajax-link" href="single_player.php?p='.$playerss->players.'">'.$playerss->players.'</a></td>';
            					echo '<td>'.$players->playtime.'</td>';
            					echo '<td>'.$players->joins.'</td>';
            				}
							?>							
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
    
<?php include('footer.php'); ?>
