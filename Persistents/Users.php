<?php

class Persistents_Users extends Persistents_Core {
    
    private $id                  = 0; 
    public $shop_name            = '';
    public $phone                = ''; 
    public $email                = ''; 
    public $salt                 = ''; 
    public $password             = '';  
    public $key_secret           = ''; 
    public $authenticator        = ''; 
    public $identity_card        = ''; 
    public $bank_id              = 0; 
    public $branch_id            = 0; 
    public $acc_number           = ''; 
    public $acc_name             = ''; 
    public $time_created         = 0; 
    public $orders               = 0; 
    public $status               = 1;
    public $config_note_select   = 1;
    public $config_note_text     = "";
    public $config_payer         = 1;
    public $balance              = 0;
    public $fee_cod              = 1;
    public $fee_insurance        = 1;
    public $free_return          = 1;
    public $same_price           = 0;

    function getId() {
    	return $this->id;
    }

    function getClassName() {
        return __CLASS__;
    }
}