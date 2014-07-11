<?php echo $this->Form->create("User"); ?>
<?php echo $this->Form->input("User.password"); ?>
<?php echo $this->Form->input("User.password2", array("type" => "password")); ?>
<?php echo $this->Form->end("Save"); ?>

<script>
$(document).ready(function() {
    $("#UserChangePasswordForm").submit(function(e) {
        if($("#UserPassword").val() !== $("#UserPassword2").val())
        {
            e.preventDefault();
            alert("Passwords do not match!");
        }
    });
});
</script>