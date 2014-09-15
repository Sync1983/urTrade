<div class="provider-select-all">
  <input type="checkbox" id="select-all" onClick="onSelectAll();return true;"/><label for="select-all">Выбрать все</label>
</div>
<?php echo CHtml::form('','POST',array('id'=>'request-parts'));?>
<ul class="producer-list">
<?php
    foreach($producers as $name=>$param) {	?>
	  <li>
		<input type="checkbox" id="<?php echo $name ?>" name="names[]" value="<?php echo $name ?>">
		<label for="<?php echo $name ?>"><?php echo $name ?></label></li>	  
<?php }?>
</ul>

<?php
	  echo CHtml::ajaxLink ("Показать",
                              $this->createUrl('provider/LoadParts'), 
                              array(
								'update' => '#answer-table',
								'type'   => 'POST',
								'beforeSend'=> 'function(){ $(".preloader").addClass("show"); }',
								'complete'	=> 'function(){ $(".preloader").removeClass("show"); }',
							  ),
							  array(
								'class'=>'select-button',
								'id'=>'select-provider',	  
							  )
			  );
	  
	  echo CHtml::endForm(); 
?>

<script type="text/javascript">
  function onSelectAll() {	
	if($("#select-all").prop('checked')) {
	  $("input[name='names[]']").prop('checked',true);	
	}else {
	  $("input[name='names[]']").prop('checked',false);	  
	}
	return false;
  }
</script>
