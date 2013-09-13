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

		<div class="row-fluid">
			<div class="span12">
				<div class="widget">
					<div class="widget-header">
						<div class="title">
							<span class="fs1" aria-hidden="true" data-icon=""></span>
							<?php echo $model->first_name." ".$model->last_name;?>
						</div>
					</div>
					<div class="widget-body">

						<!-- for editing Users data -->
						<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'users-form',
								'enableAjaxValidation'=>true,
					)); ?>
						<!--form div starts here -->
						<div class="form-horizontal no-margin having_right_column">
							<div class="cust-rght-col" class="span12">
								<div class="control-group">
									<label class="control-label" for="your-email"> Custom Message </label>
									<div class="controls">
										<textarea name="custom_msg" id="your-email" class="span12">
											<?php if($Gift) { 
												echo $Gift->custom_msg;
											} ?>
										</textarea>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="DateOfBirthMonth"> Status </label>
									<div class="controls controls-row">
										<select id="DateOfBirthMonth" class="span12" name="status">
											<option value="Registered"
											<?php if(($model->status)== "Registered"){ ?> selected
											<?php } ?>>Registered</option>
											<option value="Claimed"
											<?php if(($model->status)== "Claimed"){ ?> selected
											<?php } ?>>Claimed</option>
											<option value="Under Review"
											<?php if(($model->status)== "Under Review"){ ?> selected
											<?php } ?>>Under Review</option>
											<option value="Rejected"
											<?php if(($model->status)== "Rejected"){ ?> selected
											<?php } ?>>Rejected</option>
										</select>
									</div>
								</div>

								<div class="cust-rght-col" class="span12">
									<div class="controls">
										<strong>Created</strong><br /> <span> <?php 
										echo date("d F Y",strtotime($model->date_created));
										$timestamp = strtotime($model->date_created);
										echo " ".date("h:i A", $timestamp);
										?>
										</span>
									</div>
								</div>
								<br />

								<div class="cust-rght-col" class="span12">
									<div class="controls">
										<strong>Last Modified</strong><br /> <span> <?php 
										echo date("d F Y",strtotime($model->date_modified));
										$timestamp = strtotime($model->date_modified);
										echo " ".date("h:i A", $timestamp);
										?>
										</span>
									</div>
								</div>
								<br />
							</div>
							<div class="control-group">
								<label class="control-label" for="your-email"> First Name </label>
								<div class="controls">
									<?php echo $form->textField($model,'first_name',array('id'=>'your-email','class'=>'span6','placeholder'=>'Enter your First Name')); ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="your-email"> Last Name </label>
								<div class="controls">
									<?php echo $form->textField($model,'last_name',array('id'=>'your-email','class'=>'span6','placeholder'=>'Enter your Last Name')); ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="your-email"> Address </label>
								<div class="controls">
									<?php echo $form->textField($model,'address1',array('id'=>'your-email','class'=>'span6','placeholder'=>'Enter your Address')); ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="your-email"> Town </label>
								<div class="controls">
									<?php echo $form->textField($model,'suburb',array('id'=>'your-email','class'=>'span6','placeholder'=>'Enter your Town')); ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="your-email"> State/Region </label>
								<div class="controls">
									<?php echo $form->textField($model,'region',array('id'=>'your-email','class'=>'span6','placeholder'=>'Enter your State/Region')); ?>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="your-email"> Country </label>
								<div class="controls">
									<?php echo $form->textField($model,'country',array('id'=>'your-email','class'=>'span6','placeholder'=>'Enter your Country')); ?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="your-email"> Email </label>
								<div class="controls">
									<?php echo $form->textField($model,'email',array('id'=>'your-email','class'=>'span6','placeholder'=>'Enter Email')); ?>
								</div>
							</div>

							<hr>
							<?php echo CHtml::submitButton($model->isNewRecord ? 'submit' : 'Save',array('class'=>'btn btn-info pull-right')); ?>
							<div class="clearfix"></div>
							<!-- </form>-->
						</div>
						<!-- form div close here-->
						<?php $this->endWidget(); ?>
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