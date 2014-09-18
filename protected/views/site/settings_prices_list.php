<div class="form">
<?php echo CHtml::form('','POST',array('id'=>'settings-prices')); 
	foreach($prices as $row){
	?>	
	<div class="row">	
		<?php echo CHtml::hiddenField('ids[]',$row['id']); ?>
		<?php echo CHtml::textField('names[]',$row['name'],array('size'=>15,'maxlength'=>15)); ?>
		<?php echo CHtml::textField('values[]',$row['value'],array('size'=>4,'maxlength'=>4)); ?>		
	</div>

<?php } ?>

	<div class="row buttons">
		<?php echo CHtml::button('button-add',array('value'=>'Добавить значение','onClick'=>'addPriceLine(event);')); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Сохранить значения', $this->createURL('/site/settings'), array(
			  'type'  => 'POST',
			  'update' => '#prices-list',
		  ),
		  array(
			'type' => 'submit',
			'class'=>'search-button',
            'id'=>'submit-button',
		  )); 
		?>
	</div>

<?php echo CHtml::endForm(); ?>
</div>


