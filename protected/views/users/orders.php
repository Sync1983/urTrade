<?php
$classes = array(
		0 => "wait",
		1 => "in-work",
		2 => "in-place",
		3 => "recived",
		4 => "depr");
?>
<table id="order-table" class="dataTable">
  <thead> 	
	<th class="dt-head-center" style="width: 1%;">Номер</th>
	<th class="dt-head-center" style="width: 1%;">Номер заказа</th>
	<th class="dt-head-center" style="width: 1%;">Статус</th>
	<th class="dt-head-center" style="width: 1%;">Ожидается</th>	
	<th class="dt-head-center" style="width: 50%;">Деталь</th>
	<th class="dt-head-center" style="width: 10%;">Количество</th>
	<th class="dt-head-center" style="width: 5%;">Цена, руб.</th>
	<th class="dt-head-center" style="width: 5%;">Сумма, руб.</th>
	<th class="dt-head-center" style="width: 3%;">Комментарий</th>
  </thead>
  <tbody>
  <?php foreach ($orders as $row):	
		/* @var $row Orders */
		$date = strtotime($row->date);	
		$show_date = date("d-m-y", $date);
  ?>      
  <tr class = "<?php echo $classes[$row->state];?>">
	<td class="dt-body-center underline"><?php echo sprintf("%07d", $row->id); ?></td>
	<td class="dt-body-center underline"><?php echo sprintf("%07d", $row->list_id); ?></td>
	<td class="dt-body-center underline"><?php echo $states[$row->state]; ?></td>
	<td class="dt-body-center underline"><?php echo $show_date; ?></td>
	<td class="dt-body-center underline"><?php echo $row->producer." <b>".$row->articul."</b><br>".$row->name?></td>	
	<td class="dt-body-center underline"><?php echo $row->count?></td>
	<td class="dt-body-center underline"><?php echo $row->price?></td>	
	<td class="order-row-sum underline"><center><b><?php echo $row->price*$row->count?></b></center></td>	
	<td class="order-comment underline"><?php echo CHtml::decode($row->comment);?></td>	
  </tr>
  <?php endforeach; ?>  
  </tbody>
</table>
