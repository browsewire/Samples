<html>
	<head>
		<title><?php echo $giftsVal->custom_msg; ?></title>
		<meta property="og:image" content="http://fifa14.dev.73robots.com/tshirt/<?php echo $giftsVal->jersey_mockup;?>/"/>
	</head>
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/tshirt/<?php echo $giftsVal->jersey_mockup;?>">
</html>



