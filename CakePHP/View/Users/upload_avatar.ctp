<link rel="stylesheet" type="text/css" href="/files/3rdparty/uploadify/uploadify.css" />

<div>Click the select file button to start the upload.</div>
<br>
<?php echo $this->Form->input("file", array("div" => false, "label" => false)); ?>

<script>
$(document).ready(function() {
    $("#file").uploadify({
        height : 100,
        width : "90%",
        fileSizeLimit : "100MB",
        multi : false,
        uploadLimit : 1,
        fileTypeExts : "*.gif; *.jpg; *.png",
        swf : "/files/3rdparty/uploadify/uploadify.swf",
        uploader : "<?php echo ($this->Session->check("CurrentOrganization") ? "/o/{$this->Session->read("CurrentOrganization.slug")}" : null); ?>/users/upload_avatar.json",
        onUploadSuccess : function(file, data, response) {
            <?php if(!empty($this->params->query["callback"])) { ?>
            if(typeof window.parent["<?php echo $this->params->query["callback"]; ?>"] == "function") {
                window.parent["<?php echo $this->params->query["callback"]; ?>"]($.parseJSON(data).response.uri);
            }
            <?php } ?>
        }
    });
});
</script>