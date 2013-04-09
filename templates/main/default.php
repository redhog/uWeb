<div class="object">
 <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "object", $_GET["action"], "php")); ?>
</div>
<div class="children">
 <?php require(findTemplateServerPath($_SERVER["PATH_INFO"], "children", $_GET["action"], "php")); ?>
</div>
