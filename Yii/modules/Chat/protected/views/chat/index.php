<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Chat';
$this->breadcrumbs=array(
	'Chat room',
);
?>

<h1>Welcome to Public Chat</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chat-form',
)); ?>

<div id="wrapper">  
        <div id="menu">  
            <p class="welcome">Welcome, <b><?php echo $chatuser ?></b></p>  
            <p class="logout"><a id="exit" href="#">Exit Chat</a></p>  
            <div style="clear:both"></div>  
        </div>	
  <div id="chatbox">
            <?php  
                if(file_exists("log.html") && filesize("log.html") > 0){  
                $handle = fopen("log.html", "r");  
                $contents = fread($handle, filesize("log.html"));  
                fclose($handle);  
                
                echo $contents;  
                }  
            ?>
  </div>
  <div class="chatmessage">
   <?php echo $form->textField($model,'usermsg'); ?>
  	<input name="submitmsg" type="submit"  id="submitmsg" value="Send" /> 
	</div>
</div> 
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>  
    <script type="text/javascript">  
    // jQuery Document  
    $(document).ready(function(){  
    setInterval (loadLog, 1500); 
    $("#submitmsg").click(function(){     
    var clientmsg = $("#ChatForm_usermsg").val();  
    var rootpath = '<?php echo Yii::app()->createUrl('chat/post');?>';
    $.post(rootpath, {text: clientmsg});                
    $("#ChatForm_usermsg").attr("value", "");  
    return false;  
});

    }); 
    
    function loadLog(){       
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request  
    $.ajax({  
        url: "log.html",  
        cache: false,  
        success: function(html){          
            $("#chatbox").html(html); //Insert chat log into the #chatbox div     
              
            //Auto-scroll             
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request  
            if(newscrollHeight > oldscrollHeight){  
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div  
            }                 
        },  
    });  
}  
    </script>  
    <script type="text/javascript">  
// jQuery Document  
$(document).ready(function(){  
    //If user wants to end session  
    $("#exit").click(function(){  
        var exit = confirm("Are you sure you want to end the session?"); 
        var rootpath = '<?php echo Yii::app()->createUrl('chat/logout');?>'; 
        if(exit==true){window.location = rootpath;}        
    });  
});  
</script>
<?php $this->endWidget(); ?>
</div><!-- form -->
