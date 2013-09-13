<!DOCTYPE html>
<!--[if lt IE 7]> <!-->     <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <!--[endif]-->
<!--[if IE 7]> <!-->        <html class="no-js lt-ie9 lt-ie8"> <!--[endif]-->
<!--[if IE 8]> <!-->        <html class="no-js lt-ie9"> <!--[endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="">
        <link rel="shortcut icon" type="image/gif"
			href="<?php echo Yii::app()->request->baseUrl; ?>/images/14icon-16x16.gif">
        <meta name="viewport" content="width=device-width">


		 <!--including css and js files here -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/normalize.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/main.css" />
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/front/vendor/modernizr-2.6.2.min.js'); ?>
		<!--including css and js files here -->
		  
	    <!--js for printing text on T-Shirt -->
	   
	    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/kinetic-v4.4.1.min.js'); ?>
		<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/KineticJS.js'); ?>
		
		<!--js for printing text on T-Shirt -->
		
		<!-- script for placeholder in IE8/9 -->
		<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/front/jquery.js'); ?>
		<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/front/modernizr.js'); ?>
		<script>

				$(document).ready(function(){

				if(!Modernizr.input.placeholder){

					$('[placeholder]').focus(function() {
					  var input = $(this);
					  if (input.val() == input.attr('placeholder')) {
						input.val('');
						input.removeClass('placeholder');
					  }
					}).blur(function() {
					  var input = $(this);
					  if (input.val() == '' || input.val() == input.attr('placeholder')) {
						input.addClass('placeholder');
						input.val(input.attr('placeholder'));
					  }
					}).blur();
					$('[placeholder]').parents('form').submit(function() {
					  $(this).find('[placeholder]').each(function() {
						var input = $(this);
						if (input.val() == input.attr('placeholder')) {
						  input.val('');
						}
					  })
					});

				}

				});

		
		</script>
		<!-- script for placeholder in IE8/9 -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-40747611-1', 'fifa14fanatics.com.au');
		  ga('send', 'pageview');

		</script>
		<!-- put in head tag -->

    </head>


<body>
	<!-- wrapper starts -->
	<div id="wrapper">
         <div id="top">
              <div id="content">
				  
				  <!-- getting content of view page here -->
					<?php echo $content; ?>
					
					 <img src="<?php echo Yii::app()->request->baseUrl;?>/images/front/logo.png" class="logo" alt="EA Sports Fifa 14" title="EA Sports Fifa 14">
					  <a ><img src="<?php echo Yii::app()->request->baseUrl;?>/images/CTC_square_FOP.png" class="logo nsj" alt="EA Sports Fifa 14" title="EA Sports Fifa 14"/></a>
					<ul class="footer-links">
						<li><a href="http://tos.ea.com/legalapp/WEBTERMS/US/en/PC/" target="_blank">Terms of Service</a></li>
						<li><a href="http://tos.ea.com/legalapp/WEBPRIVACY/US/en/PC/" target="_blank">Privacy Policy</a></li>
						<li><a href="http://www.ea.com/1/legal-notices" target="_blank">Legal Notices</a></li>
						<li><a href="<?php echo Yii::app()->request->baseUrl;?>/terms" target="_blank">Terms & Conditions</a></li>
					</ul>
					<ul class="newfooterlink">
						<li>©2013 Electronic Arts PTY LTD. All Rights Reserved</li>
					</ul>
					<ul class="footercontactlink">
						<li><a href="mailto:info@entmkg.com?subject=FIFA14%20Contact">Contact</a></li>
					</ul>
				  <!-- getting content of view page here -->
				  
            </div>
				
		</div>
			
	</div>
	<!-- wrapper ends -->
		<!-- script and csss included here -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript">window.jQuery || document.write('<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/front/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <!-- script and csss included here -->

</body>
</html>
		
		
