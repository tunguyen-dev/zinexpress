<?php

class Persistents_Admins extends Persistents_Core {
    
    private $id                  = 0; 
    public $name                 = '';
    public $phone                = ''; 
    public $email                = ''; 
    public $salt                 = ''; 
    public $password             = ''; 
    public $permission           = 1; 
    public $key_secret           = ''; 
    public $authenticator        = ''; 
    public $time                 = 0; 
    public $orders               = 0; 
    public $status               = 1;
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}