

<div
	class="dashboard-wrapper">
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
					<li><a
						href="<?php echo Yii::app()->request->baseUrl; ?>/admin/dashboard"><span
							class="fs1" aria-hidden="true" data-icon="&#xe002;"></span>
							Dashboard</a>
					</li>
					<li><a
						href="<?php echo Yii::app()->request->baseUrl; ?>/admin/userlist">Users</a>
					</li>
				</ul>
			</div>
		</div>

		<br>


		<!-- searching for email field here -->
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
		<!-- searching for email field here -->

		<div class="row-fluid">
			<div class="span12">
				<div class="widget">
					<div class="widget-header">
						<div class="title">
							<span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>
							Users
						</div>
					</div>
					<div class="widget-body">
						<div class="alert alert-block alert-info fade in no-margin">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<h4 class="alert-heading">Info!</h4>
							<p>
								To get started, search for an email above, or <a
									style="text-decoration: underline;"
									href="<?php echo Yii::app()->baseUrl; ?>/admin/userlist">view
									today's entries</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- for searching data of users through email -->
	<script type="text/javascript"
		src="<?php echo Yii::app()->baseUrl; ?>/js/jquerysearch/jquery-1.4.2.min.js"></script>
	<script type="text/javascript"
		src="<?php echo Yii::app()->baseUrl; ?>/js/jquerysearch/jquery-ui-1.8.2.custom.min.js"></script>
	<link rel="stylesheet"
		href="<?php echo Yii::app()->baseUrl; ?>/css/smoothness/jquery-ui-1.8.2.custom.css" />

	<script>   
	jQuery(document).ready(function($){
		$('#appendedInputButton').autocomplete({source:'<?php echo Yii::app()->baseUrl; ?>/admin/searchEmail',minLength:1});
	});
	
	</script>
	<!-- for searching data of users through email -->