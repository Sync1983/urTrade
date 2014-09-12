<?php

class BillingController extends Controller {
    
	public function actions()
	{
		return array(		
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionGetUserBalance() {
        if(Yii::app()->request->isAjaxRequest){
            $billing = new Billing();
            $value = $billing->getBalance();
            $this->render('balance',array('value'=> $value));
        }		
	}	
    
}
