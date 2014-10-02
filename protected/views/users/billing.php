<table id="billing-table" class="dataTable"> 
  <thead>
    <tr>
      <th class="center" style="width:15%">Дата платежа</th>
      <th class="center" style="width:30%">Сумма</th>
      <th class="center">Комментарий</th>
    </tr>    
  </thead>
  <tbody>
    <?php foreach ($list as $row):
		  $class = "";
		  if($row[1]<0){
			$class = "zero-days";
		  }?>	
	<tr class="<?php	echo $class;?>">            
	  <td class="center"><?php echo $row[0];?></td>
	  <td class="center"><?php echo $row[1];?> руб.</td>
	  <td class="center"><?php echo $row[2];?></td>
    </tr>    
    <?php endforeach;?>
  </tbody>
</table>




