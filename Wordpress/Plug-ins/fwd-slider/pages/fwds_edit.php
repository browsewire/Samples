
<div id="wrap">


<script>
function dothis()
{
 window.location="<?php echo get_bloginfo('home');?>/wp-admin/admin.php?page=slide_me";
}
</script>
<?php 
if(isset($_POST['update']))
{  
	extract($_POST);
	foreach($_POST as $key=>$value)
       {
	$a = explode("_",$key);
	$key_id[]=$a[1];
       }

$key_id_unique=array_unique($key_id);
foreach($key_id_unique as $val)
 {
   if(is_numeric($val))
    {
        $path="imagepath_".$val;
	$link="imagelink_".$val;
	$order="imageorder_".$val;
	$status="imagestatus_".$val;

      $ab=$_FILES[$path]['name'];
       
         $af=$_FILES[$path]['tmp_name'];
         $name=$_POST[$path]; 
	 $ac=$_POST[$link];
         $ad=$_POST[$order];
	 $ae=$_POST[$status];
         $testdir= ABSPATH . "wp-content/uploads/my_own_plugin/";
       @chmod($testdir,0777);
        $ext=$_FILES[$path]['name']; 
	//$path = md5(rand() * time()) . ".$ext";
	 move_uploaded_file($_FILES[$path]['tmp_name'] , $testdir .  $ext );  	

     

     $query= " update wp_fwds_plugin set fwds_path='$ext' ,fwds_link='$ac' ,  fwds_order='$ad', fwds_status= '$ae' where fwds_id='$val'"; 
    
     $que=$wpdb->query($query);
  }
 }


 ?>
<script>
window.location="<?php echo get_bloginfo('home');?>/wp-admin/admin.php?page=slide_me";
</script><?php
}

?>


<h1><?php echo WP_fwds_TITLE;?></h1><h4><em>Edit <?php echo $_GET['type'];?></em></h4>

<?php 

  global $wpdb;
  $type = $_GET['type'];
   
 if($_GET['type']=="GROUP1")
{  echo "This slider is just for the demo purpose, you cann't edit this";
 ?> <input type="button" name=TurnBack" value="Turn Back" value="" onclick="window.location='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_me' ;"/><?php
 }
  else
{ 
 
  $query="select * from wp_fwds_plugin where fwds_type='$type'";
  $a=$wpdb->get_results($query);

 foreach($a as $b=>$value)
 {
  $path =  $value->fwds_path;
  $link = $value->fwds_link;
  $order= $value->fwds_order;
  $status=$value->fwds_status;

?>
<form name="edit_my_info" method="POST" style="width:90%;" enctype="multipart/form-data">

<img src= "<?php echo bloginfo('home');?>/wp-content/uploads/my_own_plugin/<?php echo $path;?>" style ="height:100px;width:150px;overflow:hidden; border-radius: 15px 15px 15px 15px;"/>
        <input type="file" name="imagepath_<?php echo $value->fwds_id; ?>" value="<?php echo $path;?>" size="1" id ="slidepath" >
      <label for="image link" > Image link </label>
        <input type="text" name="imagelink_<?php echo $value->fwds_id; ?>" value="<?php echo $link;?>" id="slidelink" size="10">
      <label for="image order" > Image order </label>
        <input type="text" name="imageorder_<?php echo $value->fwds_id; ?>" value="<?php echo $order;?>" size="5" id="slideorder">
      <label for="image status" > Status </label>
        <select name="imagestatus_<?php echo $value->fwds_id; ?>" id="slidestatus" value="<?php echo $status;?>">
          <option value="YES" > Show_me</option>
          <option value="NO" > Hide_me</option>
        </select><br/>


<div id="button" style="float:right;">
<input type="submit" name="update" value="update" >
<input type="button" onclick = "dothis()" name="cancel" value="cancel">
</div>
</form>
<?php
echo "<br>";}
}
?>
</div>



