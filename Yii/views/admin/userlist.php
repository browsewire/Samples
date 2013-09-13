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
					<li><a href="#">Users</a>
					</li>
				</ul>
			</div>
		</div>
		<br>
		
		<div class="row-fluid">
			<div class="span12">
				<div class="widget">
					<div class="widget-body well" style="margin: 0">
						<div class="input-append">
							<form action="<?php echo Yii::app()->baseUrl; ?>/admin/getEmail"
								method="POST">
								<input class="span6" id="appendedInputButton" name="email"
									type="text" placeholder="search for user by email">
								<button class="btn" id="getEmaillist" type="submit">Search!</button>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
		
		<h4>Users</h4>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget no-margin">
					<div class="widget-header">
						<div class="title">
							<span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>
							<?php 
							if(isset($_POST['inputDAtes'])){
						echo $_POST['inputDAtes'];
					} else {
                    echo date("d F Y");
				    }

				    ?>
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
									<?php foreach($userData as $userData){?>
									<tr>
										<td><a
											href="<?php echo Yii::app()->baseUrl."/admin/edituser/".$userData['id'] ;?>"><?php echo $userData['first_name']." ".$userData['last_name'] ;?>
										</a></td>
										<td><?php echo $userData['region']; ?></td>
										<td><?php echo $userData['country']; ?></td>
										<td><?php echo $userData['custom_msg']; ?></td>
										<td><?php if($userData['status']=="Registered"){?> <span
											class="badge badge-info"> Registered </span> <?php } elseif($userData['status']=="Claimed"){?>
											<span class="badge badge-success"> Claimed </span> <?php } elseif($userData['status']=="Rejected"){?>
											<span class="badge badge-important"> Rejected </span> <?php } ?>
										</td>

									</tr>
									<?php } ?>

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




<!-- for searching data of users through email -->
<script
	type="text/javascript"
	src="<?php echo Yii::app()->baseUrl; ?>/js/jquerysearch/jquery-1.4.2.min.js"></script>
<script
	type="text/javascript"
	src="<?php echo Yii::app()->baseUrl; ?>/js/jquerysearch/jquery-ui-1.8.2.custom.min.js"></script>
<link
	rel="stylesheet"
	href="<?php echo Yii::app()->baseUrl; ?>/css/smoothness/jquery-ui-1.8.2.custom.css" />

<script>   
	jQuery(document).ready(function($){
		$('#appendedInputButton').autocomplete({source:'<?php echo Yii::app()->baseUrl; ?>/admin/searchEmail',minLength:1});
	});
	
</script>
<!-- for searching data of users through email -->


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
