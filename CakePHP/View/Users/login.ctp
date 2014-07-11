<?php echo $this->Form->create("User", array("url" => $this->here)); ?>
<?php echo $this->Form->input("User.email"); ?>
<?php echo $this->Form->input("User.password"); ?>
<?php echo $this->Form->end("Login"); ?>