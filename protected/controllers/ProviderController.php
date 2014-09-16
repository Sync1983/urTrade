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
            $this->renderPartial(   'providers/main',
									 array(
                                        'producers'=>$producers,
                                        'model'=>$model)
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
			$maker=	Yii::app()->request->getPost('maker');			
            $parts	= $this->providers->getPartList($part_id,$maker);			
            $this->renderPartial(   'providers/table',
                                    array(
										'part_id' => $part_id,										
                                        'part_list'=>$parts,
										'model'=>$model)
            );
        }   
       Yii::app()->end();
    }
}

