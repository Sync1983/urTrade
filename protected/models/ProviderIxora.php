<?php
class ProviderIxora extends ProviderController {
    protected $_contract_id="";
    
    public function loadPartList($part_id) {
        throw new Exception("Use parent method");
    }
    
    public function loadPartProducer($part_id) {
        throw new Exception("Use parent method");
    }
}
