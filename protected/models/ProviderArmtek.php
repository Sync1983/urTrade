<?php
class ProviderArmtek extends Provider {
  protected $_is_file = true;
  const price_date_name = "ArmtelPriceDate";
  const price_file_name = "ArmtekPriceName";
  
  	
  public function getName() {
    return 'Armtek';
  }
	
  public function __construct($login, $password, $data = null) {
    parent::__construct($login, $password, $data);
    $this->_CLSID	= 659;
    $time = $this->_cache->get(self::price_date_name);	
	$this->_file_name = $this->_cache->get(self::price_file_name);
    if(!$time){
      $time = 0;
    }
    $login = __DIR__."/../../".$login;
    if(!is_dir($login)){
      Yii::log($login." is not directory for loading","error","system.provider_load");
      return;
    }
    try{
      $dir = scandir($login);
    } catch (Error $e){
      Yii::log($e->getMessage(),"error","system.provider_load");
      return;
    }
    $file_name = "";
    foreach($dir as $file){
      if(!strpos($file,".csv")) {
        continue;
      }
      $file_time = filemtime($login."/".$file);
      if($file_time>$time) {
        $time = $file_time;
        $file_name = $login."/".$file;		
      }
    }
    if($file_name) {	  
      $this->loadFile($file_name,$time);
    }
  }
	
  public function loadPart($uid,$part_id,$maker_id) {
	  /* @var $part Part */
	  $part =  parent::loadHashPart(self::PartPrefix.$this->getCLSID()."_".$part_id."_".$maker_id,$uid);	 
	  $part = json_decode($part,true);
	  $part_out = new Part();
	  $part_out->setAttributes($part,false);
	  return $part_out;
	}
	
  public function loadPartList($part_id,$maker_id = null){	
    $maker_id = str_replace("\"", "", $maker_id);    
	  $all = $this->loadCache(self::PartPrefix.$this->getCLSID()."_".$part_id."_".$maker_id);		  
	  $answer = array();		
		foreach ($all as $name=>$item){
		  $answer[$name] = json_decode($item);
		}
    return $answer;	  
	}

  public function loadPartProducer($part_id) {        
		$all = $this->loadCache(self::ProducerPrefix.$this->getCLSID()."_".$part_id);	
		return $all;
  }
    
  protected function loadFile($file,$time){
    $f = fopen($file, "r"); 
    $head = fgetcsv($f,0,";");   //Пропустить первую строчку как возможный заголовок
	//Бренд	  Нормированный Код производителя	  Наименование	  Код производителя	  Код АРМТЕК	Количество	Цена
	//0					  1							  2					3				4					5	  6
    $date = time();
	$this->_cache->set(self::price_date_name,$time);
	$this->_cache->set(self::price_file_name,$file);
    while(!feof($f)){
      $str = mb_convert_encoding(fgets($f),"utf-8","Windows-1251");
      $row = explode("\t", $str);	  
      //$row = fgetcsv($f, 0, ";",false);	  
      if((!isset($row[3]))||(!isset($row[6]))){
        continue;
      }      
      $part_id = $this->clearPartId($row[3]);
      $maker_name = preg_replace("/[^a-zA-Z0-9\s]/", "", $row[0]);
      $maker_id = md5($maker_name); 
	  
      try{
        $this->saveCache(self::ProducerPrefix.$this->getCLSID()."_".$part_id,strval($maker_name),$maker_id);
      }catch (Exception $e){
        Yii::log($e->getMessage(),"error","system.provider_load");
        echo self::ProducerPrefix.$this->getCLSID()."_".$part_id,strval($maker_name);
        continue;
      }
      
      $part = new Part();      
		  $part->setValues(	
							$row[5], 
							$this->getCLSID(), 
							$part_id,
							$maker_name,
							$maker_id,
							$row[2],
							$row[6],
							0,
							"armtek",
							"", 
							$date,
							1,
							$row[5],
							1
			);
      try{		
        $this->saveCache(self::PartPrefix.$this->getCLSID()."_".$part_id."_".$maker_id,$row[5], $part);      
      }catch (Exception $e){
        Yii::log($e->getMessage(),"error","system.provider_load");
        echo self::ProducerPrefix.$this->getCLSID()."_".$part_id,strval($maker_name);
        continue;
      }
    }
    fclose($f);	
    $this->_cache->set(self::price_date_name,$time);
	$this->_cache->set(self::price_file_name,$file);
	$this->_file_name = $file;
	$this->_file_time = $time;
  }
  
}
