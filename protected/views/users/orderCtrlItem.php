<?php
  $date = strtotime($row->date);	
  $show_date = date("d-m-y <br> H:i:s", $date);
?>
		<td class="dt-body-center underline">
		  <a href="#" onclick="showControl(this,<?php echo $row->id?>)">
		  <img src="/images/settings.png" width="16px" height="16px"/>
		  </a>
		  <img src="/images/<?php echo $row->is_pay?"coins":"error" ?>.png" width="16px" height="16px"/>
		</td>
		<td class="dt-body-center underline">
		  <?php echo sprintf("%07d", $row->list_id);?>
		</td>				
		<td data-order="<?php echo $row->state;?>"  class="dt-body-center underline">
		  <?php echo $states[$row->state];?>		  
		</td>				
		<td data-order = "<?php echo $row->date;?>" class="dt-body-center underline"><?php echo $show_date;?></td>		
		<td class="dt-body-center underline"><?php echo $row->provider."<br>".$row->stock?></td>		
		<td class="dt-body-center underline"><?php echo $row->articul."<br>".$row->producer."<br>".$row->name;?></td>				
		<td class="dt-body-center underline"><?php echo $row->price."<br>Польз:".$row->user_price;?></td>		
		<td class="dt-body-center underline"><?php echo $row->shiping?></td>		
		<td class="dt-body-center underline"><?php echo ($row->is_original==1)?"Да":"Нет";?></td>				
		<td class="dt-body-center underline"><?php echo "<h6>".$row->count."</h6><br>(уп.".$row->lot_party."шт)"?></td>		
		<td class="dt-body-center underline"><?php echo $row->comment?></td>	
