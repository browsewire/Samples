
<?php if(isset($_GET['type']))
{
 $type=$_POST['fwds_type'];
 $query="select * from wp_fwds_plugin where fwds_type='$type'";
 $wpdb->get_results($query);
if($wpdb->num_rows == NULL)
{
 echo "you have entered the wrong slider,its not created yet";
}
else
{
 
?>
 <h2><em> <?php echo $type ;?> contains</em> </h2>
<form name="fwds_form_display" method="POST">
<div class="content">

<center>
<table  style="width:80%;">
<thead style="background-color:#E0E0D1;line-height:3;">
<tr>

<th>Slide path</th>
<th>Slide link</th>
<th>Order</th>
<th>height</th>
<th>width</th>
<th>Status</th></tr>
</thead>
<tfoot style="background-color:#E0E0D1;">
<tr>

<th>Slide path</th>
<th>Slide link</th>
<th>Order</th>
<th>height</th>
<th>width</th>
<th>Status</th></tr>
</tfoot>

<tbody style="background-color:#F5F5F0;"> 
<?php 

global $wpdb;

$query="select * from wp_fwds_plugin where fwds_type='$type'";
$mydata=$wpdb->get_results($query);  
foreach ($mydata as $data=>$value)
{
$a=$value->fwds_path;
$b= $value->fwds_link;
$c= $value->fwds_order;
$hei=$value->fwds_height;
$width=$value->fwds_width;
$d= $value->fwds_status;

   ?>

   <tr>                              
                                <td> <center><?php echo $a;?></center></td>
                                <td> <center><?php echo $b ;?></center></td>
                                <td> <center><?php echo $c;?></center></td>
                                <td> <center><?php echo $hei;?></center></td>
                                <td> <center><?php echo $width;?></center></td>
                                <td> <center><?php echo $d;?></center></td>
   </tr>
 
<?php

}
?>
    </tbody>

    </table><center>
<?php wp_nonce_field('fwds_form_show');?>

<input type="hidden" name="fwds_form_display" value="yes"/>
     	<div> </form>
<div>
<div class="edit"> <input type="button" style="font-weight:normal;" name="Edit" value="Edit" size="8"  onclick="window.location='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_me&amp;ac=edit&amp;type=<?php echo $type;?>';" /> 
<?php 

  }
}

?> &nbsp
<input type="button" name=TurnBack" value="Turn Back" value="" onclick="window.location='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=slide_me' ;"/></div>

