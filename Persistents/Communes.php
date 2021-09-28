<?php

class Persistents_Communes extends Persistents_Core {
    
    private $id                  = 0; 
    public $name                 = '';
    public $code                 = ''; 
    public $dis_code             = ''; 
    public $best_id             = 0; 
    public $orders             = 0; 
    public $status             = 0; 
    public $code_jt             = ""; 
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}