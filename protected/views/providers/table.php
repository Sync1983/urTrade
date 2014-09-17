<?php ?>

<table id="part-items" class="stripe hover">
  <thead>
  <tr class='part-table-head'>    
	<th>Производитель</th>					
	<th>Артикул</th>
	<th>Наименование</th>
	<th>Цена</th>	
	<th>Срок поставки</th>
	<th>В корзину</th>
	<th>Обновление цен</th>		
  </tr>
  </thead>
  <tbody>
<?php foreach ($part_list as $id => $data) {
		/* @var $data Part */
		$row_class = "";
		if(!$data->is_original) {
		  $row_class = "class=\"not-original\"";
		}
?>
  <tr <?php echo $row_class;?>>	  
	  <td><?php echo $data->producer;?></td>					
	  <td><?php echo $data->articul	;?></td>
	  <td><?php echo $data->name	;?></td>
	  <td><?php echo $data->price	;?></td>
	  <td><?php echo $data->shiping	;?></td>
	  <td><a href="#" onclick="AddToBasket(<?php echo "'".$data->provider."','".$data->id."',this"?>)">Заказать</td>
	  <td><?php echo date("d-m-y",$data->update_time);?></td>
  </tr>	  
<?php }	?>
  </tbody>
</table>
