<?php
$this->pageTitle=Yii::app()->name . ' - Корзина';
$this->breadcrumbs=array(
	'Корзина',
);
?>
<h6>Позиции</h6>
<table id="basket-table" class="stripe hover">
  <thead>
  <th class="dt-body-left"><input type="checkbox" onchange="selectAll(this);"/></th>
	<th class="dt-head-center" style="width: 5%;">Добавлено</th>
	<th class="dt-head-center" style="width: 5%;">Производитель</th>
	<th class="dt-head-center" style="width: 5%;">Артикул</th>
	<th class="dt-head-center" style="width: 30%;">Название</th>
	<th class="dt-head-center" style="width: 5%;">Цена, руб.</th>
	<th class="dt-head-center" style="width: 5%;">Срок, дн.</th>
	<th class="dt-head-center" style="width: 10%;">Количество</th>
	<th class="dt-head-center" style="width: 5%;">Сумма, руб.</th>
	<th class="dt-head-center" style="width: 15%;">Комментарий</th>	
  </thead>
  <?php foreach ($basket as $row):	
		/* @var $row Basket */
	$show_price = Yii::app()->user->convertPrice($row->price);	
	$show_shiping = Yii::app()->user->convertShiping($row->shiping);	
	$date = strtotime($row->date);
	$date = date("d-m-y H:i:s", $date);
  ?>  
  <tr id="<?php echo $row->id?>">
	<td class="basket-change">
	  <input type="checkbox" name="<?php echo $row->id?>" class="select-item" onchange="selectItem();"/>
	</td>
	<td class=" dt-body-center"><?php echo $date ?></td>
	<td class=" dt-body-center"><a href="#" onclick="addToFilter(this);"><?php echo $row->producer ?></a></td>
	<td class=" dt-body-center"><a href="#" onclick="addToFilter(this);"><?php echo $row->articul?></a></td>
	<td class=" dt-body-center"><a href="#" onclick="addToFilter(this);"><?php echo $row->name?></a></td>
	<td class=" dt-body-center"><?php echo $show_price?></td>
	<td class=" dt-body-center"><?php echo $show_shiping?></td>
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
	<td class="basket-row-sum"><center><b><?php echo $show_price*$row->count?></b></center></td>	
<td class="basket-comment"><input id="comment" type="text" onkeypress="commentChange(this);" value="<?php echo CHtml::decode($row->commnet);?>"</td>	
  </tr>
  <?php endforeach; ?>
</table>
<div class ="action-panel">
  <button id="save-changes" class="main-button" disabled onclick="saveChanges();">Сохранить изменения</button>
  <button id="delete-items" class="main-button" disabled onclick="deleteItems();">Удалить выделенное</button>
</div>	  
<div class="order-button">
  <button id="make-order" class="main-button" disabled onclick="addToOrder();">Заказать <span id="order-count">0</span> поз.</button>
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
		  { "orderable": false}		  
		] 
	  });
	}
  );
  
  function commentChange(item){
	var parent = $(item).parent().parent();
	$(parent).addClass("changed");
	$("button#save-changes").prop('disabled','');
  }
  
  function addToFilter(item){	
	if(!item_table){
	  return;
	}
	item_table.search( $(item).text()).draw();	
  }
  
  function recalculate(event,price,step){	
	var cnt = $(event.target).val();
	cnt = Math.ceil(cnt);
	if(!step){
	  step = 1;
	}
	if(cnt<1){
	  cnt = step;
	  $(event.target).val(step);
	}
	$(event.target).val(cnt);	
	$(event.target).parent().parent().children(".basket-row-sum").html("<center><b>"+cnt*price+"</b></center>");
	$(event.target).parent().parent().addClass("changed");
	$("button#save-changes").prop('disabled','');
  }
  
  function selectAll(item) {
	var checked = $(item).prop("checked");
	$("input.select-item").each(
	  function(index,item){		
		$(item).prop("checked",checked);
	  });
	selectItem();
  }
  
  function selectItem(){
	var selected = 0;
	$("input.select-item").each(
	  function(index,item){		
		if($(item).prop("checked")){
		  selected += 1;
		}
	  });
	if(selected>0) {
	  $("button#delete-items").prop('disabled','');
	  $("button#make-order").prop('disabled','');	  
	} else {
	  $("button#delete-items").prop('disabled','disabled');
	  $("button#make-order").prop('disabled','disabled');	  
	}
	$("span#order-count").text(selected);	
  }
  
  function saveChanges(){
	var data = new Array();
	$("tr.changed").each(function(index,item){
	  var id = $(item).attr("id");
	  var count = $(item).children("td.basket-count").children("input#count").val();
	  var comment = $(item).children("td.basket-comment").children("input#comment").val();
	  data.push({id:id,count:count,comment:comment});
	});
	
	jQuery.ajax({                
                url: "/index.php?r=basket/changeItem",
                type: "POST",
                data: {items:data},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");				  
				  $("tr.changed").removeClass('changed');				  
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });	
  }  
  
  function deleteItems(){
	var selected = [];
	$("input.select-item").each(
	  function(index,item){		
		if($(item).prop("checked")){
		  selected.push($(item).prop("name"));
		}
		//$(item).parent().parent().remove();
	  });
	var cnt = selected.length;
	if(!confirm("Действительно удалить "+cnt+" элементов?")){
	  return;	  
	}
	jQuery.ajax({                
                url: "/index.php?r=basket/deleteItem",
                type: "POST",
                data: {items: selected},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");	
				  $("input.select-item").each(
					function(index,item){		
					  if($(item).prop("checked")){
						$(item).parent().parent().remove();
					  }		
				  });
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });		
  }
  
  function addToOrder(){
	var ids = [];
	$("input.select-item").each(
	  function(index,item){		
		if($(item).prop("checked")){
		  ids.push($(item).prop("name"));		  
		}
	  });
	var cnt = ids.length;
	if(!confirm("Добавить в заказ "+cnt+" позиций?")){
	  return;
	}
	
	jQuery.ajax({                
                url: "/index.php?r=orders/add",
                type: "POST",
                data: {ids: ids},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");
				  if(data === "ok") {
					 location.href = '<?php echo $this->createUrl("orders/orders"); ?>';
				  } else {
					alert(data);
				  }
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });		
	
  }
</script>
