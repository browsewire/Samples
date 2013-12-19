<div id="wrap">
<h2><?php echo WP_fwds_TITLE;?></h2>
<h4> Setting</h4>

   <form name="fwds_set" method="POST">
<label for= "slidr type" >Select  Slider  </label> 
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
<p>provide a specific height for your slider<br>e.g : Default<em> 300 px</em></p>
<label for="height">Height</label>
<input name="height" type="text" value="" required><br>
<p>provide a specific width for your slider <br> e.g: Default<em> 700 px</em></p>
<label for ="width"> width</label>
<input type="text" name="width" value="" required>
<p>procider slider speed for sliding <br> e.g Default<em> 4000 </em></p>
<label for="speed">Speed</label>
<input type="text" name="speed" value="" required><br><br>
<input type="submit" name="submit" value="submit" >
<input type="button" name="cancel" value="cancel" onclick="window.location='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_me';" >

</form>
<?php
 if(isset($_POST['submit'])){
 global $wpdb;
 $a=$_POST['height'];
 $b=$_POST['width'];
 $c=$_POST['speed'];
 $d=$_POST['fwds_type']; 
if(!is_numeric(@$a)){@$a= '300';}
if(!is_numeric(@$b)){@$b= '600';}
if(!is_numeric(@$c)){@$c='4000';}
$query=" update wp_fwds_plugin set fwds_height='$a' , fwds_width='$b' , fwds_speed='$c' where fwds_type='$d'";
$wpdb->query($query); 
?>
<script>
window.location.href="<?php echo get_bloginfo('home');?>/wp-admin/admin.php?page=slide_me"
</script>
<?php
}
?>

<div>

