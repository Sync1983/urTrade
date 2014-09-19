<?php

class Part extends CModel {
    public $id;
    public $provider;
    
    public $count;
    public $articul;
    public $producer;
	public $maker_id;
    public $name;
    public $price;
    public $shiping;
    
    public $stock;    
    public $info;
    public $update_time;
	public $is_original;
	public $lot_party;
	
	public function attributeNames() {
	  return array(
			  "id",
			  "provider",
			  "articul",
			  "producer",
			  "maker_id",
			  "name",
			  "price",
			  "shiping",
			  "stock",  
			  "info",
			  "update_time",
			  "is_original",
			  "count",
			  "lot_party"
	  );
	}
	
	public function setValues($id,
							  $providerCLSID,
							  $articul,
							  $producer,
							  $maker_id,
							  $name,
							  $price,
							  $shiping,
							  $stock,
							  $info,
							  $update_time,
							  $is_original,
							  $count,
							  $lot_party) {
	  $this->id				=	$id;
	  $this->provider		=	$providerCLSID;
	  $this->articul		=	$articul;
	  $this->producer		=	$producer;
	  $this->maker_id		=	$maker_id;
	  $this->name			=	$name;
	  $this->price			=	$price;
	  $this->shiping		=	$shiping;
	  $this->stock			=	$stock;
	  $this->info			=	$info;
	  $this->update_time	=	$update_time;	  
	  $this->is_original	=	$is_original;	  
	  $this->count			=	$count;	  
	  $this->lot_party		=	(!$lot_party)?1:$lot_party;	  
	}
	
	public function getDataForBasket(){
	  return array(
				"uid"		=> Yii::app()->user->getId(),		
				"part_uid"	=> $this->id,		
				"provider"	=> $this->provider,	
				"articul"	=> $this->articul,
				"producer"	=> $this->producer,
				"name"		=> $this->name,	
				"price"		=> $this->price,	
				"shiping"	=> $this->shiping,
				"stock"		=> $this->stock,					
				"is_original"=> $this->is_original,				
				"lot_party"	=> $this->lot_party,			  
	  );
	}
    
}
