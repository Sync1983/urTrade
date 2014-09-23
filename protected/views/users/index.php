<?php
$this->pageTitle=Yii::app()->name . ' - Управление клиентами';
$this->breadcrumbs=array(
	'Управление клиентами',
);
?>

<h6>Список пользователей</h6>
<div id="content">
  <div id="page1">
	<ul class="treeview">
	<?php  foreach ($info as $id=>$user):?>
	<li class="tree-node" id="<?php echo $id;?>">
	  <a href="#" class="tree-line-head">
		<?php echo $user->name." (".$id.":".$uids[$id].")";?>	  
	  </a>
	  <ul>
		<li id="main">Общие данные</li>	  
		<li id="extend">Расширенная информация</li>	  
		<li id="basket">Корзина</li>
		<li id="order">Заказы</li>
		<li id="billing">Баланс</li>
	  </ul>	  
	</li>
	<?php endforeach;?>
	</ul>  
	<div id="active-context">
	  &nbsp;
	</div>
  </div>
</div><!-- context -->

<script type="text/javascript">
  function onSelectTreeItem(event){
	var target = event.target;
	var parent = $(target).parent().parent();
	$(parent).children("li.tree-node").removeClass("active");
	$(target).parent().addClass("active");	
  };
  
  function onSelectItem(event){
	var target = event.target;
	var parent = $(target).parent().parent();
	var action = $(target).attr("id");
	var item_id= $(parent).attr("id");
	$(parent).children("ul").children("li").removeClass("active");
	$(target).addClass("active");
	jQuery.ajax({                
                url: "/index.php?r=users/"+action,
                type: "POST",
                data: {id:item_id},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");				  
				  $("div#active-context").html(data);				  
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });	
  }
  
  $(document).ready(function(){
	$("ul.treeview").each(function(index,item){
	  $(item).children("li.tree-node").each(
		function(child_index,child){
		  $(child).children("a").on("click",null,onSelectTreeItem);
		  $(child).children("ul").children("li").on("click",null,onSelectItem);
		}
	  );
	});
  });
</script>

