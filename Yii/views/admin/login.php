<div class="row-fluid">
	<div class="span4 offset4">
		<div class="signin">
			<h1 class="center-align-text">Login</h1>
			<div class="signin-wrapper">
				<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'login-form',
						//'class'=>'signin-wrapper',
						'enableClientValidation'=>false,
						'clientOptions'=>array(
							'validateOnSubmit'=>true,
						),
					)); ?>

				<div class="content">

					<?php echo $form->textField($model,'username',array('placeholder'=>'Username','class'=>'input input-block-level')); ?>
					<?php echo $form->error($model,'username'); ?>

					<?php echo $form->passwordField($model,'password',array('placeholder'=>'Password','class'=>'input input-block-level')); ?>
					<?php echo $form->error($model,'password'); ?>
				</div>

				<div class="actions">
					<?php echo CHtml::submitButton('Login',array('class'=>'btn btn-info pull-right')); ?>
					<span class="checkbox-wrapper"> </span>
					<div class="clearfix"></div>
				</div>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
