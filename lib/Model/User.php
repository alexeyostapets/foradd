<?php
class Model_User extends Model_Table {
    public $title_filed='email';
    public $table='user';
    function init(){
        parent::init();
        
        $this->addField('email')->mandatory('Cannot be empty');
        $this->addField('password')->display(array('form'=>'password'));

        $this->api->auth->addEncryptionHook($this);
        
        $this->addField('created_at');
        $this->addField('updated_at');
        
        $this->addHook('beforeInsert',function($m,$q){
            $q->set('created_at',$q->expr('now()'));
        });
        
        $this->addHook('beforeSave',function($m){
            $m['updated_at']=date('Y-m-d G:i:s',time());
        });
        
        $this->addHook('beforeInsert',function($m){
            if($m->getBy('email',$m['email'])){
                throw $m
                    ->exception('User with this email already exists','ValidityCheck')
                    ->setField('email');
            }
        });
        
        $this->addHook('beforeModify',function($m){
            if($m->dirty['email'])throw $m
                ->exception('Do not change email for existing user','ValidityCheck')
                ->setField('email');
        });
        
    }
    
}
