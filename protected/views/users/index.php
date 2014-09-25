<?php
$this->pageTitle=Yii::app()->name . ' - Управление клиентами';
$this->breadcrumbs=array(
	'Управление клиентами',
);
?>
 <ul id="tabs">
    <li page="#page1">Управление</li>
    <li page="#page2">Заказы</li>    
 </ul>
<div id="content"> 
  <div id="page1">
	<h6>Список пользователей</h6>
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
  <div id="page2">
	<h6>Управление заказами</h6>
  </div>
</div><!-- context -->


<script type="text/javascript">
  var selected_id = -1;
  var last_action = -1;
  var tabs = [];
  
  $(document).ready(function(){
	$("ul.treeview").each(function(index,item){
	  $(item).children("li.tree-node").each(
		function(child_index,child){
		  $(child).children("a").on("click",null,onSelectTreeItem);
		  $(child).children("ul").children("li").on("click",null,onSelectItem);
		}
	  );
	});
	initTabs();
  });
  
  function initTabs(){
	$("ul#tabs").children("li").each(
	  function(index,item){
		var tab_id = $(item).attr("page");		
		if(!tab_id){
		  return;
		}		
		$("div#content>div"+tab_id).css('display',"none");		
		tabs[index]={item:item,name:tab_id};
		tabs[tab_id]={item:item,name:tab_id};
		$(item).on("click",tabClick);
	  }
	);
	$("div#content>div"+tabs[0].name).css('display','block');
  }
  
  function tabClick(event){
	var target = event.target;	
	var id = $(target).attr('page');	
	for(var index in tabs){
	  item = tabs[index];
	  if(item.name!==id){
		$("div#content>div"+item.name).css('display','none');
	  } else {
		$("div#content>div"+item.name).css('display','block');		
	  }
	}
  }
  
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
	selected_id = item_id;
	last_action = action;
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
  
  
  function ajaxSend(id,addr,not_update){
	var data = {};
	data['id']=selected_id;
	
	$("form"+id).find("input").each(
	  function(index,item){
		var name = $(item).attr('name');
		var value= $(item).attr('value');		
		data[name]=value;
	  }
	);	
	
	jQuery.ajax({                
                url: addr,
                type: "POST",
                data: data,
                error: function(xhr,tStatus,e){
				  $(".preloader").removeClass("show");
				},
                success: function(data){
				  $(".preloader").removeClass("show");
				  if(!not_update){
					$("div#active-context").html(data);
				  }
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });	
  }
</script>

