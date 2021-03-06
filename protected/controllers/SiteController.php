<?php

class SiteController extends Controller
{
    protected $billing;
    /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(		
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			/*if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                              	Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}*/
		}
		$this->render('contact',array('model'=>$model));
	}
	
	public function actionCooperation() {
	  $this->render('cooperation');
	}
  	
	public function actionLogin()
	{
		$model=new LoginForm;

		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	public function actionSettings() {
	  $model = new SettingsForm();
	  $info	 = UserInfo::load();
	  $prices = UserPrice::getAll();
	  
	  if(!Yii::app()->request->isAjaxRequest) {
		if(isset($_POST['SettingsForm'])) {
		  $model->setAttributes($_POST['SettingsForm'],false);		
		  if($model->validate()){
			$model->save();
		  }		
		}else {
		  $model->setAttributes($info->attributes,false);
		}
	  }else{		
		$ids = $_POST['ids'];
		$names = $_POST['names'];
		$values = $_POST['values'];
		UserPrice::addList($ids, $names, $values);
		$prices = UserPrice::getAll();
		$this->renderPartial('settings_prices_list', array('prices'=>  $prices,'model'=>$model));
		Yii::app()->end();
		return;
	  }
	  $prices_text = $this->renderPartial('settings_prices_list', array('prices'=>  $prices,'model'=>$model),true);
	  
	  $this->render('settings',array(
			  'model' =>  $model,
			  'prices'=>  $prices_text));
	}
	
	public function actionDelPricesLine(){
	  if(Yii::app()->request->isAjaxRequest) {
		$model = new SettingsForm();
		$info	 = UserInfo::load();
		$model->setAttributes($info->attributes,false);
		
		$id = intval($_POST['id']);
		if(!UserPrice::delItem($id)){
		  echo "Error";
		  Yii::app()->end();
		  return;
		} else {
		  $prices = UserPrice::getAll();
		  $this->renderPartial('settings_prices_list', array('prices'=>  $prices,'model'=>$model));
		  Yii::app()->end();
		  return;
		}
	  }
	  echo "Use AJAX query";
	  Yii::app()->end();
	}

	public function actionLogout() {
	  Yii::app()->user->logout();
	  $this->redirect(Yii::app()->homeUrl);
	}

  public function actionRequest() {
	$model=new RequestForm;		
	$prices = UserPrice::getAll();

	if(isset($_POST['RequestForm'])) {			
	  $model->attributes=$_POST['RequestForm'];	
	}
	Yii::app()->clientScript->registerPackage('datatable_q');
	$this->render(  'request',array('model'	  =>  $model,'prices_list'=>$prices));
  }

  public function actionBilling() {
	Yii::app()->clientScript->registerPackage('datatable_q');
    $this->render('billing',array('list'=>  Billing::model()->getList()));    
  }
  
  public function actionPrices(){
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
	$providers = new ProviderList();
	$file_provider = $providers->getFileProvider();
	Yii::app()->clientScript->registerPackage('datatable_q');
	$this->render('/prices/prices',array('list'=>$file_provider));    
  }
  
}
