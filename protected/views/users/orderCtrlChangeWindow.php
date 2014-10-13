<h5 draggable="true" ondragstart="window_drag_start(event);" ondrag="window_drage(event);">Управление записью 
  <a href="#" onclick="closeWindow();">Закрыть</a>
</h5>
  <?php $change_form = $this->beginWidget('CActiveForm', array(
    'id'=>'change-form',
	'action'=>Yii::app()->createUrl('users/ChangeOrderState'),
    'enableAjaxValidation'=>false,
        'clientOptions'=>array('validateOnSubmit'=>false, 'validateOnChange'=>false),
	)); 
  ?>
	<div class="row">
	  <?php echo $change_form->hiddenField($model,'id'); ?>
	</div>  
	<div class="row">
	  <?php echo $change_form->labelEx($model,'is_pay');?>
	</div>
	<div class="row">
	  <?php echo $change_form->dropDownList($model,'is_pay',array(0=>'Не оплачено',1=>'Оплачено'),array('disabled'=>true));?>
	</div>  
	<div class="row">
	  <?php echo $change_form->labelEx($model,'state');?>
	</div>
	<div class="row">
	  <?php echo $change_form->dropDownList($model,'state',$states);?>	  
	</div>  	
	<div id="row">
	  <?php echo $change_form->labelEx($model, "date");?>
	</div>
	<div id="row">
	<?php echo $change_form->dateField($model,"date"); ?>
	</div>
	<div id="row">	  
	  <?php echo $change_form->labelEx($model,'count');?>
	</div>
	<div class="row">
	  <?php echo $change_form->numberField($model,'count',array('step'=>$model->count_step,'min'=>'0'));?>
	</div>  
	<div id="row">	  
	  <?php echo $change_form->labelEx($model,'price');?>
	</div>
	<div class="row">
	  <?php echo $change_form->numberField($model,'price');?>
	</div>  
	<div id="row">	  
	  <?php echo $change_form->labelEx($model,'user_price');?>
	</div>
	<div class="row">
	  <?php echo $change_form->numberField($model,'user_price',array('disabled'=>true));?>
	</div>		
	<div id="row">	  
	  <?php echo $change_form->labelEx($model,'comment');?>
	</div>
	<div class="row">
	  <?php echo $change_form->textField($model,'comment');?>
	</div>		
	<?php if(!$model->is_pay):?>	
	<div id="row">	  
	  <?php 
		echo $change_form->labelEx($model, "change_billing");
		 echo CHtml::activeCheckBox($model, "change_billing",array('uncheckValue'=>NULL,'value'=>1));
	  ?>
	</div>
	<?php endif;?>
  </div>
  <div class="footer">
	<center>
	<?php 
	  echo HtmlHelper::AjaxButton("Сохранить", "saveWindow();",'save-button');	
	 echo HtmlHelper::AjaxButton("Отмена", "closeWindow();");
	?>	  
	</center>
  </div>
  <?php $this->endWidget(); ?>
