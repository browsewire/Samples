<!--Script for changing values of Countries -->
<script type="text/javascript">
	function getstateval(sel) 
	{
    	var countryVal = sel.value;
        if(countryVal =="AU")
        { 
			$('#AuState').show();
			$('#NZRegion').hide();
		} 
	    if(countryVal =="NZ") 
		{ 
			$('#NZRegion').show();
			$('#AuState').hide();
			
	    }
    }

	$(document).ready(function() 
	{
		$('#checkbox').click(function()
		{  
	    	if($(this).is(':checked'))
	        {
	        	$('#nextbutton').removeAttr("disabled");
			}
	   		else
	   		{
	      		$('#nextbutton').attr("disabled", "true");
	    	}
		});
	});
</script>
<!--for changing values of Countries -->

<!-- if session value found then this part will be executed -->
<?php
	if(isset($_SESSION['userRegisterVal']) && $_SESSION['userRegisterVal'] != "")
	{  
?>
    	<div class="box top-box">
        	<h1>Register now for your EA SPORTS Football Club Jersey.</h1>
        </div>
              
        <!-- form starts here -->
        <?php 
        	$form=$this->beginWidget('CActiveForm', array(
				'id'=>'users-form',
				'enableAjaxValidation'=>false,
			)); 
		?>
	        <div class="box left-form-box">
	        	<div class="posRel">
	            	<strong>Personal Details</strong>
					<?php echo $form->textField($model,'first_name',array('placeholder'=>'First name','class'=>'','value'=>CHtml::encode($_SESSION['userRegisterVal']['first_name']))); ?>
	                <?php echo $form->error($model,'first_name'); ?>
	                      
					<?php echo $form->textField($model,'last_name',array('placeholder'=>'Last name','class'=>'','value'=>CHtml::encode($_SESSION['userRegisterVal']['last_name']))); ?>
					<?php echo $form->error($model,'last_name'); ?>
							
	                <?php echo $form->textField($model,'email',array('placeholder'=>'Email address','class'=>'','value'=>CHtml::encode($_SESSION['userRegisterVal']['email']))); ?>
					<?php echo $form->error($model,'email'); ?>
							
	                <strong>Where should we send your gift?</strong>
	                      
	                <?php echo $form->textField($model,'address1',array('placeholder'=>'Address','class'=>'','value'=>CHtml::encode($_SESSION['userRegisterVal']['address1']))); ?>
					<?php echo $form->error($model,'address1'); ?>
									
	                <?php echo $form->textField($model,'suburb',array('placeholder'=>'City/Suburb','class'=>'','value'=>CHtml::encode($_SESSION['userRegisterVal']['suburb']))); ?>
	    			<?php echo $form->error($model,'suburb'); ?>
	
					<?php echo CHtml::dropDownList('country',"",array(""=>"Choose your country","AU"=>"Australia","NZ"=>"New Zealand"),array('class'=>'selcountry','onchange'=>'getstateval(this)','options' => array($_SESSION['country']=>array('selected'=>true)))); ?>
					<?php echo $form->error($model,'country'); ?>
			
					<div class="" id="AuState" style="display:none;">
						<?php echo CHtml::dropDownList('region1',"",CHtml::listData(States::model()->findAll(), 'shortname', 'name'),array('class'=>'selcountry')); ?>
					</div>			
	
					<div class="" id="NZRegion" style="display:none;">
						<?php echo $form->textField($model,'region',array('placeholder'=>'State','class'=>'newinput')); ?>
						<?php echo $form->error($model,'region'); ?>
					</div>
	                        
					<?php echo $form->textField($model,'postcode',array('placeholder'=>'Postcode','class'=>'newinput','value'=>CHtml::encode($_SESSION['userRegisterVal']['postcode']))); ?>
					<?php echo $form->error($model,'postcode'); ?>
	                   
					<div class="termsdiv"><input id="checkbox" type="checkbox"><span class="termscheck">I accept EA's Privacy Policy and Terms of Service</span></div>
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Next' : 'Save', array('class'=>'','id'=>'nextbutton','disabled'=>'disabled')); ?>
				</div>
			</div>
                   
		<?php $this->endWidget(); ?>
        <!-- form widget ends here -->
   
    	<!-- if session value found  part ends here -->
   
    	<!-- if session value not found else part  starts here -->
<?php  
	} 
	else 
	{ 
?>
   		<div class="box top-box">
        	<h1>Register now for your EA SPORTS Football Club Jersey.</h1>
        </div>
        <!-- form widget starts here -->
        <?php 
        	$form=$this->beginWidget('CActiveForm', array(
				'id'=>'users-form',
				'enableAjaxValidation'=>false,
			)); 
		?>
            <div class="box left-form-box">
            	<div class="posRel">
                	<strong>Personal Details</strong>
                    <?php echo $form->textField($model,'first_name',array('placeholder'=>'First name','class'=>'')); ?>
					<?php echo $form->error($model,'first_name'); ?>

					<?php echo $form->textField($model,'last_name',array('placeholder'=>'Last name','class'=>'')); ?>
					<?php echo $form->error($model,'last_name'); ?>
                       
                    <?php echo $form->textField($model,'email',array('placeholder'=>'Email Address','class'=>'')); ?>
					<?php echo $form->error($model,'email'); ?>
						
                    <strong>Where should we send your gift?</strong>
                    <?php echo $form->textField($model,'address1',array('placeholder'=>'Address','class'=>'',)); ?>
					<?php echo $form->error($model,'address1'); ?>
                       
                    <?php echo $form->textField($model,'suburb',array('placeholder'=>'City/Suburb','class'=>'')); ?>
					<?php echo $form->error($model,'suburb'); ?>
                       
					<?php echo CHtml::dropDownList('country',"",array(""=>"- Choose your country -","AU"=>"Australia","NZ"=>"New Zealand"),array('class'=>'selcountry','onchange'=>'getstateval(this)')); ?>
    				<?php echo $form->error($model,'country'); ?>
                       
					<div class="" id="AuState" style="display:none;">
  						<?php echo CHtml::dropDownList('region1',"",CHtml::listData(States::model()->findAll(), 'shortname', 'name'),array('class'=>'selcountry')); ?>
                    </div>
                             
					<div class="" id="NZRegion" style="display:none;">
   						<?php echo $form->textField($model,'region',array('placeholder'=>'State','class'=>'')); ?>
  						<?php echo $form->error($model,'region'); ?>
					</div>  
                        
					<?php echo $form->textField($model,'postcode',array('placeholder'=>'Postcode','class'=>'')); ?>
   					<?php echo $form->error($model,'postcode'); ?>
                        
                    <div class="termsdiv"> <input id="checkbox" type="checkbox"><span class="termscheck">I accept EA's Privacy Policy and Terms of Service</span>
                    </div>
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Next' : 'Save', array('class'=>'newbutton','id'=>'nextbutton','disabled'=>'disabled')); ?>
                </div>
			</div>
		<?php $this->endWidget(); ?>
        <!-- form widget ends here -->
                  
<?php 
	} 
