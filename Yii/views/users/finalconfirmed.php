<div id='fb-root'></div>
<script src='http://connect.facebook.net/en_US/all.js'></script>
<script>
	FB.init({appId: "<?php echo Yii::app()->params['facebookAppId'] ?>", status: true, cookie: true});

	function postToFeed() 
	{
		// calling the API ...
		var obj = {
						method: 'feed',
						link: '<?php echo Yii::app()->createAbsoluteUrl(''); ?>',
						picture: '<?php echo Yii::app()->createAbsoluteUrl('/tshirt/'.$giftLastValue['jersey_mockup']);?>',
						name: 'PERSONALISED EA SPORTS FOOTBALL CLUB JERSEY',
						caption: '<?php echo Yii::app()->createAbsoluteUrl(''); ?>',
						description: 'Check out this jersey I just personalized when I pre-ordered FIFA 14 at JB Hi-Fi',
					    actions: {name: 'Customise your jersey', link: '<?php echo Yii::app()->createAbsoluteUrl(''); ?>' }
					};

		function callback(response) 
		{
			document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
		}

		FB.ui(obj, callback);
	}

	function recordShareStat() 
	{  
		var a = document.getElementById('lastgiftId').value;
		var statUrl = '<?php echo Yii::app()->createAbsoluteUrl('/users/fbshare/') ?>';
		$.ajax({
			  type: "POST",
			  url: statUrl,
			  data: { id : '<?php echo $giftLastValue['user_id']; ?>' }
		});
	}
</script>

<div class="box top-box">
	<h1>All done!</h1>
	

	<!-- for setting flash message -->
		  
				<div class="flash-success">
					You have been registered properly.. Please check your mailbox.
				</div>
			
			
			<?php if(Yii::app()->user->hasFlash('failuremessage')): ?>
				<div class="flash-error">
					<?php echo Yii::app()->user->getFlash('failuremessage'); ?>
				</div>
			<?php endif; ?>	
	<!-- for setting flash message -->		
	
	
</div>

	
			
<div class="box left-form-box completed">
	<div class="posRel">
		<p><strong>Great, we've got your entry! Don't forget:</strong></p>
        <ul>
        	<li>if you haven't already, you need to pre-order FIFA 14 at your participating retailer. This form does not pre-order the game for you!</li>
            <li>when the game is released, be sure to return here to claim your customised EA SPORTS Football Club jersey. Don't worry, we'll send you an email reminder to let you know it's out!</li>
        </ul>
        <?php
			/* only show the share button if we're not in IE8 */
            if($giftLastValue['jersey_mockup'] != 'no image') 
			{ 
		?>
        	    <a id='share_button' class="sharelink" href="#share" target="_blank" onclick='recordShareStat(); postToFeed();  return false; '/>Share my Jersey on Facebook</a>
        <?php 
			} 
		?>
	</div>
</div>
<div class="box right-box">
	<div class="posRel">
		<?php
			if($giftLastValue['jersey_mockup']=='no image')
			{
				$imageURL = Yii::app()->request->baseUrl.'/js/shirt.png';
			}
			else
			{
				$imageURL= Yii::app()->request->baseUrl.'/tshirt/'.$giftLastValue['jersey_mockup'];
			}
		?>
		<input type="hidden" id="lastgiftId" value="<?php echo CHtml::encode($giftLastValue['id']);?>" >
		<img src="<?php echo CHtml::encode($imageURL) ?>" >
	</div>
</div>
<div class="box forget-box">
	<strong>Don't forget!</strong>
    <ul>
    	<li>if you haven't already, you need to pre-order FIFA 14 at your participating retailer. This form does not pre-order the game for you!</li>
        <li>when the game is released, be sure to return here to claim your customised EA SPORTS Football Club jersey. If you don't, we won't know to send it to you!</li>
   	</ul>
</div>
