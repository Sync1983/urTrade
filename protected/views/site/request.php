<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
/* @var $answer */
/* @var $input*/

$this->pageTitle=Yii::app()->name . ' - Цена и заказ';
$this->breadcrumbs=array(
	'Цена и заказ',
);
?>

<h1>Введите артикул или номер запчасти для поиска</h1>

<div class="form">

<?php echo CHtml::form('','POST',array('id'=>'request-form'));?>	

	<div class="row">		
		<?php echo CHtml::textField('part_id', $model->part_id,array('class'=>'search-input')); ?>
		<?php echo CHtml::ajaxSubmitButton('Найти', $this->createUrl('provider/LoadProducers'), array(
                'type'      =>  'POST',
                'update'    =>  '#answer-table'),
            array(
                'class'=>'search-button',
                'id'=>'submit-button',
                'type' => 'submit') 
			); ?>    
    <?php echo CHtml::error($model,'part_id'); ?>
	</div>

<div class="text">
  <!--<div class="request-filter">
    <h5>Фильтр:</h5>
    <input id="filters" name="filters" type="hidden" value="">
    <input id="sort" name="sort" type="hidden" value="">
  </div>--!>
  
  <div id="answer-table">
    <?php echo $model->getAnswer()?>
  </div>
  
<?php echo CHtml::endForm(); ?>
</div><!-- form -->  
</div>
<script type="text/javascript">
  var ftr_obj = JSON.parse('<?php echo $model->getFilters()?>');
  var ftr_srt = new Object();
  
  makeView(ftr_obj);
  
  function makeView(obj){
    $('div.request-filter').children("p").remove();
    for(var key in obj){    
      var elem = '<p class="request-filter item" id="'+key+'">'+ftr_obj[key].name+": "+ftr_obj[key].value+
               '<img onClick="removeFilter(this);" src="/images/cross.png" style="cursor:pointer;" />'+
               '</p>';      
      $("div.request-filter").append(elem);
    }    
    $('div.request-filter>input[name=filters]').attr('value',JSON.stringify(obj));
  }
  
  function removeFilter(filter) {
    var key = $(filter).parent().attr('id');
    delete ftr_obj[key];
    makeView(ftr_obj);
  }
  
  function addFilter(name,column,value,clear) {
    var change = false;
    for(var key in ftr_obj) {
      var item = ftr_obj[key];
      if(item.column===column){
        item.value = value;
        change = true;
        break;
      }
    }
    if(!change) {
      if(clear) {
        ftr_obj = new Array();
      }
      ftr_obj.push({name:name,value:value,column:column});
    }
    makeView(ftr_obj);
  }
  
  function changeSort(col,item) {
    if(ftr_srt[col]){
      ftr_srt[col] = 1-ftr_srt[col];
			var text = $(item).text();
			text = text.replace(/[<,>]/g,"");
      if(ftr_srt[col]===1){				
				$(item).text(text+">");
      } else {
				$(item).text(text+"<");
      }
    } else {
      ftr_srt = new Object();
      ftr_srt[col] = 1;
			var text = $(item).text();
			text = text.replace(/[<.>]/g,"");
			$(item).text(text+">");
    }
    $('div.request-filter>input[name=sort]').attr('value',JSON.stringify(ftr_srt));
  }
	
	function addToBasket(item) {
		console.log(item);
	}
</script>