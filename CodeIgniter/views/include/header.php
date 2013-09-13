<!DOCTYPE html>
<html>
<head>
<title><?php if(isset($meta_title)){
echo $meta_title;}
else{
	echo $this->alloptions->title();
}?></title>
<?php if(isset($pages->search_index) AND $pages->search_index == TRUE){ ?>
<meta name="robots" content="index,follow" />
<?php }else{ ?>
<meta name="robots" content="index,follow,noarchive" />
<?php 
}
if(isset($meta_keywords)){
?>
<meta name="keywords" content="<?=$meta_keywords?>">
<?php }
if(isset($meta_description)){
?>
<meta name="description" content="<?=$meta_description?>">
<?php }?>
<?=$this->load->view('include/head');?>
</head>
<body>
	
<div id="wrapper">
  <!-- header starts -->
  <header>
    <div class="header_top">
      <div class="wrapper">
        <div class="wrapper_main">
    <!-- header starts  -->
      <div id="header">
        <div class="logo"><a href="<?=base_url()?>"><img src="<?=base_url()?>images/logo.png" title="Online USA Doctors" alt=""></a>
        <span class="punchtext"><?=$this->options->getData('punchtext')?></span>
        </div>
        <div class="header_right">
          <div class="header_right_top">
            <div class="header_right_top_phone">Medical helpline: 855-872-0012</div>
            <div class="header_right_top_nav">
              <ul>
                <?php if($this->session->userdata('isLoggedin')){ ?>
					<li>
						<a href="<?=base_url();?>backend/profile/dashboard/">My Account</a>
					</li>
					<li>
						<a href="<?=base_url();?>login/logout">Logout</a>
					</li>
					<?php }else{ ?>
					<li>
						<a href="<?=base_url();?>registration">New Patient Registration</a>
					</li>
					<li>
						<a href="<?=base_url();?>login" id="UserLoginpopup">My Healthcare Access Login</a>
					</li>
				 <?php } ?>
              </ul>
            </div>
          </div>
          <div class="header_right_middle">
            <div class="header_right_middle_inside">
              <ul>
                <li>
					
					 <div class="search_eg">
				<script>
                  (function() {
                    var cx = '013454370709290513707:xlvrb44czk0';
                    var gcse = document.createElement('script');
                    gcse.type = 'text/javascript';
                    gcse.async = true;
                    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                        '//www.google.com/cse/cse.js?cx=' + cx;
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(gcse, s);
                  })();
                </script>
                <gcse:search></gcse:search>
                </div>
                  <!--<div class="search_top">
                    <input name="" type="text" value="Search">
                                        <a href="#">Go</a>
                  </div>-->
                </li>
              </ul>
            </div>
          </div>
          <div class="header_right_bottom">
            <ul>
              <li><a <?php if($this->uri->segment(1)=='health'){?> class="active" <?php } ?>  href="<?=base_url()?>health">Health A-Z </a></li>
              <li><a <?php if($this->uri->segment(1)=='our-plans'){?> class="active" <?php } ?> href="<?=base_url()?>our-plans">Our Plans</a></li>
              <li><a href="<?=base_url()?>qa">Ask A Doctor</a></li>
              <li><a <?php if($this->uri->segment(1)=='how-it-works'){?> class="active" <?php } ?> href="<?=base_url()?>how-it-works">How It Works</a></li>
               <li><a <?php if($this->uri->segment(1)=='contact-us'){?> class="active" <?php } ?>href="<?=base_url()?>contact-us">Contact US</a></li>
                <li><a  href="#">Store</a></li>
            </ul>
          </div>
        </div>
      </div>
    <!-- header ends  -->
        </div>
     </div>
    </div>
  </header>
  <!-- header ends -->
