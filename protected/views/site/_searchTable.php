<table class='part-table'>
  <tr class='part-table-head'>
    <th>
      <a onClick='changeSort(2,this);' href="#">Склад</a>
    </th>					
		<th>
      <a onClick="changeSort(3,this);" href="#">Производитель</a>
    </th>					
		<th class="center">
      <a onClick="changeSort(4,this);" href="#">Артикул</a>
    </th>
		<th class="center">
      <a onClick="changeSort(5,this);" href="#">Наименование</a>
    </th>
		<th class="center">
      <a onClick="changeSort(6,this);" href="#">Цена</a>
    </th>
		<th class="center">
      <a onClick="changeSort(7,this);" href="#">Упаковка</a>
    </th>
		<th class="center">
      <a onClick="changeSort(8,this);" href="#">Срок поставки</a>
    </th>
		<th class="center">В корзину</th>
		<th class="right">
      <a onClick="changeSort(9,this)"; href="#">Обновление цен</a>
    </th>					
</tr>

<?php  
  $obj = $model->data();
  var_dump($obj); 
  /*foreach ($obj as $detail) {
    if(!$model->inFilter($detail))
        continue;	
    $hint = '';
    if($detail[10]!=="") {
      $hint = "<span class=\"info\">*<div class=\"info-hint\"><p>$detail[10]</p></div></span>";
    }
    $shiping = Yii::app()->user->convertShiping($detail[8]);
    $price = Yii::app()->user->convertPrice($detail[6]);
		echo "<tr> 
      <td><a href=\"#\" onClick=\"addFilter('Склад',2,'$detail[2]')\">$detail[2]</a>$hint</td>
			<td><a href=\"#\" onClick=\"addFilter('Производитель',3,'$detail[3]')\"> $detail[3]</a></td>
			<td class=\"center\"><a href=\"#\" onClick=\"addFilter('Артикул',4,'$detail[4]')\">       $detail[4]</a></td>
			<td class=\"center\"><a href=\"#\" onClick=\"addFilter('Наименование',5,'$detail[5]')\">  $detail[5]</a></td>
			<td class=\"center\">$price</td>
			<td class=\"center\">$detail[7]</td>
			<td class=\"center\"><a href=\"#\" onClick=\"addFilter('Срок поставки',8,'$shiping')\"> $shiping</a></td>
			<td class=\"center\"><div onClick=\"addToBasket('".json_encode($detail)."');\" class=\"basket\">&nbsp</div></td>
			<td class=\"right\">$detail[9]</td></tr>";			 
  }*/
?>
</table>
