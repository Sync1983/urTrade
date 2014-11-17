<?php

class UserPrice extends CActiveRecord {
  
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
	
	public static function getAll(){	  
	  $result = UserPrice::model()->findAll(array(
            'select'=>'id,name,value',
            'condition'=>'uid=:user_id',
            'params'=>array(':user_id'=>Yii::app()->user->getId()),
            'order'=>'id'
        ));	  
	  return $result;
	}
	
	public static function addList($ids,$names,$values) {
	  $table = array();
	  $table_new = array();
	  foreach ($ids as $key=>$value) {
		if($value>0) {
		  $table[$value] = array('name'=>$names[$key],'value'=>$values[$key]);
		}else{
		  $table_new[] = array('name'=>$names[$key],'value'=>$values[$key]);
		}
	  }
	  foreach ($table as $key => $value) {
		$row = UserPrice::model()->findByPk($key);		
		$row->name = $value['name'];
		$row->value= $value['value'];
		$row->save();
	  }
	  foreach ($table_new as $value) {
		$row = new UserPrice;
		$row->uid = Yii::app()->user->getId();
		$row->name = $value['name'];
		$row->value= $value['value'];
		$row->save();
	  }
	}
	
	public static function delItem($id){
	  $row = UserPrice::model()->findByPk(intval($id));
	  if($row->uid!=YII::app()->user->getId()){
		return false;
	  }
	  return $row->delete();	  
	}

	public function tableName() {
        return 'tbl_user_price';
    }
}

