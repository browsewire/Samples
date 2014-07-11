<?php echo $this->Form->create("Subscription"); ?>
<table>
    <thead>
        <tr>
            <th style="width:80%;">Container</th>
            <th style="width:20%;">Subscription Level</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($containers as $container) { if($container["Container"]["is_private"]) {?>
        <tr>
            <td><?php echo $container["Container"]["name"] ?></td>
            <td>
                <?php
                $prices = json_decode($container["Container"]["prices"], true);
                $levels = array(
                        "" => "Not subscribed",
                );
                if(!empty($prices))
                {
                    foreach($prices as $key => $price)
                    {
                        $levels[$key] = $price["name"];
                    }
                }
                else
                {
                    $levels[0] = "Subscribed";
                }
                
                $value = "";
                foreach($container["Subscription"] as $subscription)
                {
                    if($subscription["user_id"] == $this->params["pass"][0])
                    {
                        $value = $subscription["level"];
                    }
                }
                
                echo $this->Form->input("Subscription.{$container["Container"]["id"]}", array("value" => $value, "label" => false, "div" => false, "options" => $levels));
                ?>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>
<?php echo $this->Form->end("Save"); ?>