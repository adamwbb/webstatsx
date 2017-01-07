<?php include('header.php'); ?>

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php" class="ajax-link">Dashboard</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Players</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Players</h2>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable ajax-datatable">
							<thead>
								<tr>
									<th>Username</th>
									<th>Playtime</th>
									<th>Last join</th>
									<th>EXP gained</th>
									<th>Damage taken</th>
									<th>Kicked</th>
									<th>Items crafted</th>
								</tr>
							</thead>
							<tbody>	
							</tbody>
						</table>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<?php include('footer.php'); ?>