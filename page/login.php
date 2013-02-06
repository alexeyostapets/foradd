<?php
class page_login extends Page {
    function init(){
        parent::init();
        
        $form = $this->add('Form',null,'LoginForm');
        $form->setFormClass('vertical');
        $form->addField('line','login');
        $form->addField('password','password');
        $form->addSubmit('Login');
        $form->addButton('Sign up')->js('click')->univ()->location($this->api->getDestinationURL('register/index'));
        
        if($form->isSubmitted()){
        
        	$auth=$this->api->auth;
            
        	$l=$form->get('login');
        	$p=$form->get('password');
        	
        	$enc_p = $auth->encryptPassword($p,$l);
        	// Manually encrypt password
        	if($auth->verifyCredentials($l,$enc_p)){
   				// Manually log-in
   				$auth->login($l);
   				$form->js()->univ()->redirect('index')->execute();
        	} else {
        		$form->getElement('password')->displayFieldError('Incorrect login');
        	}
        }
        
    }
    function defaultTemplate(){
    	return array('page/login');
    }
    
}
