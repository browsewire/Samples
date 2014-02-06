<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>		
		<div><img src="{{URL::to('/img/logo.png')}} ">	
			<p>Someone, hopefully you, requested that the password for the account associated with this email address ({{$email}}) be reset.
To complete your request, please follow this link:{{URL::to('/')}}/reset?token={{$token}}</p>

		</div>
	</body>
</html>
