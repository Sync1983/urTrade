<?php
$this->pageTitle=Yii::app()->name . ' - Управление заказами';
$this->breadcrumbs=array(
	'Управление заказами',
);
$classes = array(
		0 => "wait",
		1 => "in-work",
		2 => "in-place",
		3 => "recived",
		4 => "depr");
?> 
<div id="content">

<div id="toolbar" class="ui-widget-header ui-corner-all">
  <?php echo HtmlHelper::AjaxButton("Все", "changeFilter(-1,this)");
		foreach ($states as $key=>$value)
		  echo HtmlHelper::AjaxButton($value, "changeFilter('$value',this)");
  ?>  
</div>  
  
<table class="dataTable" id="order-ctrl-table">
  <thead>		
	<th class="dt-head-center" style="width: 1%;"></th>		
	<th class="dt-head-center" style="width: 1%;">Номер заказа</th>
	<th class="dt-head-center" style="width: 1%;">Состояние</th>		
	<th class="dt-head-center" style="width: 1%;">Дата ожидания</th>	
	<th class="dt-head-center" style="width: 15%;">Поставщик</th>	
	<th class="dt-head-center" style="width: 25%;">Деталь</th>		
	<th class="dt-head-center" style="width: 7%;">Цена, руб</th>	
	<th class="dt-head-center" style="width: 1%;">Доставка</th>		
	<th class="dt-head-center" style="width: 1%;">Ориг</th>		
	<th class="dt-head-center" style="width: 1%;">Кол-во</th>	
	<th class="dt-head-center" style="width: 10%;">Комментарий</th>	
  </thead>
  <tbody>
  <?php foreach ($orders as $row):
	  /** @var $row Orders **/	  
	  $show_date = date("d-m-y <br> H:i:s", $row->date);	  
	 ?>
	  <tr class = "<?php echo $classes[$row->state];?>" id="<?php echo $row->id;?>">
		<td class="dt-body-center underline">
		  <a href="#" onclick="showControl(this,<?php echo $row->id?>)"><img src="/images/settings.png" width="16px" height="16px"/></a>
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
	  </tr>
  <?php  endforeach; ?>
  </tbody>
</table>
</div>

<div id="control-window">
  <h5>Управление записью <a href="#">Закрыть</a></h5>
  <div id="content" style="padding-top: 1px;">
	<div class="row">
	  <?php echo CHtml::label("ID", "id",array('value'=>'Состояние'));?>
	  <?php echo HtmlHelper::span("id", "id");?>
	</div>  
	<div class="row">
	  <?php echo CHtml::label("Состояние", "states",array('value'=>'Состояние'));?>
	</div>  
	<div class="row">  
	  <?php echo CHtml::dropDownList(
		  "states",
		  -1,
		  $states,
		  array("style"=>("width:100%;"))
		  );?>
	</div>  
	<div id="row">
	  <?php echo CHtml::label("Дата ожидания", "publishDate");?>
	</div>
	<div id="row">
	<?php
	  $this->widget('zii.widgets.jui.CJuiDatePicker',array(
	  'name'=>'publishDate',    
	  'flat'=>true,
	  'language'=>'ru',
	  'options'=>array(		
		  'autoSize'=>true,
		  'showButtonPanel'=>true,
		  'dateFormat' => 'dd-mm-yy'
	  ),
	  'htmlOptions'=>array(
		  "style"=>("width: 80%;"),
	  ),
	  ));
	?>
	</div>
	<div id="row">
	  <?php echo CHtml::label("Цена заказа:&nbsp&nbsp", "price");
		echo CHtml::numberField("price");
	  ?>
	</div>	
	<div id="row">
	  <?php echo CHtml::label("Цена клиента:", "user_price");
		echo CHtml::numberField("user_price",'',array('disabled'=>true,'style'=>'right:100%'));
	  ?>
	</div>	
  </div>
  <div class="footer">
	<center>
	<?php echo HtmlHelper::AjaxButton("Сохранить", "changeFilter('$value',this)");
	  echo HtmlHelper::AjaxButton("Отмена", "changeFilter('$value',this)");
	?>	  
	</center>
  </div>
</div>

<script type="text/javascript">
	var classes = [];
	var o_table;
	classes[0] = "wait",
	classes[1] = "in-work",
	classes[2] = "in-place",
	classes[3] = "recived",
	classes[4] = "depr";
	
	$(document).ready(
	function(){	  
	  o_table = $("#order-ctrl-table").DataTable({
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
		  { "orderable": false}		    
		] 
	  });
	});
	
	function changeFilter(value,item){
	  var id = $(item).attr('id');
	  $("#toolbar").children().each(function(id,button){
		$(button).removeClass("active");
	  });
	  $(item).addClass("active");
	  if(value!==-1)
		o_table.columns(2).search(value).draw();
	  else
		o_table.columns(2).search("").draw();
	}
	
	function showWindow(id,state,date,price,over_price){	  
	  $("span[name=id]").text(id+date);
	  var js_date = new Date(date);	
	  $('input#publishDate').val(js_date);
	  $('input#publishDate').datepicker( "setDate",js_date);
	  $('input#publishDate').datepicker( "refresh" );
	}
	
	
	
	function showControl(item,id){
	  function onAnswer(data){
		data = JSON.parse(data);
		console.log(data);
		showWindow(1,1,data.date);
	  };
	  
	  jQuery.ajax({                
                url: "/index.php?r=users/getOrderData",
                type: "POST",
                data: {id:id},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");
				  if(data)
					onAnswer(data);				  
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
	  });	
	}
	
	function saveItem(id,name){
	  var state = $("select#"+name).val();
	  var item = $("select#"+name).parent().parent();
	  jQuery.ajax({                
                url: "/index.php?r=users/changeOrderState",
                type: "POST",
                data: {id:id,state:state},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");				  
				  if(data){
					$(item).html(data);					
				  }
				  $(item).removeClass().addClass(classes[state]);
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
	  });	
	}
</script>