<?php 
    /* @var $this Controller */ 
    /* @var $billing*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta charset="utf-8"> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dataTables.css" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
	  <div id="logo"><span class="right"><?php echo CHtml::encode(Yii::app()->name); ?><br><h6>+7 (8412) 763-533 &nbsp;   <a href="mailto:sales@atc58.ru">sales@atc58.ru</a></h6><h6>+7 (8412) 518-302</h6></span></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Главная', 'url'=>array('/site/index')),
				array('label'=>'Цена и заказ', 'url'=>array('/site/request')),
                array('label'=>'Управление клиентами', 'url'=>array('/users/index'), 'visible'=>Yii::app()->user->isAdmin()),				
                array('label'=>'Управление заказами', 'url'=>array('/users/ordersCtrl'), 'visible'=>Yii::app()->user->isAdmin()),				
                array('label'=>'Корзина ('.Basket::getBasketPrice().' руб.)', 'url'=>array('/basket/basket'), 'visible'=>((!Yii::app()->user->isAdmin()))&&(!Yii::app()->user->isGuest), 'visible'=>!Yii::app()->user->isGuest&&!Yii::app()->user->isAdmin()),
				array('label'=>'Заказы('.Orders::getOrdersPrice().' руб.)', 'url'=>array('/orders/orders'), 'visible'=>((!Yii::app()->user->isAdmin()))&&(!Yii::app()->user->isGuest), 'visible'=>!Yii::app()->user->isGuest&&!Yii::app()->user->isAdmin()),
                array('label'=>'Баланс ('.Billing::model()->getBalance().' руб.)', 'url'=>array('/site/billing'), 'visible'=>!Yii::app()->user->isGuest&&!Yii::app()->user->isAdmin()),
				array('label'=>'Прайсы','url'=>array('/site/prices'), 'visible'=>Yii::app()->user->isAdmin()),
				array('label'=>'Параметры', 'url'=>array('/site/settings'), 'visible'=>!(Yii::app()->user->isGuest||Yii::app()->user->isAdmin())),
				array('label'=>'Сотрудничество', 'url'=>array('/site/cooperation'),'visible'=>!Yii::app()->user->isAdmin()),
				array('label'=>'Контакты', 'url'=>array('/site/contact'),'visible'=>!Yii::app()->user->isAdmin()),
				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by ATC.<br/>				
	</div><!-- footer -->

</div><!-- page -->
<div class="preloader">
  &nbsp;
</div>
</body>
</html>
