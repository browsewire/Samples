<?php
$modelName = array_keys($this->params["models"]);
$modelName = $modelName[0];
?>

<div class="block">
    <h3><?php echo Inflector::pluralize($modelName); ?></h3>
    <div class="menu">
        <a href="/manage/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/<?php echo $this->params->controller; ?>/create" class="addLink">Create <?php echo $modelName; ?></a>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:5%"></th>
                <th style="width:10%">ID#</th>
                <th style="width:25%">Name</th>
                <th style="width:20%">Last Login</th>
                <th style="width:20%">Created</th>
                <th style="width:20%">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($results as $result) { ?>
            <tr>
                <td><input type="checkbox" id="event<?php echo $result[$modelName]["id"]; ?>CheckBox"></td>
                <td><?php echo $result[$modelName]["id"] ?></td>
                <td><a href="/manage/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/<?php echo $this->params->controller; ?>/edit/<?php echo $result[$modelName]["id"]; ?>"><?php echo $result[$modelName]["name"] ?></a></td>
                <td><?php echo (!empty($result[$modelName]["last_login"]) ? $result[$modelName]["last_login"] : "NEVER"); ?></td>
                <td><?php echo $result[$modelName]["created"] ?></td>
                <td>
                    <a href="/manage/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/<?php echo $this->params->controller; ?>/delete/<?php echo $result[$modelName]["id"]; ?>" class="deleteLink">[Delete]</a>
                    <a href="/manage/<?php echo $this->Session->read("CurrentOrganization.slug"); ?>/<?php echo $this->params->controller; ?>/edit/<?php echo $result[$modelName]["id"]; ?>" class="editLink">[Edit]</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>