<div class="box top-box">
	<h1>Register now for your EA SPORTS Football Club Jersey.</h1>
</div>

<div class="box left-form-box">
	<div class="posRel">
    	<p>OK, before we register you for your customised jersey, let's confirm everything you've told us:</p>
        <strong>About you:</strong>
        <p><span><strong>Name:</strong><span><?php echo CHtml::encode($_SESSION['userRegisterVal']['first_name'])." ".CHtml::encode($_SESSION['userRegisterVal']['last_name']);?></span></span></p>
        <p><span><strong>Email:</strong><span><?php echo CHtml::encode($_SESSION['userRegisterVal']['email']); ?></span></span></p>
        <strong>Postal Address:</strong>

        <p><?php echo CHtml::encode($_SESSION['userRegisterVal']['address1']); ?><br/>

        <?php 
        	if(isset($_SESSION['userRegisterVal']['region']) && $_SESSION['userRegisterVal']['region'] !== "")
			{ 
				echo CHtml::encode($_SESSION['userRegisterVal']['suburb']).", ".CHtml::encode($_SESSION['userRegisterVal']['region']).", ".$_SESSION['userRegisterVal']['postcode']; ?><br/>

		<?php 
			} 
			else 
			{ 
				echo CHtml::encode($_SESSION['userRegisterVal']['suburb']).", ".CHtml::encode($_SESSION['region']).", ".CHtml::encode($_SESSION['userRegisterVal']['postcode']); ?><br/>
		<?php  
			} 
		?>
        <?php echo CHtml::encode($_SESSION['country']); ?> </p>
        <strong>Your customised jersey:</strong>
        <p><span><strong style="width:125px">Size:</strong><span><?php echo CHtml::encode($_SESSION['size']); ?></span></span></p>
        <p><span><strong style="width:125px">Custom name:</strong><span><?php echo CHtml::encode($_SESSION['userCustomizeVal']['custom_msg']); ?></span></span></p>

        <a class="newbtn" href="<?php echo Yii::app()->request->baseUrl; ?>/users/confirmsuccess">Save my entry!</a>
        <a class="changeButton" href="<?php echo Yii::app()->request->baseUrl; ?>/register">Oops! Let me make changes</a>
	</div>
</div>
<div class="box right-box">
	<div class="posRel">
		<div class="jerseydiv">
			<input type="hidden" id="container-front" name="">
			<?php 
				if(isset($_SESSION['imagesrc']) && $_SESSION['imagesrc'] != "")
				{  
			?>
				    <img src="<?php echo CHtml::encode($_SESSION['imagesrc']);?>" >
				
			<?php 
			   	} 
			   	else 
				{ 
			?>
			    	<div class="container-jersey" id ="container-jersey"></div>
			<?php 
				} 
			?>
			<div class="" id ="another-jersey" style="position:relative;display:none;">
				<img src ="<?php echo Yii::app()->request->baseUrl; ?>/images/shirt.png">
			</div>
		</div>
	</div>
</div>
<div class="box forget-box">
	<div class="posRel">
    	<strong>Don't forget!</strong>
        <ul>
        	<li>if you haven't already, you need to pre-order FIFA 14 at your participating retailer. This form does not pre-order the game for you!</li>
            <li>when the game is released, be sure to return here to claim your customised EA SPORTS Football Club jersey. If you don't, we won't know to send it to you!</li>
        </ul>
	</div>
</div>

<!-- script included for this page here -->
<script type="text/javascript" src ="<?php echo Yii::app()->request->baseUrl; ?>/js/front-view.js"></script>
<!-- script included for this page here -->

