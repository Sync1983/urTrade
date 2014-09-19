<?php 
/* @var $model RequestParts */
?>
<h6>Цены показаны с выбранной наценкой в <?php $price =  intval($price); echo $price; ?>%</h6>
<table id="part-items" class="stripe hover">
  <thead>
  <tr class='part-table-head'>    
	<th style="width: 20%;">Производитель</th>					
	<th style="width: 10%;">Артикул</th>
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
		$show_price = Yii::app()->user->convertPrice($data->price);
		$show_price += round($show_price*$price/100,2); 
		$show_shiping = Yii::app()->user->convertShiping($data->shiping);
?>
  <tr <?php echo $row_class;?>>	  
	<td data-order="<?php echo $order;?>"><a href="#" onclick="addToFilter(this);"><?php echo $data->producer;?></a>		  
		  <div class = "row_party">
			<div class="hint">
			  <?php echo "Заказ партией по $data->lot_party шт.";?>
			</div>			 
		  </div>
		  <div class = "row_time">
			<div class="hint">
			  <?php echo "Обновлено ".date("d-m-y в H:i:s",$data->update_time);?>
			</div>	
		  </div>
		  <?php if($data->info!=""):?>
			<div class = "row_info">			
			  <div class="hint">
				<?php echo $data->info;?>
			  </div>			
			</div>
		  <?php endif ?>
	  </td>					
	  <td data-order="<?php echo $order;?>">
		<a href="#" onclick="addToFilter(this);"><?php echo $data->articul;?></a>
		<?php if(!$data->is_original):?>
		  <a href="#" onclick="addToSearch('<?php echo $data->articul;?>');">
			<div class="articul-search">
			  <div class="hint">Искать артикул</div>			  
			</div>
		  </a>		
		<?php endif ?>
	  </td>
	  <td data-order="<?php echo $order;?>"><a href="#" onclick="addToFilter(this);"><?php echo $data->name	;?></a></td>
	  <td><?php echo $show_price	;?></td>
	  <td><?php echo $show_shiping	;?></td>
	  <td><?php echo $data->count	;?></td>	  
	  <td><a href="#" onclick="AddToBasket(<?php echo "'".$model->part_id."','".$data->maker_id."','".$data->provider."','".$data->id."',this"?>)">Добавить</td>	  
  </tr>	  
<?php }	?>
  </tbody>
</table>
