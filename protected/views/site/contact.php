<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Контакты';
$this->breadcrumbs=array(
	'Контакты',
);
?>

<h1>Связаться с нами</h1>
<style type="text/css">
  a.email{
	height: 64px;
	top:-15px;
	padding-left: 10px;
	position: relative;
  }
  span.email{
	position: relative;
	top: -25px;
	padding-left: 10px;
	height: 40px;
	font-weight: bold;
	font-size: 15pt;
  }
  span.email>h5{
	position: relative;	
	padding-left: 20px;
	font-size: 12pt;
	height: 10px;
  }
  .rek-table{
	left:20px;
	width: 50%;
	text-align: center;
	position: relative;
  }
  .rek-table tr:nth-child(even){
	 background: #DEF;
  }
</style>

<div class="form">
  <div style="height: 100px;">
	<h4>По телефонам:</h4>
	<span class="email">
	<h5>+7 (8412) 763-533</h5>
	<h5>+7 (8412) 518-302</h5>
	</span>
  </div>
  <div style="height: 80px;">
	<h4>По электронной почте:</h4>	
	<a class="email" href='mailto:sales@atc58.ru'><img src='/images/email.png' name='sales@atc58.ru'><span class='email'>sales@atc58.ru</span></a>		
  </div>
  <div class="row">
	<h4>С помощью Skype:</h4>	
	<a class="email" href='skype:atc_58?chat'><img src='/images/skype.png' style="margin-top:5px" height="48" name='sales@atc58.ru'><span class='email' style="top:-20px;">АвтоТехСнаб(atc_58)</span></a>		
  </div>
<table class="rek-table">  
    <tr><td colspan="2" style="text-align: center;padding: 0;"><p class = "page-header">Если Вы желаете работать с нами по <strong>безналичному расчёту</strong>, воспользуйтесь нашими реквизитами:</p></td></tr>
    <tr><td class="data">Название</td>     <td class="info_td">ООО "АвтоТехСнаб"</td></tr>
    <tr><td class="data n">ОГРН</td>       <td class="info_td n">1145837001562</td></tr>     
    <tr><td class="data">ИНН</td>          <td class="info_td">5837059930</td></tr> 
    <tr><td class="data n">КПП</td>        <td class="info_td n">583701001</td></tr> 
    <tr><td class="data">Р/С</td>          <td class="info_td">40702810715000002232</td></tr>
    <tr><td class="data n"></td>           <td class="info_td n">в Пензенском РФ ОАО Россельхозбанк</td></tr>  
    <tr><td class="data">Банк</td>         <td class="info_td">440018, г.Пенза, ул.Бекешская, 39</td></tr> 
    <tr><td class="data n">БИК</td>        <td class="info_td n">045655718</td></tr>
    <tr><td class="data">ИНН Банка</td>    <td class="info_td">7725114488</td></tr>
    <tr><td class="data n">КПП Банка</td>  <td class="info_td n">583602001</td></tr>
    <tr><td class="data">ОГРН Банка</td>   <td class="info_td">1027700342890</td></tr>    
    <tr><td class="data n">К/С</td>        <td class="info_td n">30101810600000000718</td></tr> 
    <tr><td class="data"></td>             <td class="info_td">в ГРКЦ ГУ Банка России по Пензенской обл.</td></tr>
  </table>  
</div>
