<?php
$this->pageTitle=Yii::app()->name . ' - Баланс';
$this->breadcrumbs=array(
	'Баланс',
);
?>
<table id="billing-table" class="stripe hover">
  <caption><h3>Ваши платежи</h3></caption>
  <thead>
    <tr>
      <td class="center" style="width:15%">Дата платежа</td>
      <td class="center" style="width:30%">Сумма</td>
      <td class="center">Комментарий</td>      
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

<script type="text/javascript">
  $(document).ready(
	function(){
	  item_table = $("#billing-table").DataTable({
		paging: true,
		"lengthMenu": [ [25, 50, 100, -1], [25, 50, 100, "Все"] ],
		language: {
		  search: "Найти в таблице:",	
		  "emptyTable":     "Нет доступных данных для таблицы",
		  "info":           "Показаны с _START_ по _END_ из _TOTAL_ записей",
		  "infoEmpty":      "Таблица пуста",
		  "infoFiltered":   "(filtered from _MAX_ total entries)",
		  "infoPostFix":    "",
		  "thousands":      ".",
		  "lengthMenu":     "Show _MENU_ entries",		  
		  "zeroRecords":    "Записей не найдено",
		  "paginate": {
			"first":      "Начало",
			"last":       "Конец",
			"next":       "Следующая",
			"previous":   "Предыдущая"
		  }
		},
		"order": [[0, 'asc' ]]		
	  });
	}
  );
</script>




