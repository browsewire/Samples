<div class="dashboard-wrapper">
	<div class="main-container">
		<div class="navbar hidden-desktop">
			<div class="navbar-inner">
				<div class="container">
					<a data-target=".navbar-responsive-collapse" data-toggle="collapse"
						class="btn btn-navbar"> <span class="icon-bar"> </span> <span
						class="icon-bar"> </span> <span class="icon-bar"> </span>
					</a>
					<div class="nav-collapse collapse navbar-responsive-collapse">
						<ul class="nav">
							<li><a
								href="<?php echo Yii::app()->request->baseUrl; ?>/admin/dashboard">Dashboard</a>
							</li>
							<li><a
								href="<?php echo Yii::app()->request->baseUrl; ?>/admin/userlist">Users</a>
							</li>
							<li><a
								href="<?php echo Yii::app()->request->baseUrl; ?>/admin/userslanding">Bulk
									Email</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span12">
				<ul class="breadcrumb-beauty">
					<li><a href="index.html"><span class="fs1" aria-hidden="true"
							data-icon="&#xe002;"></span> Dashboard</a>
					</li>
					<li><a href="#">Users</a>
					</li>
				</ul>
			</div>
		</div>
		<br>
		
		<h4>Users</h4>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget no-margin">
					<div class="widget-header">
						<div class="title">
							<span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>
							18 May 2013
						</div>
					</div>
					<div class="widget-body">
						<div id="dt_example" class="example_alt_pagination">
							<table
								class="table table-condensed table-striped table-hover table-bordered pull-left"
								id="data-table">
								<thead>
									<tr>
										<th>Name</th>
										<th>State</th>
										<th>Country</th>
										<th>Custom Message</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><a href="#">Srinu Basava</a></td>
										<td>NSW</td>
										<td>AU</td>
										<td>Messi</td>
										<td><span class="badge badge-success"> Claimed </span>
										</td>
									</tr>
									<tr>
										<td><a href="#">Srinu Basava</a></td>
										<td>NSW</td>
										<td>AU</td>
										<td>Messi</td>
										<td><span class="badge badge-important"> Rejected </span>
										</td>
									</tr>
									<tr>
										<td><a href="#">Srinu Basava</a></td>
										<td>NSW</td>
										<td>AU</td>
										<td>Messi</td>
										<td><span class="badge badge-info"> Registered </span>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- js for usersearch page -->

<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/admin/jquery.min.js"></script>
<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/admin/bootstrap.js"></script>
<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/admin/jquery.dataTables.js"></script>
<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/admin/jquery.sparkline.js"></script>

<!-- Custom Js -->
<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/admin/custom-tables.js"></script>
<script
	src="<?php echo Yii::app()->baseUrl; ?>/js/admin/custom.js"></script>
