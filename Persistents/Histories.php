<?php

class Persistents_Histories extends Persistents_Core {
    
    private $id                  = 0; 
    public $dropship_id          = 0; 
    public $pk_id                = 0; 
    public $admin_id             = 0; 
    public $cur_balance          = 0; 
    public $last_balance         = 0;
    public $time                 = 0;
    public $note                 = '';
    public $orders               = 0; 
    public $status               = 1; 
    public $type                 = 0; 
    public $check_unusual        = 0;
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}