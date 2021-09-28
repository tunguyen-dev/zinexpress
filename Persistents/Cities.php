<?php

class Persistents_Cities extends Persistents_Core {
    
    private $id                  = 0; 
    public $name                 = '';
    public $code                = ''; 
    public $best_id            = 0; 
    public $region                = 0; 
    public $orders             = 0; 
    public $status             = 0;
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}