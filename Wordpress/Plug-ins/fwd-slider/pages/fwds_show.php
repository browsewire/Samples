<div id="wrap"> 
<?php
if(isset($_GET['id'])){

global $wpdb;
$type = $_GET['id']; 
$a =   "delete from wp_fwds_plugin where fwds_type='$type'";
$query=$wpdb->query($a);
echo '<script>alert("slider deleted succesfully")</script>';


}

?>

<h2><?php echo WP_fwds_TITLE ;?> <a href ="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=add_new">Add New</a></h2>
 

<div id="imagewrap">
<center>
<table width="80%;">
<thead  style="background-color:#E0E0D1;line-height:3;">
<tr>
<th> Slider Name</th>
<th> shortcode</th>
<th> Date</th>
<th> preview</th>
</tr>
</thead>
<tfoot style="background-color:#E0E0D1;">
<tr>
 <th> Slider Name</th>
 <th> shortcode</th>
 <th> Date</th>
<th>preview</th>
</tr>
</tfoot>
  <?php 
    global $wpdb;
$pagenum=$_GET['pagenum'];
if(!isset($pagenum))
  {
  $pagenum=1;
  }
  
  $query="select  distinct fwds_type from wp_fwds_plugin ";
  $wpdb->get_results($query);
  $count_rows=$wpdb->num_rows; 
  $page_row=2;
  $last=ceil($count_rows/$page_row);
  $start=($pagenum-1) * $page_row;
  $data_tolist=$page_row;
     if( $pagenum < 1)
        {
	  $pagenum=1;
	  }
         elseif($pagenum > $last){
	 $paegnum=$last;
	 }


$query = $wpdb->get_results("select distinct fwds_type,fwds_date from wp_fwds_plugin limit $start, $data_tolist");

foreach($query as $a=>$value)
{
$type=$value->fwds_type;
$date=$value->fwds_date;


?>

<tbody style="background-color:#F5F5F0;">
<tr>
 <td> <center><strong><?php echo $type;?>
<div ="row_action">
                             <span class="edit"><a href ="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_me&amp;ac=edit&amp;type=<?php echo $type;?>" >edit</a> </span> &nbsp <span class="delete"><a href="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_me&id=<?php echo $type;?>"> delete</a></span>

 </div>  </center></strong> </td>
 <td><input type="text" value='[fwd_slider type="<?php echo $type ; ?>"]' readonly="readonly" onfocus="this.select();"> </td>
 <td> <?php echo $date;?></td>
<td> <?php 
   echo do_shortcode('[fwds_totest type="'.$type.'" ]');
?>
</tr>

<?php
}?>
<div style=""><?php
echo "Page--$pagenum of $last<br>";


if($pagenum == 1)
{
}
 else{
 ?> <a href="<?php echo get_bloginfo('home');?>/wp-admin/admin.php?page=slide_me&pagenum=<?php echo  1; ?>" >First</a>
<?php
 echo "&nbsp";
 
 $previous=$pagenum-1;
 ?>
 <a href="<?php echo get_bloginfo('home');?>/wp-admin/admin.php?page=slide_me&pagenum=<?php echo $previous;?>">Previous</a><?php
}

if ($pagenum==$last)
{
}
 else
{
$next=$pagenum+1;
?>
<a href="<?php echo get_bloginfo('home');?>/wp-admin/admin.php?page=slide_me&pagenum=<?php echo $next;?>">Next</a>
<?php
echo "&nbsp";
?>
<a href="<?php echo get_bloginfo('home');?>/wp-admin/admin.php?page=slide_me&pagenum=<?php echo $last;?>">Last</a>
<?php
}   
?>
</div>
</tbody>
</table></center>

  </div>

<div>
<h4 style="font-weight:normal;"><input type="button" onclick="window.location='<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=add_new';" name = "add" value="add new">&nbsp<input type="button" name="set" value="setting" tabindex="10" onclick="window.location='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_set';"></h4><br>
<h4>select slider from drop down to know more about it </h4>


<form name="slider_info" action="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_me&amp;ac=info&amp;type=<?php echo $_POST['fwds_type']; ?>"  method="POST">
<label for= "slider type"  style="font-size:17px";>Slider Slide  </label> </strong>
<select name="fwds_type" >
<option value="">select slider type</option>
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
<input type="submit" name="show" value="show">

</form>
</div></div>

