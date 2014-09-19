<?php
$this->pageTitle=Yii::app()->name . ' - Корзина';
$this->breadcrumbs=array(
	'Корзина',
);
?>
<h6>Позиции</h6>
<table id="basket-table" class="stripe hover">
  <thead>
	<th></th>
	<th>Добавлено</th>
	<th>Производитель</th>
	<th>Артикул</th>
	<th>Название</th>
	<th>Цена, руб.</th>
	<th>Срок, дн.</th>
	<th>Количество</th>
	<th>Сумма, руб.</th>
	<th>Комментарий</th>
	<th></th>
	<th></th>
  </thead>
  <?php foreach ($basket as $row):	
		/* @var $row Basket */
	$show_price = Yii::app()->user->convertPrice($row->price);	
	$show_shiping = Yii::app()->user->convertShiping($row->shiping);	
	$date = strtotime($row->date);
	$date = date("d-m-y H:i:s", $date);
  ?>  
  <tr>
	<td>
	  <input type="checkbox" name="<?php echo $row->id?>"/>
	</td>
	<td><?php echo $date ?></td>
	<td><a href="#" onclick="addToFilter(this);"><?php echo $row->producer ?></a></td>
	<td><a href="#" onclick="addToFilter(this);"><?php echo $row->articul?></a></td>
	<td><a href="#" onclick="addToFilter(this);"><?php echo $row->name?></a></td>
	<td><?php echo $show_price?></td>
	<td><?php echo $show_shiping?></td>
	<td class="basket-count"><?php echo CHtml::numberField(
					'count',
					$row->count,
					array(
					  'size'=>'20',
					  'maxlength'=>10,
					  'class'=>'item-count',
					  'onchange'=>'recalculate(event,'.$row->price.')',
					  'step'=>$row->lot_party
					  )
					);
		?></td>
	<td class="basket-row-sum"><center><b><?php echo $row->price*$row->count?></b></center></td>	
<td class="basket-comment"><?php echo CHtml::textField('comment',   CHtml::decode($row->commnet)); ?></td>
	<td><a href="#" onclick="saveItem(this,'<?php echo $row->id;?>');">Записать</a></td>
	<td><a href="#" onclick="deleteItem(this,'<?php echo $row->id;?>');">Удалить</a></td>
  </tr>
  <?php endforeach; ?>
</table>
<div class="order-button">
  <button id="make-order">Заказать<span id="order-count"> 0 поз.</span></button>
</div>

<script type="text/javascript">
  var item_table;
  $(document).ready(
	function(){
	  item_table = $("#basket-table").DataTable({
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
		"order": [[ 1, 'asc' ]],
		"columns": [
		  { "orderable": false },
		  { "orderable": true },	  
		  { "orderable": true },
		  { "orderable": true },  
		  { "orderable": true },
		  { "orderable": true },
		  { "orderable": true },
		  { "orderable": true },
		  { "orderable": true },
		  { "orderable": false},
		  { "orderable": false},
		  { "orderable": false}
		] 
	  });
	}
  );
  
  function addToFilter(item){	
	if(!item_table){
	  return;
	}
	item_table.search( $(item).text()).draw();	
  }
  
  function recalculate(event,price,step){	
	var cnt = $(event.target).val();
	cnt = Math.ceil(cnt);
	if(cnt<1){
	  cnt = 1;
	  $(event.target).val(1);
	}
	$(event.target).val(cnt);	
	$(event.target).parent().parent().children(".basket-row-sum").html("<center><b>"+cnt*price+"</b></center>");
  }
  
  function saveItem(item,id){
	var parent	= $(item).parent().parent();
	var count	= $(parent).children("td.basket-count").children("input#count").val();
	var comment	= $(parent).children("td.basket-comment").children("input#comment").val();
	
	jQuery.ajax({                
                url: "/index.php?r=basket/changeItem",
                type: "POST",
                data: {
				  id: id,
				  count: count,
				  comment: comment				  
				},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");				  
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });		
  }
  
  function deleteItem(item,id){	
	var parent	= $(item).parent().parent();
	jQuery.ajax({                
                url: "/index.php?r=basket/deleteItem",
                type: "POST",
                data: {
				  id: id				  
				},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");	
				  if(data===""){
					$(parent).remove();
				  }
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });		
  }
  
</script>
