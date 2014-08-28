<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
/* @var $answer */
/* @var $input*/

$this->pageTitle=Yii::app()->name . ' - Цена и заказ';
$this->breadcrumbs=array(
	'Цена и заказ',
);
?>

<h1>Введите номер запчасти для поиска</h1>

<div class="form">

<?php echo CHtml::form();?>	

	<div class="row">
		<?php echo CHtml::label('Артикул или номер запчасти', 'part_id'); ?>
		<?php echo CHtml::textField('part_id', $part_id,array('size'=>'100%')); ?>
		<?php echo CHtml::ajaxSubmitButton('Найти','' , array(
			'type' => 'POST',
			'update' => '.text',
			),array('style'=>'width:20%','type' => 'submit') 
			); ?>    
    <?php echo CHtml::error($model,'part_id'); ?>
	</div>

<?php /*$this->endWidget();*/echo CHtml::endForm(); ?>

</div><!-- form -->

<div class="text">
	<?php echo $answer ?>
</div>