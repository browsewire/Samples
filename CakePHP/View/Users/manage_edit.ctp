<?php
if($this->params["action"] == "manage_create")
{

}
else
{
    $this->request->data["User"]["password"] = "";
    $this->request->data["User"]["password2"] = "";
}
?>

<?php echo $this->Form->create("User"); ?>
<div>
    <div class="half">
        <div class="block">
            <h3>General Information</h3>
            <div>
                <?php echo $this->Form->input("User.username"); ?>
                <?php echo $this->Form->input("User.password"); ?>
                <?php echo $this->Form->input("User.password2", array("type" => "password", "label" => "Confirm password")); ?>
                <?php echo $this->Form->input("User.email"); ?>
                <?php echo $this->Form->input("User.name"); ?>
                <div class="input text">
                    <label>Avatar</label>
                    <img src="<?php echo (!empty($this->data["User"]["avatar_url"]) ? $this->data["User"]["avatar_url"] : ""); ?>" class="userAvatar">
                    <?php echo $this->Form->input("User.avatar_url", array("type" => "text", "style" => "width:70%", "div" => false, "label" => false)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="half">
        <?php if($this->params["action"] == "manage_edit") { ?>
        <div class="block">
            <h3>Auto Mailer</h3>
            <div>
                <ul>
                    <li><a href="/manage/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/users/send_invite_email?email=<?php echo $this->data["User"]["email"]; ?>">Send Invitation Email</a></li>
                    <li><a href="/users/password_reset?email=<?php echo $this->data["User"]["email"]; ?>">Send Password Reset Email</a></li>
                </ul>
            </div>
        </div>
        <div class="block">
            <h3>Subscriptions</h3>
            <div class="menu">
                <a href="/manage/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/users/subscriptions/<?php echo $this->params["pass"][0]; ?>">Manage</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width:60%;"></th>
                        <th style="width:10%;">Level</th>
                        <th style="width:30%;">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($subscriptions as $subscription) { ?>
                    <tr>
                        <td><?php echo $subscription["Container"]["name"]; ?></td>
                        <td>---</td>
                        <td><a href="/manage/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/subscriptions/delete/<?php echo $subscription["Subscription"]["id"]; ?>" class="deleteLink">[Delete]</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="block">
            <h3>User Groups</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width:60%;"></th>
                        <th style="width:10%;">Rank</th>
                        <th style="width:30%;">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($userGroupMemberships as $userGroupMembership) { ?>
                    <tr>
                        <td><?php echo $userGroupMembership["UserGroup"]["name"]; ?></td>
                        <td><?php echo $userGroupMembership["UserGroupMembership"]["rank"]; ?></td>
                        <td>---</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <div class="block">
            <h3>Flags</h3>
            <div>
                <?php echo $this->Form->input("User.require_password_change"); ?>
                <?php echo $this->Form->input("User.email_verified"); ?>
            </div>
        </div>
        <div class="block">
            <h3>Other</h3>
            <div>
                <?php echo $this->Form->input("User.timezone", array("type" => "select", "options" => DateTimeZone::listIdentifiers())); ?>
                <?php echo $this->Form->input("User.secret_question", array("type" => "text")); ?>
                <?php echo $this->Form->input("User.secret_answer", array("type" => "text")); ?>
                <?php echo $this->Form->input("User.suspended_until", array("type" => "text", "class" => "date")); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end("Save"); ?>

<script>
$(document).ready(function() {
    $("#UserManageCreateForm, #UserManageEditForm").submit(function(e) {
        if($("#UserPassword").val() !== $("#UserPassword2").val())
        {
            e.preventDefault();
            alert("Passwords do not match!");
        }
    });
    
    $("#UserAvatarUrl").change(function() {
        $(".userAvatar").attr("src", $(this).val());
    });
});
</script>