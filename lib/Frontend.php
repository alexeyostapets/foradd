<?php
class Frontend extends ApiFrontend {
    function init(){
        parent::init();
        $this->dbConnect();
        $this->requires('atk','4.2.0');

        $this->pathfinder->addLocation('.',array(
        		'addons'=>array('atk4-addons'),
        		'php'=>array('shared'),
        		'js'=>'templates/js',
        	))
            ->setParent($this->pathfinder->base_location);
        
        $this->add('jUI');
        
        $this->auth=$this->add('MainAuth');
        
        // Create different menus
        if($this->auth->isLoggedIn()){
        	$this->add('Menu',null,'Menu')
                ->addMenuItem('logout')
            ;
        }else{
        	$this->add('Menu',null,'Menu')
                ->addMenuItem('login')
            ;
        }
        
    }
    
}