?>   
<!-- if session value not found  part ends here -->      
     
<!-- right portion of the page starts here -->
<div class="box right-box">
	<div class="posRel">
		<!--for creating jersey through script here -->
		<div class="jerseydiv">
			<!--<img src ="../images/images.jpeg" style="height: 400px;">-->
			<input type="hidden" id="container-front" name="">
  			<?php 
  				if(isset($_SESSION['imagesrc']) && $_SESSION['imagesrc'] != "")
				{  
			?>
    				<img src="<?php echo $_SESSION['imagesrc'];?>" >
            <?php 
				}  
				else 
				{ 
			?>
 			<div class="container-jersey" id ="container-jersey"></div>
			<?php 
				}	
			?>

 			<div id ="another-jersey" style="display:none;">
 				<img src ="<?php echo Yii::app()->request->baseUrl; ?>/images/shirt.png">
 			</div>
		</div>
	</div>
 	<!--for creating jersey through script here -->
</div>
<div class="box forget-box">
	<strong>Don't forget!</strong>
    <ul>
       	<li>if you haven't already, you need to pre-order FIFA 14 at your participating retailer. This form does not pre-order the game for you!</li>
        <li>when the game is released, be sure to return here to claim your customised EA SPORTS Football Club jersey. If you don't, we won't know to send it to you!</li>
    </ul>
</div>
                    
<!-- right portion of the page ends here-->
     
<!-- script included for T-shirt here -->
<script type="text/javascript" src ="<?php echo Yii::app()->request->baseUrl; ?>/js/front-view.js">
</script>
<!-- script included for T-shirt here -->
  
<!-- script included for this page here -->           
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/front/main.js">
</script>
<!-- script included for this page here -->
       
       
