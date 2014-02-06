<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>		
		<div>
		{{$minute->first_name.' '. $minute->last_name}} whose email address is {{$minute->email}} has asked us to send this email to you. This task has been updated to: COMPLETED status

Task Details:
{{$taskdetail}}

If you feel that you have received this email in an error or if this is an attempt to spam your mailbox then please forward this email to us at support@minitmeet.com. We will contact {{$minute->first_name.' '. $minute->last_name}} whose email address is {{$minute->email}} on your behalf to resolve the issue.

Thank You,

MinitMeet
A Smart and Effective way to manage your meetings.

</div>
	</body>
</html>
