<?php 
/* @var $model RequestParts */
?>

<table id="part-items" class="stripe hover">
  <thead>
  <tr class='part-table-head'>    
	<th style="width: 20%;">Производитель</th>					
	<th style="width: 8%;">Артикул</th>
	<th>Наименование</th>
	<th style="width: 12%;">Цена,руб.</th>	
	<th style="width: 8%;">Срок,дн.</th>
	<th style="width: 8%;">Наличие,шт.</th>	
	<th style="width: 9%;">В корзину</th>	
  </tr>
  </thead>
  <tbody>
<?php foreach ($part_list as $id => $data) {
		/* @var $data Part */
		$row_class = "class=\"";
		if($data->is_original) {
		  $row_class .= "original ";
		}
		if($data->shiping==0) {
		  $row_class .= "zero-days ";
		}elseif($data->shiping==1) {
		  $row_class .= "one-days ";
		}
		$row_class .= "\"";
		
		$order = 1;
		if($data->is_original) {
		  $order = 0;
		}
		if(!$data->is_original&&!$model->cross) {
		  continue;
		}
?>
  <tr <?php echo $row_class;?>>	  
	  <td data-order="<?php echo $order;?>"><b><?php echo $data->producer;?></b>		
		  <div class = "row_info">
			<div class="hint">
			  <?php echo $data->info;?>
			</div>			 
		  </div>
		  <div class = "row_party">
			<div class="hint">
			  <?php echo "Заказ партией по $data->lot_party шт.";?>
			</div>			 
		  </div>
		  <div class = "row_time">
			<div class="hint">
			  <?php echo "Обновлено ".date("m-d-y в H:i:s",$data->update_time);?>
			</div>	
		  </div>
	  </td>					
	  <td data-order="<?php echo $order;?>"><?php echo $data->articul	;?></td>
	  <td data-order="<?php echo $order;?>"><?php echo $data->name	;?></td>
	  <td><?php echo $data->price	;?></td>
	  <td><?php echo $data->shiping	;?></td>
	  <td><?php echo $data->count	;?></td>	  
	  <td><a href="#" onclick="AddToBasket(<?php echo "'".$data->provider."','".$data->id."',this"?>)">Добавить</td>	  
  </tr>	  
<?php }	?>
  </tbody>
</table>
