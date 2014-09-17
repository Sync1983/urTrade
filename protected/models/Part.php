<?php

class Part extends CModel {
    public $id;
    public $provider;
    
    public $count;
    public $articul;
    public $producer;
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
	  $this->name			=	$name;
	  $this->price			=	$price;
	  $this->shiping		=	$shiping;
	  $this->stock			=	$stock;
	  $this->info			=	$info;
	  $this->update_time	=	$update_time;	  
	  $this->is_original	=	$is_original;	  
	  $this->count			=	$count;	  
	  $this->lot_party		=	$lot_party;	  
	}
    
}
