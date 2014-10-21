<?php
$this->pageTitle=Yii::app()->name . ' - Прайсы';
$this->breadcrumbs=array(
	'Прайсы',
);
?>

<?php foreach ($list as $id => $provider):
	  /* @var $provider Provider */
  ?>
<div class="row"> 
  <p>Последний загруженный прайс</p>
  <p><?php echo $provider->getFileName();?></p>
  <p>В <?php echo date("d:M:Y H:i:s", $provider->getUploadTime());?></p>
</div>  
<div class="row"> 
  <form id="<?php echo "load".$id;?>" enctype="multipart/form-data">	
	<input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
	<input type="file" id="file" name="file" style="width: 50%"/>
  </form>
</div> 
<div class="error" id="answer<?php echo $id;?>">  
</div>
<div class="row"> 
  <?php echo HtmlHelper::AjaxButton("Загрузить прайс ".$provider->getName(), "loadFile($id);");?>
</div>
	
<?php endforeach;?>

<script type="text/javascript">  
  function loadFile(id){
	console.log($('form#load'+id));
	var formData = new FormData($('form#load'+id)[0]);
	var data   = $('form#load'+id).serialize();
	console.log(data,formData);
     $.ajax({
        enctype: 'multipart/form-data',
        url: "/index.php?r=provider/uploadPrice",
		type: "POST",
        data: formData,
		processData: false,
		contentType: false,
		cache: false,
        error: function(xhr,tStatus,e){
		  $(".preloader").removeClass("show");
		},
        success: function(data){
		  $(".preloader").removeClass("show");				  
		  $("div#answer"+id).html(data);				  
		},
		beforeSend:	function(){ 
		  $(".preloader").addClass("show"); 
		} 
    });
  }
</script>

