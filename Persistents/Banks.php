<?php

class Persistents_Banks extends Persistents_Core {
    
    private $id                  = 0; 
    public $name                 = '';
    public $orders               = 0; 
    public $status               = 1; 
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}