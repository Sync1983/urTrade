<ul onclick="ProducerSelect(event,this);">
<?php
    foreach($producers as $name=>$param) {	?>
	  <li id="<?php echo $name ?>"><?php echo $name ?></li>	  
<?php }?>
</ul>
