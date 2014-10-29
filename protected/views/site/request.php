<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Цена и заказ';
$this->breadcrumbs=array(
	'Цена и заказ',
);
?>

<h1>Введите артикул или номер запчасти для поиска</h1>

<div class="form">

<?php echo CHtml::form('','POST',array('id'=>'request-form'));
	  $prices = array(0=>'Без наценки');
	  foreach ($prices_list as $row) {
		$prices[$row['id']] = $row['name']." ( ".$row['value']."% )";
	  }
?>	

	<div class="query-row" style="float: left">		
		<?php echo CHtml::textField('part_id', $model->part_id,array('class'=>'search-input')); ?>		
		<?php echo CHtml::ajaxSubmitButton('Найти', $this->createUrl('provider/LoadProducers'), array(
                'type'      =>  'POST',
                'update'    =>  '.producer-list',
				'beforeSend' => 'beforeSend',
				'complete' => 'function(){
				  $(".preloader").removeClass("show");}',),
            array(
                'class'=>'main-button search-button',
                'id'=>'submit-button',
                'type' => 'submit') 
			); ?>    
		<?php echo CHtml::activeCheckBox($model,'cross',array('value'=>$model->cross));
			  echo CHtml::activeLabel($model,'cross',array('label'=>'Аналоги')); ?>
		<?php echo CHtml::activeLabel($model,'price_add',array('label'=>'Уровень цен:'));
			  echo CHtml::dropDownList('price_add', $model->price_add,$prices); ?>		
		<?php echo CHtml::error($model,'part_id'); ?>
	</div>
  
<?php echo CHtml::endForm(); ?>
</div><!-- form -->  
<h5>Общий баланс: <?php echo Billing::model()->getBalance();?> руб. Доступно для заказа: <?php echo Billing::model()->getCreditBalance()+Billing::model()->getBalance();?> руб.</h5>

<div id="answer-table">
  
</div>

<div class="producer-list">
  <ul>
  </ul>
</div>


<script type="text/javascript">
  var table;
  
  function beforeSend(){	
	$("#answer-table").html("<h4>Выберите производителя</h4>");
	$(".producer-list").html("");
	$(".preloader").addClass("show");
  }
  
  function addToFilter(item){	
	if(!table){
	  return;
	}
	table.search( $(item).text()).draw();	
  }
  
  function addToSearch(item){		
	$(".search-input").val(item);
	$(".search-button").click();
  }
  
  function insertAnswer(answer){	
	$("#answer-table").html(answer);
	table = $("#part-items").DataTable({
	  paging: false,
	  "order": [[ 0, 'asc' ], [ 3, 'asc' ]],
	  language: {
        search: "Найти в таблице:"
	  }
	});
  }
  
  function load(name,part_id){
	var cross = $("#RequestForm_cross").attr("checked");
	var price = $("#price_add").val();
	jQuery.ajax({                
                url: "/index.php?r=provider/LoadParts",
                type: "POST",
                data: {
				  part_id: part_id,
				  maker: name,
				  cross: cross==="checked",
				  price_add: price
				},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");
				  insertAnswer(data);
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });	
  }
  
  function ProducerSelect(event,parent,part_id) {	
	var target	= event.target;	
	var name = $(target).attr("id");
	$(parent).children("li").removeClass("active");
	$(target).addClass("active");
	load(name,part_id);
  }
  
  function AddToBasket(part_id,maker_id,provider,uid,parent){
	function answer(data){	  	
	  $(parent).parent().html(data);
	}
	
	jQuery.ajax({                
                url: "/index.php?r=basket/Add",
                type: "POST",
                data: {
				  provider: provider,
				  part_id :	part_id,
				  maker_id:	maker_id,
				  uid	  : uid
				},
                error: function(xhr,tStatus,e){},
                success: function(data){
				  $(".preloader").removeClass("show");
				  answer(data);
				},
				beforeSend:	function(){ 
				  $(".preloader").addClass("show"); 
				}
    });	
  }
</script>