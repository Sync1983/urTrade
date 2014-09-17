<?php
$this->pageTitle=Yii::app()->name . ' - Баланс';
$this->breadcrumbs=array(
	'Баланс',
);
?>
<table class="billing-table">
  <caption><h3>Ваши платежи</h3></caption>
  <thead>
    <tr>
      <td class="center">Дата платежа</td>
      <td class="center">Сумма</td>
      <td class="center">Комментарий</td>      
    </tr>    
  </thead>
  <tbody>
    <?php
        $list = $billing->getList();
        foreach ($list as $row) {
            if($row[1]>0)
                $class = "";
            else
                $class = "class=\"negative\"";
            echo "<tr $class>".
                    "<td class=\"center\" style=\"width:15%\">$row[0]</td>".
                    "<td class=\"center\" style=\"width:30%\">$row[1] руб.</td>".
                    "<td class=\"center\">$row[2]</td>".
                 "</tr>";             
        }
    ?>
  </tbody>
</table>




