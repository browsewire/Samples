
<div id="wrap">
<h2><?php echo WP_fwds_TITLE ;?></h2>
<h3><center> Add your slider here</center> </h3>
<script>
 var count = 1;
jQuery(document).ready(function(){
jQuery("#btn-1").click(function()
{   
	jQuery("#form-content").append('<li style="list-style:none"><label for="image path "> Image Path</label>&nbsp<input id="slidepath" type="file" value="" name="fwds_imagepath['+count+']"><label for="image link"> Image link </label><input id="slidelink" type="text" value="" name="fwds_imagelink['+count+']"><label for="image order"> Image order </label><input id="slideorder" type="text" size="5" value="" name="fwds_imageorder['+count+']"><label for="image status"> Status </label><select id="slidestatus" name="fwds_imagestatus['+count+']"><option value="YES"> Show_me</option><option value="NO"> Hide_me</option></select></li>');
	count = count + 1;
});
});
</script>
    
 <div id="form-container">
    <form name="fwds_add_display" method="POST" enctype="multipart/form-data">
<strong><label for= "slidr type" style="font-size:17px";>Slider Gallery Type </label> </strong>
<select name="fwds_type">
 <option value="slider 1">slider 1 </option>
 <option value="slider 2">slider 2 </option>
 <option value="slider 3">slider 3 </option>
 <option value="slider 4">slider 4 </option>
 <option value="slider 5">slider 5 </option>
 <option value="slider 6">slider 6 </option>
 <option value="slider 7">slider 7 </option>
 <option value="slider 8">slider 8 </option>
 <option value="slider 9">slider 9 </option>
 <option value="slider 0">slider 0 </option>
 </select>
    <div id="form-content">
    <ul style="list-style:none;">
     <li> 
      <label for="image path "> Image Path</label>
        <input type="file" name="fwds_imagepath[0]" value="" id ="slidepath" required>
      <label for="image link" > Image link </label>
        <input type="text" name="fwds_imagelink[0]" value="" id="slidelink">
      <label for="image order" > Image order </label>
        <input type="text" name="fwds_imageorder[0]" value="" size="5" id="slideorder">
      <label for="image status" > Status </label>
        <select name="fwds_imagestatus[0]" id="slidestatus">
          <option value="YES" > Show_me</option>
          <option value="NO" > Hide_me</option>
        </select>
      </li>
     </ul>
     </div>

</div>

<input type="button" name="addmore" id="btn-1" value="add more image"> <span class="bt"></span>

<input type="submit" value="create slider" name="submit" onclick="chechthat()">
<input type="button" onclick= "window.location='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_me';"  value="cancel" name="cancel">  
</form>
</div> 


<?php
if(isset($_POST['submit']))
{
	global $wpdb;
       
   
	//$a=$_POST['fwds_imagepath'];

	$a=$_FILES['fwds_imagepath']['name'];
        $ab=$_FILES['fwds_imagepath']['tmp_name']; 
	$b=$_POST['fwds_imagelink'];
	$c=$_POST['fwds_imageorder'];
	$d=$_POST['fwds_imagestatus'];
        $e=$_POST['fwds_type'];          
        $testdir= ABSPATH . "wp-content/uploads/my_own_plugin/";
 
  for($j=0; $j< count($a); $j++)
{
	$ext = $_FILES['fwds_imagepath']['name'][$j]; 
	//$path = md5(rand() * time()) . ".$ext";
	
  move_uploaded_file($_FILES['fwds_imagepath']['tmp_name'][$j] , $testdir .  $ext );  	

}
$i=0;
foreach($b as $as){
global $wpdb;
    $fwds_path=$a[$i];
    $fwds_imagelink=$b[$i];
    $fwds_imageorder=$c[$i];
    $fwds_imagestatus=$d[$i];
    $ext = $_FILES['fwds_imagepath']['name'][$i]; 
    $query ="insert into wp_fwds_plugin (fwds_path, fwds_link, fwds_speed, fwds_order, fwds_status, fwds_type, fwds_height, fwds_width, fwds_date) values ('$fwds_path','$fwds_imagelink','4000' ,'$fwds_imageorder', '$fwds_imagestatus' , '$e' ,'300','700', (select NOW()) )";  
    $wpdb->query($query); 
    $i++;
  
}

?>
<script>
window.location.href="<?php echo get_bloginfo('home');?>/wp-admin/admin.php?page=slide_me"
</script> <?php
}
?>
