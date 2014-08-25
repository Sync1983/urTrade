<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
/* @var $answer */

$this->pageTitle=Yii::app()->name . ' - Цена и заказ';
$this->breadcrumbs=array(
	'Цена и заказ',
);
?>

<h1>Введите номер запчасти для поиска</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'1А ртикул или номер запчасти'); ?>
		<?php echo $form->textField($model,'part_id'); ?>
		<?php echo $form->error($model,'part_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Найти'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="text">
	<?php echo $answer ?>
</div>