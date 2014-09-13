<ul class="producer-list">
<?php
    foreach($producers as $name=>$param) {
	  echo "<li><input type=\"checkbox\" name=\"$name\">$name</li>";
	}
?>
</ul>

