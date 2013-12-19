<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - ChatLogin';
$this->breadcrumbs=array(
	'Chat Login',
);
?>

<h1>Login to SimpleChat</h1>

<p>Please fill out the following form with your chat name:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chat-login-form',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
