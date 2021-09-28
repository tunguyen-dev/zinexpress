<?php

class Persistents_BranchBanks extends Persistents_Core {
    
    private $id                  = 0; 
    public $bank_id              = 0; 
    public $name                 = '';
    public $branch_code          = 0; 
    public $orders               = 0; 
    public $status               = 1;
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}