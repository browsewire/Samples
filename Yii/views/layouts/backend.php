<!DOCTYPE html>
<!--[if lt IE 7]>
    <html class="lt-ie9 lt-ie8 lt-ie7" lang="en">
  <![endif]-->

<!--[if IE 7]>
    <html class="lt-ie9 lt-ie8" lang="en">
  <![endif]-->

<!--[if IE 8]>
    <html class="lt-ie9" lang="en">
  <![endif]-->

<!--[if gt IE 8]>
    <!-->
<html lang="en">
<!--
  <![endif]-->

<head>
<meta charset="utf-8">
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta name="author" content="Srinu Basava">
<meta content="width=device-width, initial-scale=1.0, user-scalable=no"
	name="viewport">
<meta name="description" content="Sunrise Admin Admin UI">
<meta name="keywords"
	content="Sunrise Admin, Admin UI, Admin Dashboard, Srinu Basava">

<!-- css and script included here -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/html5-trunk.js'); ?>
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/main.css" />
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/icomoon/style.css" />


<!--[if lte IE 7]>
      <script src="css/icomoon-font/lte-ie7.js"></script>
    <![endif]-->
<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-40301843-2', 'iamsrinu.com');
      ga('send', 'pageview');

    </script>

<!-- included here -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap.js'); ?>
<!-- included here -->


</head>
<body>

	<div class="container-fluid">


		<?php echo $content; ?>

	</div>



</body>
</html>
