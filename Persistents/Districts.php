<?php

class Persistents_Districts extends Persistents_Core {
    
    private $id                = 0; 
    public $name               = '';
    public $code               = ''; 
    public $citi_code          = ''; 
    public $district_id        = 0; 
    public $best_id            = 0; 
    public $region_dis         = "";
    public $region             = "";
    public $orders             = 0; 
    public $status             = 0;
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}