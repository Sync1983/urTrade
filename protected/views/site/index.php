<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name;
?>

<h3>Добро пожаловать на сайт <i>АвтоТехСнаб</i> - Вашего поставщика автомобильных запчастей.<br> Для наших клиентов мы предлагаем:</h3>  
  <style>
	div.head-images {float: left;padding-left: 5%;width: 100%;position: relative;}
	div.head-images div {float: left;width: 30%;background-repeat: no-repeat;background-position-x: 50%;height: 200px;text-align: center;font-family: "Arial" ,sans-serif;font-weight: bold;font-size: 14pt;display:inline-block;}	
	div.head-images>div.quality{background-image: url('/images/qality.png');}
	div.head-images>div.partner{background-image: url('/images/partner.png');}
	div.head-images>div.cert{background-image: url('/images/cert.png');}
	div.head-images>div>span{text-align: center;word-break: keep-all;word-wrap: normal;padding: 0 10px 10px 10px;width: 100%;top:150px;vertical-align: text-bottom;position: relative;}
	div.list-part{top:	  250px;height: 470px;position: relative;}
	div.list-part>div{float: left;}
	div.list-items{top:50px;left:0;right: 640px;height: 468px;position: absolute;z-index: 10;}
	div.list-items>p{padding-left: 60px;text-transform: uppercase;font: 14pt sans-serif;color: #0f547c;}
	div.list-items>ul{top: 25px;list-style-image: url(/images/list_item.png);position: relative;}
	div.list-items>ul li{font-size: 14pt;font-weight: bold;text-align: left;position: relative;}	
	div.love{background-image: url('/images/love.png');width: 636px;height: 468px;left:	70%;margin-left: -318px;position: absolute;z-index: 0;}
	div#content{min-height: 746px;}
  </style>
  <div class="content">
  <div class="head-images">
	<div class = "quality">
	  <span>Поставка оригинальных и неоригинальных запчастей</span>
	</div>
	<div class = "partner">
	  <span>Мы сотрудничаем с более чем 30&minus;ю поставщиками из России, Европы, ОАЭ, Японии</span>
	</div>
	<div class = "cert">
	  <span>Сертификаты качества и гарантия на поставляемую продукцию</span>
	</div>
  </div>  
  
  <div class="list-part">
	<div class="list-items">
	  <p><strong>ПЕРСОНАЛЬНОЕ ОБСЛУЖИВАНИЕ</strong></p>
	  <ul>
		<li><p>Каждый клиент получает персонального менеджера, который занимается всем процессом от получения заявки до выдачи заказа клиенту</p></li>
		<li><p>Максимальная помощь в подборе запчастей, расходных материалов, масел, смазок и спец. жидкостей</p></li>
		<li><p>Быстрый документооборот</p></li>
		<li><p>Бесплатную доставку запчастей по г. Пенза</p></li>
	  </ul>
	</div>  
	<div class="love">&nbsp;</div>
  </div>
</div>