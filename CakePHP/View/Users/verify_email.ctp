Please enter the code provided in your email to verify your account:
<form>
    <input type="text" name="token">
    <input type="submit" value="Verify">
</form>
<a href="/users/send_verification_email/<?php echo $this->Session->read("CurrentUser.id"); ?>">Click here if you need the email resent</a>