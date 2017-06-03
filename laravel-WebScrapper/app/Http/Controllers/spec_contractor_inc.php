<script>
function updateWebViewClick(id)
{
//$('.phone_number').hide();
dataLayer.push({'event':'contractor-website-click','contractor-id':id});
$.ajax({
	url:'update_phone_click.php?cont_id='+id+'&type=3',
	success: function(){
	$('#popupforwebsite').hide();
	return true;

	}
	});


}
</script>
<?php // Contractor main content
if (!is_numeric($_GET['spc'])) {
	header ("Location http://www.thegoodcontractorslist.com");
}else{
//	    <div id="content">
// get this contractors primary campaign(1) information
	$query = "SELECT campaign.id_num AS 'id',campaign.phone AS 'campaign_phone', campaign.narrative AS 'narr', campaign.heading AS 'cat',
	campaign.page_title AS 'city', ziprad.ZipCode AS 'zip',
	contractor.logo AS 'logo', contractor.bus_name AS 'cont',
	contractor.phone AS 'phone', contractor.ppc_source AS 'ppc_source', contractor.id_num AS 'contID',
	contractor.url AS 'url', heading.heading AS 'hdg'
	FROM campaign, contractor, ziprad, heading
	WHERE heading.id_num = campaign.heading AND campaign.zip = ziprad.ZipCode AND campaign.contractor = contractor.id_num
	AND campaign.active = 1 AND campaign.id_num = {$_GET['spc']}";

	$host="localhost"; // Host name
	$dbusername="gcl_dbuser"; // username
	$dbpassword="#p}T#]os!!TiwW"; // password
	$db_name="gcl_gwscontractor"; // Database name
	define("DOMAIN", "http://www.thegoodcontractorslist.com/");
	$connection = mysqli_connect($host, $dbusername, $dbpassword);
	//DB Connection Error Handling
    if(!$connection) {
        $error = "Unable to Connect to the Database Server";
        print $error;
        exit();
    }
//DB Selection Error Handling
    if(!mysqli_select_db($connection, $db_name)) {
        $error = "Unable to Select $db_name";
        print $error;
        exit();
    }


$result = mysqli_query($connection, $query);


//	$num = mysql_num_rows ($result); // How many listings are there?
$row = mysqli_fetch_array($result);
$scoresql="SELECT  SUM(total) as total, COUNT(id) as count FROM `review` where review.status <= 0 and review.contractor_id =".$row['contID'];
$reviewresult=mysqli_query($connection,$scoresql);
$reviewrow = mysqli_fetch_array($reviewresult);
if($reviewrow['count'] >9){
	$contScore = 'Score: '.round(round($reviewrow['total']/$reviewrow['count'],1)/4,1).'<br /># of Reviews: '.$reviewrow['count'];
}	else {
	$contScore = '';
}
$_SESSION['cat'] = $row['cat'];


$gallerysql = "SELECT * FROM gallery WHERE is_active='1' and campaign_id = ".$_GET['spc'];
$galleryresult = mysqli_query($connection,$gallerysql);
		
?>
<?php include 'includes/partials/profile-view.inc.php'; ?>

<?php
	}

?>
