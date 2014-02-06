<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    
    $('#success').hide();

   
$('button').click(function () {

	$.post('create_result.php', $('form').serialize(), function () {
		$('div#wrapper').fadeOut( function () {

        $('#success').show();

		});
	});
	return false;
});
});





</script>



<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generate PDF with PHP</title>

    
    
<style type="text/css">
body {
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.registration_form {
	margin:0 auto;
	width:500px;
	padding:14px;
}
label {
	width: 5em;
	float: left;
	margin-right: 0.5em;
	display: block
}


button {
	float:right;
	border:1px solid #B7DDF2;
	color:#666666;
	
}


fieldset {
	background:#EBF4FB none repeat scroll 0 0;
	border:2px solid #B7DDF2;
	width: 500px;
	margin-top:10px;

-moz-border-radius: 5px;
-webkit-border-radius: 5px;

}
legend {
	color: #fff;
	background: #80D3E2;
	border: 1px solid #781351;
	padding: 2px 6px
}
.elements {
	padding:10px;
}
p {
	border-bottom:1px solid #B7DDF2;
	color:#666666;
	font-size:11px;
	margin-bottom:20px;
	padding-bottom:10px;
}

input{
	border:1px solid #B7DDF2;
-moz-border-radius:3px;
-webkit-border-radius:3px;
}


#success {
    	background:#EBF4FB none repeat scroll 0 0;
	border:2px solid #B7DDF2;
	width: 500px;
	margin-top:10px;
    -moz-border-radius:5px;
-webkit-border-radius:5px;
}
</style>

</head>
<body>
<div id="main" align="center">
<div id="success"><p> Please <a href="result.pdf">download </a> your results in PDF Version . </p></div>
<div id="wrapper">



<form action="index.php"  method="post" class="registration_form">
  <fieldset>
    <legend>Personal Information </legend>

    <div class="elements">
      <label for="name">Name :</label>
      <input type="text" name="name" value="Hyder Bangash" size="25" />
    </div>
    <div class="elements">
      <label for="e-mail">E-mail :</label>
      <input type="text" name="e-mail" value="admin@youhack.me" size="25" />
    </div>
   <div class="elements">
      <label for="e-mail">Address : </label>
      <input type="text" name="Address" value="Henrietta Rd" size="25" />
    </div>
  <div class="elements">
      <label for="e-mail">City  : </label>
      <input type="text" name="City" value="Vacoas" size="25" />
    </div>
    
      <div class="elements">
      <label for="e-mail">Country  : </label>
      <input type="text" name="Country" value="Mauritius" size="25" />
    </div>
    
 
  </fieldset>
  
  
  <fieldset>
    <legend>Results  </legend>

    <div class="elements">
      <input type="text" name="subjects[]" value="Maths" size="25" />
      <input type="text" name="Marks[]" value="50" size="10" />
    </div>
    <div class="elements">
      <input type="text" name="subjects[]" value="English" size="25" />
      <input type="text" name="Marks[]" value="10" size="10" />
    </div>
   <div class="elements">
     <input type="text" name="subjects[]" value="French" size="25" />
     <input type="text" name="Marks[]" value="65" size="10" />
    </div>
  <div class="elements">
    <input type="text" name="subjects[]" value="Science" size="25" />
    <input type="text" name="Marks[]" value="80" size="10" />
    </div>
  <div class="elements"></div>
    <div class="submit">
        <input type="hidden" value="submitted" />
	<button type="submit">Submit</button>
    </div>
  </fieldset>
</form>
</div>
</div>



</body>
</html>
