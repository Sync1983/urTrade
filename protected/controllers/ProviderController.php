<?php

class ProviderController extends Controller {
    
    protected $providers;
    
    public function actions()
	{
		return array(					
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

    public function __construct() {
        $this->providers = new ProviderList();
    }    

	public function actionLoadProducers() {
        $model=new RequestForm;
        if(isset($_POST['request-form'])) {			
            $model->attributes=$_POST['request-form'];
            
        }
        if(Yii::app()->request->isAjaxRequest){ 
            $part_id  = Yii::app()->request->getPost('part_id');
			$part_id  = preg_replace("/[^a-zA-Z0-9\s]/", "", $part_id);
			$model->part_id = $part_id;			
            $producers = $this->providers->getProducers($part_id);			
            $this->renderPartial(   'providers/main',
									 array(
                                        'producers'=>$producers,
                                        'model'=>$model)
            ); 
        }   
		Yii::app()->end();
    }
	
	public function actionLoadParts() {
        $model=new RequestParts();
        if(isset($_POST['request-parts'])) {			
            $model->attributes=$_POST['request-parts'];
            
        }
        if(Yii::app()->request->isAjaxRequest){ 
            $model->part_id	  = Yii::app()->request->getPost('part_id'); 
			$model->part_id  = preg_replace("/[^a-zA-Z0-9\s]/", "", $model->part_id);
			$model->maker	  =	Yii::app()->request->getPost('maker');			
			$model->cross	  =	intval(Yii::app()->request->getPost('cross')=="true");
			$model->price_add = intval(Yii::app()->request->getPost('price_add'));
			$price = 0;
			if($model->price_add>0) {
			  $row = UserPrice::model()->findByPk($model->price_add);
			  if($row){
				$price = $row->value;
			  }
			}
            $parts	= $this->providers->getPartList($model);
            $this->renderPartial(   'providers/table',
									 array(
                                        'part_list'=>$parts,
										'price'	=> $price,
										'model'=>$model)
            );
        }   
       Yii::app()->end();
    }
	
	public function actionUploadPrice(){
	  if(!Yii::app()->request->isAjaxRequest){
		echo "Use only as AJAX request";
		Yii::app()->end();
		return;		
	  }
	  if(!isset($_FILES["file"])||!isset($_POST['id'])){
		echo "Undefined \"file\"";
		Yii::app()->end();
		return;				
	  }
      $file = $_FILES["file"];
	  $id = intval(Yii::app()->request->getPost("id"));
	  $provider_list = new ProviderList();
	  $provider = $provider_list->getProviderByCLSID($id);
	  /* @var $provider Provider */
	  $file_name = $provider->getFileName();
	  var_dump($provider);
	  /*$uploadfile = $uploaddir . basename($_FILES['file']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}*/
var_dump($_POST);
	  
	  
      Yii::app()->end();
	}
}

