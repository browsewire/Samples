<?php
/*
Plugin Name: FWD Slider
Description: Slider Component for WordPress
Version: 1.0
Author: Anil Sharma
License: GPLv2 or later
*/
global $wpdb;
define("WP_fwds_TABLE" ,$wpdb->prefix ."fwds_plugin");
define("WP_fwds_set_TABLE",$wpdb->prefix . "fwds_setting");
define("WP_fwds_UNIQUE_NAME " ,"fwds"); 
define("WP_fwds_TITLE" , "FWD Slider");


function fwds_slider_activation() {

global $wpdb;
	
	if($wpdb->get_var("show tables like '". WP_fwds_TABLE . "'") != WP_fwds_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_fwds_TABLE . "` (";
		$sSql = $sSql . "`fwds_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`fwds_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`fwds_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`fwds_speed` VARCHAR( 500 ) NOT NULL ,";
		$sSql = $sSql . "`fwds_order` INT NOT NULL ,";
		$sSql = $sSql . "`fwds_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`fwds_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`fwds_height` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`fwds_width` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`fwds_date` datetime NOT NULL default '0000-00-00 00:00:00' ,";
		$sSql = $sSql . "PRIMARY KEY ( `fwds_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		
		$IsSql = "INSERT INTO `". WP_fwds_TABLE . "` (`fwds_path`, `fwds_link` , `fwds_speed` , `fwds_order` , `fwds_status` , `fwds_type` ,`fwds_height`,`fwds_width`, `fwds_date`)"; 
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/fwd-slider/images/example-slide-1.jpg', '#','5',  '1', 'YES', 'GROUP1','300','600', (select NOW()) )";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/fwd-slider/images/example-slide-2.jpg' ,'#', '5', '2', 'YES', 'GROUP1','300','600' , (select NOW()) )";
		$wpdb->query($sSql);

    if(! file_exists(ABSPATH . '/wp-content/uploads') )
  {  
    @mkdir(ABSPATH . '/wp-content/uploads');
    $dir = ABSPATH . '/wp-content/uploads';
    @chmod($dir,0755);
 } 
 

 if( !  file_exists(ABSPATH . '/wp-content/uploads/my_own_plugin') )
 { 
  @mkdir(ABSPATH . '/wp-content/uploads/my_own_plugin');
  $dir=ABSPATH . '/wp-content/uploads/my_own_plugin';
  @chmod($dir,0755);
  
  } 
 }

}


register_activation_hook(__FILE__, 'fwds_slider_activation');



function fwds_slider_deactivation()
{
   global $wpdb; 
   $sql="DROP TABLE `wp_fwds_plugin`";
   $wpdb->query($sql);
}
register_deactivation_hook(__FILE__, 'fwds_slider_deactivation');



add_action('wp_enqueue_scripts','fwds_scripts');
function fwds_scripts() {

  wp_register_script('slidesjs_core', plugins_url('js/jquery.slides.min.js', __FILE__),array("jquery"));
  wp_enqueue_script('slidesjs_core');

  wp_register_script('slidesjs_init', plugins_url('js/slidesjs.initialize.js', __FILE__));
  wp_enqueue_script('slidesjs_init');

}


add_action('wp_enqueue_scripts', 'fwds_styles');
function fwds_styles() {
  wp_register_style('slidesjs_example', plugins_url('css/example.css', __FILE__));
  wp_enqueue_style('slidesjs_example');
  wp_register_style('slidesjs_fonts', plugins_url('css/font-awesome.min.css', __FILE__));
  wp_enqueue_style('slidesjs_fonts');

}


function my_styles() {  
  wp_register_style('slidesjs_example', plugins_url('css/example.css', __FILE__));
  wp_enqueue_style('slidesjs_example');
  wp_register_style('slidesjs_fonts', plugins_url('css/font-awesome.min.css', __FILE__));
  wp_enqueue_style('slidesjs_fonts');

 }

function my_enqueue(){
  wp_register_script('slidesjs_core', plugins_url('js/jquery.slides.min.js', __FILE__),array("jquery"));
  wp_enqueue_script('slidesjs_core');
  wp_register_script('slidesjs_init', plugins_url('js/slidesjs.initialize.js', __FILE__));
  wp_enqueue_script('slidesjs_init');
}

