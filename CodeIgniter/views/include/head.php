<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
			<link rel="stylesheet" href="<?php echo base_url()?>css/inuit.css" />
            <link rel="stylesheet" href="<?php echo base_url()?>css/fluid-grid16-1100px.css" />
            <link rel="stylesheet" href="<?php echo base_url()?>css/eve-styles.css" media="all"  />
            <link rel="shortcut icon" href="<?php echo base_url()?>img/icon.png" />
            <link rel="apple-touch-icon-precomposed" href="<?php echo base_url()?>img/icon.png" />

  <!--links for front end slider -->
            <link rel="stylesheet" href="<?php echo base_url()?>css/slides.css" />
            <link href="<?php echo base_url()?>css/style.css" rel="stylesheet" type="text/css">
            <link href="<?php echo base_url()?>css/media.css" rel="stylesheet" media="all" type="text/css">
            <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js" ></script>
            <script src="<?php echo base_url();?>js/js_fpIOV9TyV-F74FJPTtOkfr1LHr-mpcwkhDG_ihSmbQM.js"></script> 
            <script src="<?php echo base_url();?>js/js_iDR9x5jhOMeU1DS-zVMLAJ-uGuY6VPxR97NClq8yj4Y.js"></script>
            
            
    <!-- Contact Us Form Submit Action -->  
    
    
    <!-- css for adding Question Answer section -->
           <!-- <link rel="stylesheet" href="<?php //echo base_url()?>css/QuestionAnswer/media.css" />
            <link rel="stylesheet" href="<?php //echo base_url()?>css/QuestionAnswer/style.css" media="all"  />-->
<!-- css for adding Question Answer section -->           
  
    <script type="text/javascript">
	function submitForm(){
   // $("#contactform").attr("action","<?=base_url()?>index/contactUs");
    $("#contactform").attr("action","#");
    $("#contactform").submit();
}
</script>     
  <!-- Fancybox for register and login --> 
           <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>--> 
          <link rel="stylesheet" href="<?=base_url()?>css/fancybox/jquery.fancybox-1.3.4.css" />
            <script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.pack.js" ></script> 
            <script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.mousewheel-3.0.4.pack.js" ></script>
             
       <script type="text/javascript">
                $(document).ready(function($) {
			
					$("#UserRegisterpopup").fancybox({
							'titleShow' 	        : 'false',
							'transitionIn'		: 'none',
							'transitionOut'		: 'none',
							'height'		:  498,
							'width'			:  548,
							'type'                  : 'iframe',
							'scrolling'             : 'no',
			
							});

                        $("#UserLoginpopup").fancybox({
							'titleShow' 	        : 'false',
							'transitionIn'		: 'none',
							'transitionOut'		: 'none',
							'height'		:  261,
							'width'			:  513,
							'type'                  : 'iframe',
							'scrolling'             : 'no',
			
						});
				 
				    $("#UserLoginpopup2").fancybox({
						'titleShow' 	        : 'false',
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'height'		:  261,
						'width'			:  513,
						'type'                  : 'iframe',
						'scrolling'             : 'no',
			
						});

                       $("#askQuestion").fancybox({
								'titleShow' 	        : 'false',
								'transitionIn'		: 'none',
								'transitionOut'		: 'none',
								'height'		:  261,
								'width'			:  513,
								'type'                  : 'iframe',
								'scrolling'             : 'no',
			
							});

                       $("#askQuesRegisterpopup").fancybox({
									'titleShow' 	        : 'false',
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'height'		:  498,
									'width'			:  548,
									'type'                  : 'iframe',
									'scrolling'             : 'no',
			
						});
                      $("#UserForgotPasswordpopup").fancybox({
							'titleShow' 	        : 'false',
							'transitionIn'		: 'none',
							'transitionOut'		: 'none',
							'height'		:  261,
							'width'			:  513,
							'type'                  : 'iframe',
							'scrolling'             : 'no',
			
		         });
								
		 });

        function closeFancyboxAndRedirectToUrl(url){
	    $.fancybox.close();
	    window.location = url;
	}
	</script>
	     <!-- links for userprofile tabs -->
             <script type="text/javascript" src="<?=base_url();?>js/ddaccordion.js" ></script>
             
               <!-- Tinymce Editor -->
             <script type="text/javascript" src="<?=base_url()?>js/tiny_mce.js"></script>
             
             <script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.8.2.custom.min.js"></script>
 <!--<link rel="stylesheet" href="<?=base_url()?>css/jquery-ui.css" type="text/css" media="all" />-->
<script>
$(document).ready(function(){
	$(".headermenu > li >ul >li >ul > a:empty('')").css('display','none');
	$(".headermenu > li >ul >li > ul > li > a:empty").css('display','none');
	});
</script>
