<table id="basket-table" class="dataTable">
  <thead>  
	<th class="dt-head-center" style="width: 5%;">Добавлено</th>
	<th class="dt-head-center" style="width: 5%;">Производитель</th>
	<th class="dt-head-center" style="width: 5%;">Артикул</th>
	<th class="dt-head-center" style="width: 30%;">Название</th>
	<th class="dt-head-center" style="width: 5%;">Цена, руб.</th>
	<th class="dt-head-center" style="width: 5%;">Срок, дн.</th>
	<th class="dt-head-center" style="width: 10%;">Количество</th>
	<th class="dt-head-center" style="width: 5%;">Сумма, руб.</th>
	<th class="dt-head-center" style="width: 15%;">Комментарий</th>	
  </thead>
  <?php foreach ($basket as $row):	
		/* @var $row Basket */	
	$date = strtotime($row->date);
	$date = date("d-m-y H:i:s", $date);
  ?>  
  <tr id="<?php echo $row->id?>">	
	<td class=" dt-body-center"><?php echo $date ?></td>
	<td class=" dt-body-center"><?php echo $row->producer ?></td>
	<td class=" dt-body-center"><?php echo $row->articul?></td>
	<td class=" dt-body-center"><?php echo $row->name?></td>
	<td class=" dt-body-center"><?php echo $row->price;?></td>
	<td class=" dt-body-center"><?php echo $row->shiping;?></td>
	<td class="basket-count"><?php echo $row->count;?></td>
	<td class="basket-row-sum"><center><b><?php echo $row->price*$row->count?></b></center></td>	
	<td class="basket-comment"><?php echo CHtml::decode($row->commnet);?></td>	
  </tr>
  <?php endforeach; ?>
</table>
