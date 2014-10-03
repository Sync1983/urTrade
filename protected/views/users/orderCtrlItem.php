<?php
  $date = strtotime($row->date);	
  $show_date = date("d-m-y <br> H:i:s", $date);
  $classes = array(
		0 => "wait",
		1 => "in-work",
		2 => "in-place",
		3 => "recived",
		4 => "depr");
  $states = array(
			0 => 'Ожидает заказа',
			1 => 'Заказан',
			2 => 'На складе',
			3 => 'Выдан',
			4 => 'Отказ'		
	);
?>
		<td class="dt-body-center underline">
		  <?php echo CHtml::dropDownList( "state_".$row->id, 
										  $row->state, 
										  $states,
										  array(
											'onchange' => 'selectorChange(this)',
											'class'	=> 'small'
										  )
			  );?>
		  <br>
		  <?php echo HtmlHelper::AjaxButton("Записать", "saveItem($row->id,'state_$row->id')",'saveItemButton')?>
		</td>				
		<td class="dt-body-center underline"><?php echo $show_date;?></td>		
		<td class="dt-body-center underline"><?php echo $row->provider."<br>".$row->stock?></td>		
		<td class="dt-body-center underline"><?php echo $row->articul."<br>".$row->producer."<br>".$row->name;?></td>				
		<td class="dt-body-center underline"><?php echo $row->price?></td>		
		<td class="dt-body-center underline"><?php echo $row->shiping?></td>		
		<td class="dt-body-center underline"><?php echo ($row->is_original==1)?"Да":"Нет";?></td>				
		<td class="dt-body-center underline"><?php echo "<h6>".$row->count."</h6><br>(уп.".$row->lot_party."шт)"?></td>		
		<td class="dt-body-center underline"><?php echo $row->comment?></td>	
