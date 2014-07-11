<?php echo $this->Form->create("User"); ?>
<div class="block">
    <h3>General Information</h3>
    <div>
        <?php echo $this->Form->input("User.username"); ?>
        <?php echo $this->Form->input("User.password"); ?>
        <?php echo $this->Form->input("User.password2", array("type" => "password", "label" => "Confirm password")); ?>
        <?php echo $this->Form->input("User.email"); ?>
        <?php echo $this->Form->input("User.name"); ?>
        <?php echo $this->Form->input("User.country_code", array("label" => "Country", "options" => Countries::GetCodesWithCountries())); ?>
        
        <?php echo $this->Form->input("User.timezone", array("type" => "select", "options" => DateTimeZone::listIdentifiers())); ?>
        <?php echo $this->Form->input("User.secret_question", array("type" => "text")); ?>
        <?php echo $this->Form->input("User.secret_answer", array("type" => "text")); ?>
        <?php
        $termsOfService = $this->element("terms_of_service");
        if(!empty($termsOfService))
        {
            echo $this->Form->input("User.terms_of_service", array("type" => "textarea", "value" => $termsOfService, "readonly" => true));
            echo $this->Form->input("User.accept_terms_of_service", array("type" => "checkbox"));
        }
        ?>
    </div>
</div>
<?php echo $this->Form->end("Save"); ?>

<script>
$(document).ready(function() {
    $("#UserRegisterForm").submit(function(e) {
        if($("#UserPassword").val() !== $("#UserPassword2").val())
        {
            e.preventDefault();
            alert("Passwords do not match!");
        }
    });
});
</script>