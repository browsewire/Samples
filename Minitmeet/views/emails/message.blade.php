<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Minitmeet</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css"> 
	.ReadMsgBody { width: 100%;}
	.ExternalClass {width: 100%;}

	p{
		margin:0 0 15px 0;
		padding:0;
		 font-family: 'futura_md_btmedium';
	}
	body{
   color: #000000;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    letter-spacing: 0.7px;
    line-height: 25px;
    margin: 0;
    padding: 0;
	}
</style>

</head>
<body bgcolor="#333333">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333">
	<tr>
		<td valign="top" align="center">
    
    	<br>
			<table width="620" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
				<tr>
        	<td align="left" width="10">&nbsp;</td>
          <td align="left" valign="bottom" width="600">
          	
            
            <table width="600" style=" padding-top:10px;" border="0" cellspacing="0" cellpadding="0">
              <tr> @if($plan=="A")
								<td style="font-size:1px;" align="left"><a href="#"><img src="{{URL::to('/img/header4.png')}}" alt="Minitmeet" title="Minitmeet"></a></td>
                   @endif
                   @if($plan=="B")
								<td style="font-size:1px;" align="left"><a href="#"><img src="{{URL::to('/img/header2.png')}}" alt="Minitmeet" title="Minitmeet"></a></td>
                   @endif
                   @if($plan=="C")
								<td style="font-size:1px;" align="left"><a href="#"><img src="{{URL::to('/img/header3.png')}}" alt="Minitmeet" title="Minitmeet"></a></td>
                   @endif
              </tr>
              <tr>
              	<td class="article-title" height="45" valign="top" style="color:#013413; font-size:18px;  padding:10px 12px 0; text-align: center;" width="100%" colspan="2">
									Welcome and Thank You for registering with Minitmeet.
								</td>
              </tr>
              <tr>
              	<th align="left" style="border: 1px solid #CCCCCC; float: left; margin-bottom: 10px; padding: 20px 20px 0; text-align: left; width: 93%;">
							<p>Please keep your login information stored for future use:<br>
			Login: {{$data['username']}}<br>
			Password: {{$pass}}</p>
</th>
              </tr>
              <tr>
              	<td class="article-title" height="45" valign="top" style="color:#013413; font-size:14px;  padding:10px 12px 0; text-align: center;" width="100%" colspan="2">
									You have Choosen Plan {{$plan}}.   
								</td>
              </tr>

            </table>

            
          </td>
          
				</tr>
			</table>
     
		</td>
	</tr>
</table>

</body>
</html>
