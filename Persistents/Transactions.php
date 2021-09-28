<?php

class Persistents_Transactions extends Persistents_Core {
    
    private $id                  = 0; 
    public $tran_id              = '';
    public $dropship_id              = 0; 
    public $dropshipbank_id          = 0; 
    public $image_data           = ''; 
    public $money                = 0; 
    public $time_created         = 0; 
    public $time_success         = 0; 
    public $type                 = 0; 
    public $note                 = ''; 
    public $note_transaction     = ''; 
    public $logs                 = ''; 
    public $status               = 0; 
    public $orders               = 0; 
    
    

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}