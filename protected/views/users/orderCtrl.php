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
$states = array(
			0 => 'Ожидает заказа',
			1 => 'Заказан',
			2 => 'На складе',
			3 => 'Выдан',
			4 => 'Отказ'		
	);
?> 
<div id="content">
<table class="dataTable">
  <thead>		
	<th class="dt-head-center" style="width: 1%;">Состояние</th>		
	<th class="dt-head-center" style="width: 1%;">Дата заказа</th>	
	<th class="dt-head-center" style="width: 15%;">Поставщик</th>	
	<th class="dt-head-center" style="width: 25%;">Деталь</th>		
	<th class="dt-head-center" style="width: 7%;">Цена, руб</th>	
	<th class="dt-head-center" style="width: 1%;">Доставка</th>		
	<th class="dt-head-center" style="width: 1%;">Ориг</th>		
	<th class="dt-head-center" style="width: 1%;">Кол-во</th>	
	<th class="dt-head-center" style="width: 10%;">Комментарий</th>	
  </thead>
  <tbody>
  <?php foreach ($orders as $list_id=>$rows): ?>
    <tr class="order-row">
	  <td colspan="10" class="full-border">Заказ № <?php echo sprintf("%07d", $list_id); ?> Заказчик <?php echo $uids[$rows[0]->uid]; ?></td>
	</tr>
	<?php foreach ($rows as $row):
		/** @var $row Orders **/
	  $date = strtotime($row->date);	
	  $show_date = date("d-m-y <br> H:i:s", $date);
	 ?>
	  <tr class = "<?php echo $classes[$row->state];?>">
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
	  </tr>
	<?php endforeach;?>	
  <?php  endforeach; ?>
  </tbody>
</table>
</div>

<script type="text/javascript">
	var classes = [];
	classes[0] = "wait",
	classes[1] = "in-work",
	classes[2] = "in-place",
	classes[3] = "recived",
	classes[4] = "depr";
	
	function selectorChange(item){
	  var row = $(item).parent();
	  row.addClass("changed");
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