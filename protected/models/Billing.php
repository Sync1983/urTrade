<?php

class Billing extends CActiveRecord {
    public $sum;
    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    
    public function getBalance(){        
        $result = $this->find(array(
            'select'=>'SUM(`value`) as sum',
            'condition'=>'user_id=:user_id',
            'params'=>array(':user_id'=>Yii::app()->user->getId()),
        ));        
        return $result->sum;        
    }
    
    public function getList() {
        $result = $this->findAll(array(
            'select'=>'time,value,type,comment',
            'condition'=>'user_id=:user_id',
            'params'=>array(':user_id'=>Yii::app()->user->getId()),
            'order'=>'time'
        ));        
        $answer = array();
        foreach ($result as $row) {
            $answer[] = array($row->time,$row->value,$row->comment);
        }
        return $answer;                
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_billing';
    }
    
    public function relations()
    {
        return array(
            'user_id'=>array(self::BELONGS_TO, 'User', 'id')            
        );
    }
}

