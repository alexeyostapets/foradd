<?php
class Model_Social extends Model_Table {
    public $title_filed='oauth_type';
    public $table='social';
    function init(){
        parent::init();
        
        $this->addField('oauth_type')->mandatory('Cannot be empty');
        $this->addField('token');

        $this->hasOne('User','user_id','email');
    }
    
}