add_shortcode("fwd_slider", "fwds_display_slider");
function fwds_display_slider($atts)
{
global $wpdb;
$fwds_type=$atts['type'];
$query="select * from wp_fwds_plugin where fwds_status = 'YES' and fwds_type = '$fwds_type' order by fwds_order"; 
$a=$wpdb->get_results($query);
$wpdb->num_rows;
$ab=$wpdb->get_row($query);
$height=$ab->fwds_height;
$width=$ab->fwds_width;
$speed=$ab->fwds_speed;


if($fwds_type == "GROUP1")
{
?>
  <div class="container" style="height:300px;width:700px;overflow:hidden;" >
   <div id="slides" style="height:300px;width:700px;overflow:hidden;">
    <img src= "<?php echo get_option('siteurl');?>/wp-content/plugins/fwd-slider/images/example-slide-1.jpg" style ="height:300px;width:700px;overflow:hidden;"/>
    <img src= "<?php echo get_option('siteurl');?>/wp-content/plugins/fwd-slider/images/example-slide-2.jpg " style ="height:300px;width:700px;overflow:hidden;"/>
    <img src= "<?php echo get_option('siteurl');?>/wp-content/plugins/fwd-slider/images/example-slide-3.jpg " style ="height:300px;width:700px;overflow:hidden;"/>
    <img src= "<?php echo get_option('siteurl');?>/wp-content/plugins/fwd-slider/images/example-slide-4.jpg " style ="height:300px;width:700px;overflow:hidden;"/>
  </div>
</div>
<?php
}
 else
{ 
	foreach($a as $c=>$value)
	{  
	 $id=$value->fwds_id;
	?>
	<script>
	jQuery(function() {
	      jQuery('#slides<?php echo $id;?>').slidesjs({
		width: 700,
		height: 400,
		play: {
		  active: true,
		  auto: true,
		  interval: <?php echo $speed;?>,
		  swap: true
		}
	      });
	    });
	 </script>
<?php 
	 }
  ?>
       <div class="container" style="height:<?php echo $height; ?>px;width:<?php echo $width;?>px;overflow:hidden;" >
        <div id="slides<?php echo $id;?>" style="height:<?php echo $height;?>px;width:<?php echo $width;?>px;overflow:hidden;">
 
	<?php
	foreach($a as $b=>$value)
	{   
	   $val = $value->fwds_path;
	   $link = $value->fwds_link;
	    ?>

	<a href="<?php echo $link;?>" >    <img src= "<?php echo bloginfo('home');?>/wp-content/uploads/my_own_plugin/<?php echo $val;?>"  style ="height:<?php echo $height; ?>px;width:<?php echo $width;?>px;overflow:hidden;"/></a>
	       
	      <?php
	 } ?> 

      </div>
      </div> <?php
  }
}
add_shortcode("fwds_totest","fwds_shortcode_admin");
function fwds_shortcode_admin($atts){
global $wpdb;
$fwds_type=$atts['type'];
$query=$wpdb->get_results("select * from wp_fwds_plugin where fwds_type='$fwds_type' and fwds_status='YES' order by fwds_order" );
$wpdb->num_rows;
if( $fwds_type == 'GROUP1')
{ ?>
 <div class="container" style="height:150px;width:400px;overflow:hidden;" >
    <div id="slides" style="height:150px;width:400px;overflow:hidden;">
    <img src= "<?php echo get_option('siteurl');?>/wp-content/plugins/fwd-slider/images/example-slide-1.jpg" style ="height:150px;width:400px;overflow:hidden;"/>
    <img src= "<?php echo get_option('siteurl');?>/wp-content/plugins/fwd-slider/images/example-slide-2.jpg " style ="height:150px;width:400px;overflow:hidden;"/>
    <img src= "<?php echo get_option('siteurl');?>/wp-content/plugins/fwd-slider/images/example-slide-3.jpg " style ="height:150px;width:400px;overflow:hidden;"/>
    <img src= "<?php echo get_option('siteurl');?>/wp-content/plugins/fwd-slider/images/example-slide-4.jpg " style ="height:150px;width:400px;overflow:hidden;"/>
    </div>
 </div>
   <?php
 }
else
{ 



foreach($query as $a=>$val)
{
 $slideid=$val->fwds_id;
   ?>
<script>
jQuery(function() {
      jQuery('#slides<?php echo $slideid;?>').slidesjs({
        width: 700,
        height: 300,
        play: {
          active: true,
          auto: true,
          interval: 4000,
          swap: true
        }
      });
    });
 </script>
  <?php 
   } 
  ?>
 <div class="container" style="height:150px;width:400px;overflow:hidden;" >
     <div id="slides<?php echo $slideid;?>" style="height:150px;width:400px;overflow:hidden;">

<?php
foreach($query as $b=>$value)
  { 
    $val=$value->fwds_path;
     ?> 
   <img src= "<?php echo bloginfo('home');?>/wp-content/uploads/my_own_plugin/<?php echo $val;?>" style ="height:150px;width:400px;overflow:hidden;"/>
       
      <?php
 }
} 
?> 
    </div>
 </div> 
<?php
 }

add_action("admin_menu","fwds_add_admin");
function fwds_add_admin()
{
	$a = add_menu_page('FWD Slider ' ,'FWD Slider','manage_options','slide_me','fwds_admin_options', plugins_url('/fwd-slider/images/logo.png'));
	$b = add_submenu_page('slide_me' , 'add new ' ,'add new','manage_options','add_new','fwds_sub_options');
	$c = add_submenu_page('slide_me', 'setting', 'Setting' , 'manage_options','slide_set','fwds_setting');
          add_action('admin_print_scripts-'.$a , 'my_enqueue'); 
          add_action('admin_print_styles-'.$a, 'my_styles');
          add_action('admin_print_styles-'.$b, 'my_styles');
          add_action('admin_print_styles-'.$c, 'my_styles');

}

 function fwds_admin_options(){

        global $wpdb;
 
        $current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
 	switch($current_page)
        {    
           case 'edit':
                          
			 include('pages/fwds_edit.php');                
		         break;
           case 'info':
                         include('pages/fwds_info.php');
                         break;
 
         
           default:
                          include('pages/fwds_show.php');
                          break;
       }
 }

  function fwds_sub_options() { 
  include(ABSPATH . '/wp-content/plugins/fwd-slider/pages/fwds_add.php');
 }

  function fwds_setting(){
  include(ABSPATH . '/wp-content/plugins/fwd-slider/pages/fwds_set.php');

 }



?>
