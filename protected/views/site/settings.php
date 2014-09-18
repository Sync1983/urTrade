<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Параметы';
$this->breadcrumbs=array(
	'Параметры',
);
?>

<h1>Данные покупателя</h1>

<p>
Здесь вы можете изменить контактную информацию и установить собственные наценки на покупаемые товары
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'settings-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',array('0' => 'Юр. лицо', '1' => 'Физ. лицо')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'caption'); ?>
		<?php echo $form->textField($model,'caption',array('size'=>100,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'caption'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>100,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sname'); ?>
		<?php echo $form->textField($model,'sname',array('size'=>100,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sname'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'inn'); ?>
		<?php echo $form->textField($model,'inn',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'inn'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'kpp'); ?>
		<?php echo $form->textField($model,'kpp',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'kpp'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'addres'); ?>
		<?php echo $form->textField($model,'addres',array('size'=>100,'maxlength'=>245)); ?>
		<?php echo $form->error($model,'addres'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit',array('value'=>'Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<div id="prices-list">
  <?php   echo $prices; ?>
</div>

<script type="text/javascript">
  function addPriceLine(event){	
	$html = 
	  '<div class="row">'+
	  '	<?php echo CHtml::hiddenField("ids[]",-1); ?>'+
	  '	<?php echo CHtml::textField("names[]",'Имя',array('size'=>15,'maxlength'=>15)); ?>'+
	  '	<?php echo CHtml::textField("values[]",'0',array('size'=>4,'maxlength'=>4)); ?>'+
	  '</div>';
	$("#settings-prices>div.buttons").eq(0).before($html);
	return false;
  }
</script>
	
