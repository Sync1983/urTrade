<ul onclick="ProducerSelect(event,this,'<?php echo $model->part_id?>');">
<?php
    foreach($producers as $name=>$param) {	?>
	  <li id = "<?php echo $name ?>"><?php echo $name ?></li>	  
<?php }?>
</ul>
