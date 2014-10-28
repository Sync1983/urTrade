<table id="billing-table" class="dataTable"> 
  <thead>
    <tr>
      <th class="center" style="width:15%">Дата платежа</th>
      <th class="center" style="width:15%">Номер заказа</th>
      <th class="center" style="width:30%">Сумма</th>
      <th class="center">Комментарий</th>
    </tr>    
  </thead>
  <tbody>
    <?php foreach ($list as $row):
		  /* @var $row Billing */		  
	?>	
	<tr class="<?php	echo ($row->value<0)?"zero-days":"";?>">            
	  <td class="center"><?php echo $row->time;?></td>
	  <td class="center"><?php echo sprintf("%07d", $row->order_id);?></td>
	  <td class="center"><?php echo $row->value;?> руб.</td>
	  <td class="center"><?php echo $row->comment;?></td>
    </tr>    
    <?php endforeach;?>
  </tbody>
</table>




