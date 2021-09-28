<?php

class Persistents_NotificationAdmins extends Persistents_Core {
    
    private $id                  = 0;
    public $user_id              = 0; 
    public $pk_id                = 0; 
    public $function                = ''; 
    public $description          = ''; 
    public $link                 = ''; 
    public $seen                 = 0; 
    public $time_created         = 0; 
    public $time_seen            = 0;
    public $orders               = 0; 
    public $status               = 0; 
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}