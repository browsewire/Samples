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
<link rel="shortcut icon" type="image/gif"
	href="<?php echo Yii::app()->request->baseUrl; ?>/images/14icon-16x16.gif">


<!-- css and script included here -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/html5-trunk.js'); ?>
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/icomoon/style.css" />
<!-- bootstrap css -->
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/main.css" />
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/fullcalendar.css" />




<!--[if lte IE 7]>
    <script src="css/icomoon-font/lte-ie7.js"></script>
    <![endif]-->




<!--Implement the following Analytics snippit in the page template -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40747611-1', 'fifa14fanatics.com.au');
  ga('send', 'pageview');

</script>



</head>
<body>
	<header>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/dashboard"
			class="logo">FIFA 14 Promotion</a>
		<div id="mini-nav">
			<ul class="hidden-phone">
				<?php if(!Yii::app()->user->isGuest){ ?>
				<li><a
					href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout">Logout</a>
				</li>
				<?php } else { ?>
				<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/">Login</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</header>

	<!--main content section here -->
	<div class="container-fluid">
		<!-- for left navigation -->

		<div id="mainnav" class="hidden-phone hidden-tablet">
			<ul>
				<li class="active"><span class="current-arrow"></span> <a
					href="<?php echo Yii::app()->request->baseUrl; ?>/admin/dashboard">
						<div class="icon">
							<span class="fs1" aria-hidden="true" data-icon="&#xe0a1;"></span>
						</div> Dashboard
				</a>
				</li>
				<li><a
					href="<?php echo Yii::app()->request->baseUrl; ?>/admin/userslanding">
						<div class="icon">
							<span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>
						</div> Users
				</a>
				</li>
				<li><a
					href="<?php echo Yii::app()->request->baseUrl; ?>/admin/bulkEmail">
						<div class="icon">
							<span class="fs1" aria-hidden="true" data-icon="&#xe040;"></span>
						</div> Bulk Email
				</a>
				</li>
			</ul>
		</div>
		<!-- for left navigation -->
		<?php echo $content; ?>
	</div>
	<!--main content section ends here -->
	<!--footer section starts here-->
	<footer>
		<p class="copyright">&copy; FIFA 14 Promotion 2013</p>
	</footer>


	<!-- css and script included here -->

	<link rel="stylesheet" type="text/css"
		href="<?php echo Yii::app()->request->baseUrl; ?>/icomoon/style.css" />


	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/bootstrap.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery-ui-1.8.23.custom.min.js'); ?>

	<!-- morris charts -->
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/morris/morris.js'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/morris/raphael-min.js'); ?>

	<!-- Flot charts -->
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/flot/jquery.flot.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/flot/jquery.flot.resize.min.js'); ?>

	<!-- Calendar Js -->
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/fullcalendar.js'); ?>

	<!-- Tiny Scrollbar JS -->
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/tiny-scrollbar.js'); ?>

	<!-- custom Js -->
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/custom-index.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/custom.js'); ?>

	<!--footer section ends here-->

	<!-- js for usersearch page -->
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.dataTables.js'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/jquery.sparkline.js'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/admin/custom-tables.js'); ?>


</body>
</html>
