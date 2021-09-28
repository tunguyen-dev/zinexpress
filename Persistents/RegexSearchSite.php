<?php

class Persistents_RegexSearchSite extends Persistents_Core {
    
    private $id                  = 0; 
    public $ids_corp                  = '';
    public $codes_corp                 = '';
    public $regex_name_corp                = '';


    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}