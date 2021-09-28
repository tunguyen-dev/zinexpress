<?php

class Persistents_WareHouses extends Persistents_Core {
    
    private $id                  = 0; 
    public $user_id              = 0;
    public $name                 = ''; 
    public $phone                = ''; 
    public $address              = ''; 
    public $city                 = '';  
    public $district             = ''; 
    public $commune              = ''; 
    public $primary_selec        = 0; 
    public $time_created         = 0; 
    public $orders               = 0; 
    public $status               = 1;
    
    
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}