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
                <?php echo $this->Form->input("User.timezone", array("type" => "select", "options" => DateTimeZone::listIdentifiers())); ?>
                <?php echo $this->Form->input("User.secret_question", array("type" => "text")); ?>
                <?php echo $this->Form->input("User.secret_answer", array("type" => "text")); ?>
            </div>
        </div>
    </div>
    <div class="half">
        <div class="block">
            <h3>Avatar</h3>
            <div>
                <img src="<?php echo $this->data["User"]["avatar_url"]; ?>" class="userAvatar">
                <a href="/users/upload_avatar" class="uploadAvatarPhotoLink">Upload Link</a>
                <?php echo $this->Form->input("User.avatar_url", array("type" => "hidden")); ?>
            </div>
        </div>
        <div class="block">
            <h3>User Groups</h3>
            <table>
                <thead>
                    <tr>
                        <td style="width:80%;">Name</td>
                        <td style="width:20%;">Options</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($userGroupMemberships as $userGroupMembership) { ?>
                    <tr>
                        <td><a href="/o/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/user_groups/view/<?php echo $userGroupMembership["UserGroup"]["id"]; ?>"><?php echo $userGroupMembership["UserGroup"]["name"]; ?></a></td>
                        <td>---</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php if(is_array($subscriptions)) { ?>
        <div class="block">
            <h3>Subscriptions</h3>
            <table>
                <thead>
                    <tr>
                        <td style="width:80%;">Name</td>
                        <td style="width:20%;">Options</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($subscriptions as $subscription) { ?>
                    <tr>
                        <td><a href="/o/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/containers/view/<?php echo $subscription["Container"]["id"]; ?>"><?php echo $subscription["Container"]["name"]; ?></a></td>
                        <td><!-- <a href="/o/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/subscriptions/edit/<?php echo $subscription["Subscription"]["id"]; ?>" class="editLink">[Edit]</a> -->---<td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
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
    
    $("body").on("click", ".uploadAvatarPhotoLink", function(e) {
        e.preventDefault();
        var callbackName = "";
        if($(this).data("callback")) {
            callbackName = $(this).data("callback");
        } else {
            callbackName = this.className.split(" ")[0] + "Callback";
        }
        var queryCharacter = ($(this).attr("href").indexOf("?") == -1 ? "?" : "&");
        $dialogIframe = $(document.createElement("iframe"))
            .dialog({
                modal : true,
                resizable : false,
                draggable : false,
                title : "Quick Create/Edit",
                width : 500,
                height: 270
            })
            .css("min-width", 470)
            .attr("src", $(this).attr("href") + queryCharacter + "iframe&callback=" + callbackName);
    });
});

window.uploadAvatarPhotoLinkCallback = function(data) {
    $("UserAvatarUrl").val(data);
    $(".userAvatar").attr("src", data);
    
    $dialogIframe.dialog("close");
};
</script>