<?php echo $this->Form->create("UserGroupMembership"); ?>
<table>
    <thead>
        <tr>
            <th style="width:80%;">User Group</th>
            <th style="width:20%;">Rank</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($userGroups as $userGroup) { ?>
        <tr>
            <td><?php echo $userGroup["UserGroup"]["name"] ?></td>
            <td>
                <?php echo $this->Form->input("Subscription.{$userGroup["UserGroup"]["id"]}", array("value" => $value, "label" => false, "div" => false, "options" => range(0, 100), "empty" => "")); ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $this->Form->end("Save"); ?>