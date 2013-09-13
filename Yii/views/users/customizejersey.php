<script>
	function abc()
  	{ 
		console.clear();
    	var err = 0; 
      	var elem = document.getElementById("gift-form").elements;
        for(var i = 0; i < elem.length; i++)
        {
        	var classname = elem[i].className;
            var required = classname.match('required');
            if( required!=null )
            {
            	var fieldsval = elem[i].value; //alert(classname); return false;
                if( fieldsval==null || fieldsval=='' || fieldsval=='0')
                {
                	elem[i].style.borderColor='#D8000C';
                    err++;
                }
                else
                {
                	elem[i].style.borderColor='#A8A8A8';
                }
			}
		} 
      	if(err==0)
      	{
			document.getElementById("gift-form").elements["valid_val"].value=1;
		  	return true;
      	}
      	else
        {
			document.getElementById("gift-form").elements["valid_val"].value=0;
		  	alert('Please enter all required fields properly');
		  	return false;
      	}
 	}
</script>

<div class="box top-box">
    <h1>Register now for your EA SPORTS Football Club Jersey.</h1>
</div>


<!-- if session value will be found then this part will be executed -->
<?php 
	if(isset($_SESSION['userCustomizeVal']) && $_SESSION['userCustomizeVal'] != "")
	{ 
?>
		<!-- form widget starts here --> 
        <?php 
        	$form=$this->beginWidget('CActiveForm', array(
					'id'=>'gift-form',
					//'enableAjaxValidation'=>true,
					'htmlOptions'=>array(
                    'onsubmit'=>"return abc()",
				),
			)); 
		?>
				<input type="hidden"  id="valid_val" name="" value="0" /> 
				
                <div class="box left-form-box">
                	<div class="posRel">
                    	<strong>Choose your size:</strong>
                       	<?php 
							$size = $_SESSION['size'];
					    	echo CHtml::dropDownList('size',"",array(""=>"Choose your size","small"=>"Small","medium"=>"Medium","large"=>"Large","X-Large"=>"X-Large","XX-Large"=>"XX-Large","XXX-Large"=>"XXX-Large"),array('class'=>'selcountry required','options' => array($size=>array('selected'=>true))));
							echo $form->error($model,'size'); 
						?>
						                       
                        <div class="scale">
							<table cellspacing="1" width="100%" align="center">
								<tr>
					  				<td class="borderRight">S</td>
									<td class="borderRight">M</td>
									<td class="borderRight">L</td>
									<td class="borderRight">XL</td>
									<td class="borderRight">XXL</td>
									<td class="borderRight">XXXL</td>
								</tr>
								<tr>
									<td>28-32</td>
									<td>34-36</td>
									<td>38-40</td>
									<td>42-44</td>
									<td>38-40</td>
									<td>42-44</td>
								</tr>
							</table>
						</div>
						<span class="charttext"> Sizing Chart: All measurements in centimetres around chest</span>
                        
                        <strong>Customise your jersey:</strong>
                        <p>What would you like to appear on the back of your shirt? You can enter a maximum of 9 character. Nothing rude please!</p>
                       
                       	<?php echo $form->textField($model,'custom_msg',array('id'=>'container-front','placeholder'=>'Customize your jersey','class'=>'newinput required','value'=>CHtml::encode($_SESSION['userCustomizeVal']['custom_msg']))); ?>
						<?php echo $form->error($model,'custom_msg'); ?>
								
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Next' : 'Save', array('class'=>'newbutton', 'id'=>'savebtn')); ?>
						
                    </div>
				</div> 
		<?php 
			$this->endWidget(); 
		?>
        <!-- form widget ends here --> 
		<!-- if session value part ends here --> 
                    
<!-- if session value will not be found then this part will be executed -->                   
<?php
	} 
	else 
	{ 
?>
		<!-- form widget starts here --> 
        <?php 
        	$form=$this->beginWidget('CActiveForm', array(
					'id'=>'gift-form',
					//'enableAjaxValidation'=>true,
					'htmlOptions'=>array(
                    'onsubmit'=>"return abc()",
				)
			)); 
		?>
		<input type="hidden"  id="valid_val" name="" value="0" /> 
	
		<div class="box left-form-box">
			<div class="posRel">
			   <strong>Choose your size:</strong>
                       
                <?php echo CHtml::dropDownList('size',"",array(""=>"Choose your size","small"=>"Small","medium"=>"Medium","large"=>"Large","X-Large"=>"X-Large","XX-Large"=>"XX-Large","XXX-Large"=>"XXX-Large"),array('class'=>'required')); ?>
				<?php echo $form->error($model,'size'); ?>
						
				<div class="scale">
					<table cellspacing="1" width="100%" align="center">
			    		<tr>
					    	<td class="borderRight">S</td>
							<td class="borderRight">M</td>
							<td class="borderRight">L</td>
							<td class="borderRight">XL</td>
							<td class="borderRight">XXL</td>
							<td class="borderRight">XXXL</td>
						</tr>
						<tr>
							<td>88-96</td>
							<td>96-104</td>
							<td>104-112</td>
							<td>112-124</td>
							<td>124-136</td>
							<td>136-148</td>
						</tr>
					</table>
				</div>
				<span class="charttext"> Sizing Chart: All measurements in centimetres around chest</span>
				<strong>Customise your jersey:</strong>
                <p>What would you like to appear on the back of your shirt? You can enter a maximum of 9 character. Nothing rude please!</p>
                       
                <?php echo $form->textField($model,'custom_msg',array('id'=>'container-front','placeholder'=>'Customise your jersey','class'=>'required')); ?>
				<?php echo $form->error($model,'custom_msg'); ?>
						
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Next' : 'Save', array('class'=>'newbutton','id'=>'savebtn')); ?>
			
			</div>
     	</div>
 	<?php $this->endWidget(); ?>
 	<!-- form widget ends here --> 
<?php  
	} 
?>
<!-- if session value will not be found then this part will be executed -->      

<!-- right portion containing t-shirt canvas -->
<div class="box right-box">
	<div class="posRel">
		<!--for creating jersey through script here -->
		<div class="jerseydiv">
			
			<div class="container-jersey" id ="container-jersey"></div>
			
			<div class="" id ="another-jersey" style="display:none;"><img src ="<?php echo Yii::app()->request->baseUrl; ?>/images/shirt.png"></div>
		</div>
		<!--for creating jersey through script here -->
						 
     
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
                   
<!-- right portion containing t-shirt canvas  ends here-->       
        

        
<!-- script included for T-shirt here -->
<script type="text/javascript" src ="<?php echo Yii::app()->request->baseUrl; ?>/js/front-view.js"></script>
<!-- script included for T-shirt here -->

         
         
