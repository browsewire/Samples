<script>
	$(document).ready(function() 
	{
   		$('#export-button').on('click',function() { //alert("hi");
   		});
	
	});
</script>
<style>
.datesubmit {
	background: none repeat scroll 0 0 transparent;
	border: medium none;
	cursor: pointer;
	text-decoration: underline;
}
</style>
<div class="dashboard-wrapper">
	<div class="main-container">
		<div class="navbar hidden-desktop">
			<div class="navbar-inner">
				<div class="container">
					<a data-target=".navbar-responsive-collapse" data-toggle="collapse"
						class="btn btn-navbar"> <span class="icon-bar"></span> <span
						class="icon-bar"></span> <span class="icon-bar"></span>
					</a>
					<div class="nav-collapse collapse navbar-responsive-collapse">
						<ul class="nav">
							<li><a
								href="<?php echo Yii::app()->request->baseUrl; ?>/admin/dashboard">Dashboard</a>
							</li>
							<li><a
								href="<?php echo Yii::app()->request->baseUrl; ?>/admin/usersearch">Users</a>
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
					<li><a
						href="<?php echo Yii::app()->request->baseUrl; ?>/admin/dashboard"><span
							class="fs1" aria-hidden="true" data-icon="&#xe002;"></span>
							Dashboard</a>
					</li>
				</ul>
			</div>
		</div>

		<br>

		<div class="row-fluid">
			<div class="span6">
				<div class="plain-header">
					<h4 class="title">Current Sales Status</h4>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<div class="widget widget-border">
							<div class="widget-body">
								<div class="current-stats">
									<h4 class="text-warning">
										<?php if($userRegistered){ 
											foreach($userRegistered as $userRegistered){
echo $userRegistered['m'];
}
										}?>
									</h4>
									<p>Registrations</p>
									<div class="type">
										<span class="fs1 arrow text-warning" aria-hidden="true"
											data-icon="&#xe070;"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="span3">
						<div class="widget less-bottom-margin widget-border">
							<div class="widget-body">
								<div class="current-stats">
									<h4 class="text-error">
										<?php if($userClaimed){ 
											foreach($userClaimed as $userClaimed){
echo $userClaimed['m'];
}
										}?>
									</h4>
									<p>Claimed</p>
									<div class="type">
										<span class="fs1 arrow text-error" aria-hidden="true"
											data-icon="&#xe0c6;"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="span3">
						<div class="widget widget-border">
							<div class="widget-body">
								<div class="current-stats">
									<h4 class="text-info">
										<?php echo $userFbShare['fbshare']; ?>
									</h4>
									<p>Facebook shares</p>
									<div class="type">
										<span class="fs1 arrow text-info" aria-hidden="true"
											data-icon="&#xe071;"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="span3">
						<div class="widget widget-border">
							<div class="widget-body">
								<div class="current-stats">
									<h4>26</h4>
									<p>Rejected</p>
									<div class="type">
										<span class="fs1 arrow" aria-hidden="true"
											data-icon="&#xe0fa;"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span12">
				<div class="widget">
					<div class="widget-header">
						<div class="title">
							<span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>
							Latest Activity
						</div>
					</div>
					<div class="widget-body">
						<table
							class="table table-condensed table-striped table-bordered table-hover no-margin">
							<thead>
								<tr>
									<th style="width: 25%">Date</th>
									<th style="width: 20%">Registrations</th>
									<th style="width: 20%" class="hidden-phone">Claimed</th>
									<th style="width: 20%" class="hidden-phone">Facebook Shares</th>
									<th style="width: 15%" class="hidden-phone">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($userRegDate as $userRegDate){?>
								<tr>
									<td><span class="chart" id="unique-visitors"> <!-- for getting input date for getting data accordingly -->
											<form
												action="<?php echo Yii::app()->request->baseUrl; ?>/admin/userlist/"
												method="POST" style="margin: 0 0 0px;">
												<?php $dates = date("d F Y",strtotime($userRegDate['date'])); ?>
												<input type="hidden" value="<?php echo $dates;?>"
													name="inputDAtes">
												<button class="datesubmit" id="" type="submit">
													<?php echo date("d F Y",strtotime($userRegDate['date'])); ?>
												</button>
											</form> <!-- for getting input date for getting data accordingly -->
											<!--  <a href=""> <?php //echo date("d F Y",strtotime($userRegDate['date'])); ?></a>-->
									</span>
									</td>
									<td><?php echo $userRegDate['registered']; ?>
									</td>
									<td class="hidden-phone"><?php echo $userRegDate['claimed']; ?>
									</td>
									<td class="hidden-phone"><?php echo $userRegDate['shared']; ?>
									</td>
									<td class="hidden-phone"><?php $da = date("d F Y",strtotime($userRegDate['date'])); ?>

										<!-- for getting input date for getting data to export accordingly -->
										<form
											action="<?php echo Yii::app()->request->baseUrl; ?>/admin/export/"
											method="POST" style="margin: 0 0 0px;">
											<input type="hidden" value="<?php echo $da;?>"
												name="dateDAta">
											<button class="btn btn-success btn-small hidden-phone" id=""
												type="submit">Export</button>
										</form> <!-- for getting input date for getting data accordingly -->
									</td>
								</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- dashboard-container -->


