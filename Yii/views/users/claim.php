<script>
	$( document ).ready(function() 
	{
		document.getElementById('checkbutton').addEventListener('click', function(event) 
		{ 
			var str = document.getElementById("unique_code").value;
			var strEmail = document.getElementById("email").value;
			var xmlhttp;
			var error = 0;
			if (str.length==0)
			{ 
				document.getElementById("unique_code").innerHTML="";
				return;
			}
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{
				// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					var res = xmlhttp.responseText;
					if(res == 0)
					{
						error = 0;
					}
					else
					{
						error = 1;
					}
				}
			}
			xmlhttp.open("GET","users/checkUniqueCode?q="+str+"&e="+strEmail,true);
			xmlhttp.send();
			
		 });
	});
		
	function validateclaim()
	{ 
    	var err = 0; 
      	var elem = document.getElementById("claim-form").elements;  
        for(var i = 0; i < elem.length; i++)
        {
        	var classname = elem[i].className;
            var required = classname.match('required');
            if( required!=null )
            {
            	var fieldsval = elem[i].value; 
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
			document.getElementById("claim-form").elements["valid_val"].value=1;
		  	var x=document.getElementById("email").value; 
			var atpos=x.indexOf("@");
			var dotpos=x.lastIndexOf(".");
			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
			{
				alert("Enter a Valid Email address"); 
			  	return false;
			} 
			else 
			{
		 		return true;
	       	}
		   
		}
      	else
       	{
			document.getElementById("claim-form").elements["valid_val"].value=0;
		  	alert('Please enter all fields properly');
		 	return false;
      	}
 	}

	function validateEmail()
	{
		var x=document.getElementById("email").value; 
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
			alert("Enter a Valid Email address"); 
		  	return false;
		}
	}
</script>
	
<div class="box top-box">
	<h1>Register now for your EA SPORTS Football Club Jersey.</h1>
</div>
<?php 
	$form=$this->beginWidget('CActiveForm', array(
			'id'=>'claim-form',
			'enableAjaxValidation'=>true,
			'htmlOptions'=>array(
          	'onsubmit'=>"return validateclaim()",
		),
					
	)); 
?>
		<input type="hidden"  id="valid_val" name="" value="0" /> 
        <div class="box left-form-box right-box">
			<strong>Picked up your copy of FIFA 14 already? Awesome!</strong>
		
			<!-- for setting flash message -->
		    <?php if(Yii::app()->user->hasFlash('email')): ?>
				<div class="flash-error">
					<?php echo Yii::app()->user->getFlash('email'); ?>
				</div>
			<?php endif; ?>
			
			<?php if(Yii::app()->user->hasFlash('failmessage')): ?>
				<div class="flash-error">
					<?php echo Yii::app()->user->getFlash('failmessage'); ?>
				</div>
			<?php endif; ?>
	  		<!-- for setting flash message ends here-->
			<?php 
				if(isset($_SESSION['claimEmailVal']) || isset($_SESSION['claimUniqueCodeVal']))
				{
			?>
				<?php echo CHtml::textField('email',$_SESSION['claimEmailVal'],array('placeholder'=>'email Address','class'=>'required','id'=>'email')); ?>
				
				<small>you used this email address to register previously</small>
							
				<?php echo CHtml::textField('unique_code',$_SESSION['claimUniqueCodeVal'],array('placeholder'=>'enter the unique code','class'=>'required','id'=>'unique_code')); ?>
				<small>you got a unique code when you picked up the game, enter it now</small>
			
			<?php 
				} 
				else 
				{ 
			?>
				
				<?php echo CHtml::textField('email','',array('placeholder'=>'email Address','class'=>'required','id'=>'email')); ?>
				
				<small>you used this email address to register previously</small>
							
				<?php echo CHtml::textField('unique_code','',array('placeholder'=>'enter the unique code','class'=>'required','id'=>'unique_code')); ?>
				
				<small>you got a unique code when you picked up the game, enter it now</small>
			<?php 
				} 
			?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'SEND ME MY JERSEY!' : 'Save', array('id'=>'checkbutton')); ?>
		</div>

  <?php $this->endWidget(); ?>	
