
<script>
function sendBulkEmail() 
	{  
		var statUrl = '<?php echo Yii::app()->createAbsoluteUrl('/admin/updateNotify/') ?>';
		$.ajax({
			  type: "POST",
			  url: statUrl,
			 
		});
		
		var notifybutton = document.getElementById('notificationOnce');
		notifybutton.disabled = true;
		
		alert("Notification mail sent to all users who are not notified");
		location.reload(); 
	}
</script>

<script>
function sendNoBulkEmail() 
	{  
		var notifybutton = document.getElementById('notificationOnce');
		notifybutton.disabled = true;
		alert("Notification mail already sent");
	}
</script>


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
						href="<?php echo Yii::app()->request->baseUrl; ?>/admin/userlist">Send Email</a>
					</li>
				</ul>
			</div>
		</div>

		<br>


		<!-- searching for email field here -->
		<div class="row-fluid">
			<div class="span3">
						<div class="widget widget-border">
							<div class="widget-body">
								<div class="current-stats">
									<h4 class="text-warning">
										<?php 
											foreach($usernotNotified as $usernotNotified)
											{
											echo $usernotNotified['notify']; 
											}
										?>
									</h4>
									<p>Unnotified Users</p>
									<div class="type">
										<span class="fs1 arrow text-warning" aria-hidden="true"
											data-icon="&#xe040;"></span>
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
							Notification Email
						</div>
					</div>
					<div class="widget-body newwidgetbulk">
					
					<div>
                    <?php if($usernotNotified['notify'] == 0){ ?>
                    <button class="btn notifybutton" id="notificationOnce" type="submit" onclick ="sendNoBulkEmail();" disabled>Send Notification Email</button>
					<?php } else { ?>
					<button class="btn notifybutton" id="notificationOnce" type="submit" onclick ="sendBulkEmail();">Send Notification Email</button>
					<?php } ?>
					<span class="notificationmsg">Send the onsale message to all users who have not yet been notified (Note: <br/> press only once to avoid duplicate notifications) </span>
					</div>
					
					
					</div>
				</div>
			</div>
		</div>

	</div>
	
