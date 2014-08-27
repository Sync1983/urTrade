<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
/* @var $answer */

$this->pageTitle=Yii::app()->name . ' - Управление клиентами';
$this->breadcrumbs=array(
	'Управление клиентами',
);
?>

<h1>Управление клиентами</h1>

<div class="form">
<?php echo CHtml::beginForm(); ?>
<table>
<tr><th>Номер</th><th>Имя</th><th>Почта</th><th>Роль</th>
  <th>Наценка</th><th>Время доставки</th><th>Телефон</th><th>Адрес доставки</th>
</tr>
<?php foreach($items as $i=>$item): ?>
<tr>  
<td><?php echo $item['id'];               ?></td>
<td><?php echo $item['username'];         ?></td>
<td><?php echo $item['email'];            ?></td>
<td><?php echo $item['role'];             ?></td>
<td><?php echo $item['price_percent'];    ?></td>
<td><?php echo $item['shiping_time'];     ?></td>
<td><?php echo $item['phone'];            ?></td>
<td><?php echo $item['shiping'];          ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->

<div class="text">

</div>