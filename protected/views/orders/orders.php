<?php
$this->pageTitle=Yii::app()->name . ' - Заказы';
$this->breadcrumbs=array(
	'Заказы',
);
$classes = array(
		0 => "wait",
		1 => "in-work",
		2 => "in-place",
		3 => "recived",
		4 => "depr");
?>
<h6>Позиции в заказе</h6>
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
  <?php foreach ($orders as $list_id=>$row):
	/* @var $row Orders */	
	$show_price = Yii::app()->user->convertPrice($row->price);	
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
	<td class="dt-body-center underline"><?php echo $show_price?></td>	
	<td class="order-row-sum underline"><center><b><?php echo $show_price*$row->count?></b></center></td>	
	<td class="order-comment underline"><?php echo CHtml::decode($row->comment);?></td>	
  </tr>  
  <?php endforeach; ?>
  </tbody>
</table>

<script type="text/javascript">
  $(document).ready(
	function(){	  
	  var order_table = $("#order-table").DataTable({
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
		"order": [[ 2, 'asc' ]],
		"columns": [
		  { "orderable": true },
		  { "orderable": true },	  
		  { "orderable": true },
		  { "orderable": true },  
		  { "orderable": true },
		  { "orderable": true },
		  { "orderable": true },
		  { "orderable": true },
		  { "orderable": true }		  
		] 
	  });
	});
</script>
