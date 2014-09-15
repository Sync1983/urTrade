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
            $producers = $this->providers->getProducers($part_id);
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial(   'providers/main',
									 array(
                                        'producers'=>$producers,
                                        'model'=>$model),false,true
            ); 
        }   
       Yii::app()->end();
    }
	
	public function actionLoadParts() {
        $model=new RequestForm;
        if(isset($_POST['request-parts'])) {			
            $model->attributes=$_POST['request-parts'];
            
        }
        if(Yii::app()->request->isAjaxRequest){ 
            $part_id  = Yii::app()->request->getPost('part_id'); 
			$producers=	Yii::app()->request->getPost('names'); 
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $parts	= $this->providers->getPartList($part_id,$producers);
			var_dump($parts);
            $this->renderPartial(   'providers/main',
                                    array(
                                        'producers'=>$producers,
                                        'model'=>$model)
            );
        }   
       Yii::app()->end();
    }
}

